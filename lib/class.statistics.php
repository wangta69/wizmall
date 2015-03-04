<?php
class statistics{

	var $dbcon;
	var $common;
	var $cfg;//외부 $cfg 관련 배열

## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null){//
		if($dbcon) $this->dbcon		= $dbcon;
		if($common) $this->common	= $common;
	}
	
	function get_total_sale_price(){## 현재 등록된 제품에 대한 총 판매액을 표시
		$list = $this->dbcon->get_row("SELECT sum(Hit) as hit, sum(Output)as tqty, sum(Output*Price) as tmount, count(*) as count FROM wizMall");	
		return $list;
	}
	
	function get_pd_sale($pid, $sdate=null, $edate=null){## 제품별 토탈 구매량과 금액을 구한다.(상기보다 좀더 정확한 수치)
		#sdate 조회 시작일, $edate : 조회 완료일(unixtime)
		$whereis = "where pid = '$pid' and ostatus = 50";
		//echo "sdate =  ".date("y.m.d", $sdate)." and edate = ".date("y.m.d", $edate)."<br>";
		if($sdate && $edate) $whereis .= " and wdate between $sdate and $edate";
		$list = $this->dbcon->get_row("select sum(qty) as tqty, sum(tprice) as tmount from wizCart ".$whereis);	
		return $list;
	}

	function get_pd_in($uid, $sdate=null, $edate=null){## 제품별 입고량
		#sdate 조회 시작일, $edate : 조회 완료일(unixtime)
		$whereis = "where Igoodscode = '$uid'";
		if($sdate && $edate) $whereis .= " and Iinputdate between $sdate and $edate";
		$sqlstr = "select sum(Iinputqty) as tqty from wizInputer $whereis";
		$rtn = $this->dbcon->get_one($sqlstr);
		return $rtn;
	}

	function get_cat_line($category, $menushow, $theme, $orderby, $cp){//카테고리를 순차적으로 보여줌
		$len = strlen($category);
		$addurl = $PHP_SELF."?menushow=$menushow&theme=$theme&orderby=$orderby&cp=$cp";
		$rtn = "";
		if($len>6){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '$category'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$addurl."&category=".$category."'><font color='#006633'>$cat_name</font></A>";
		}

		if($len>3){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($category, -6)."'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$addurl."&category=".substr($category, -6)."'><font color='#006633'>$cat_name</font></A>";
		}

		if($len>0){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($category, -3)."'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$addurl."&category=".substr($category, -3)."'><font color='#006633'>$cat_name</font></A>";
		}

		echo $rtn;

	}

	function get_pay_method($pay=null, $action, $add, $mem, $FromDate, $ToDate){
		$whereis = " where OrderStatus=50 ";
		if ($action == "detail_search") {
			$whereis .= " and  BuyDate between $FromDate AND $ToDate";
		}if ($action == "term_search") {
			if($add)  $whereis .= " and RAddress1 LIKE '$add%'";
			if($mem == "member") $whereis .= " and OrderID <> ''";
			else if($mem == "nonmember") $whereis .= " and OrderID = ''";
		}

		//------------------------- 온라인
		if($pay) $whereis .= " and PayMethod='$pay'";
		$sqlstr = "SELECT SUM(TotalAmount),count(*) FROM wizBuyers $whereis";
		$list = $this->dbcon->get_row($sqlstr);
		return $list;
	}

	function get_pay_method1($pay=null, $action, $add, $mem, $FromDate, $ToDate){
		$whereis = " where OrderStatus=50 ";
		if ($action == "detail_search") {
			$whereis .= " and  BuyDate between $FromDate AND $ToDate";
		}

		$whereis .= " and RAddress1 LIKE '$add%'";
		if($mem == "member") $whereis .= " and OrderID <> ''";
		else if($mem == "nonmember") $whereis .= " and OrderID = ''";

		//------------------------- 온라인
		if($pay) $whereis .= " and PayMethod='$pay'";
		$sqlstr = "SELECT SUM(TotalAmount),count(*) FROM wizBuyers $whereis";
		$list = $this->dbcon->get_row($sqlstr);
		return $list;
	}
}