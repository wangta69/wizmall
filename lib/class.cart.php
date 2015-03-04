<?php
class cart{

	var $dbcon;
	var $common;
	var $cfg;//외부 $cfg 관련 배열
	var $op;//기타 활용 변수값(iframe:true,)

## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null){//
		if($dbcon) $this->dbcon		= $dbcon;
		if($common) $this->common	= $common;
	}

	function mkcartcode(){## 장바구니 코드 생성
		if (!$_COOKIE["CART_CODE"]) {
			$MicroTsmp = explode(" ",microtime());
			$START_TIME = $MicroTsmp[0]+$MicroTsmp[1];
			$CART_CODE = substr(str_replace(".", "", $START_TIME), 0, 13); // 장바구니고유코드
			setcookie("CART_CODE",$CART_CODE,0,"/");
		}else{
			$CART_CODE = $_COOKIE["CART_CODE"];
		}
		return $CART_CODE;
	}
	
	function wizCartExe_sample($oid,$pid,$qty,$price,$point){
    	//function wizCartExe($mode,$oid,$pid,$qty,$price,$point,$option1,$option1_price,$option2,$option2_price,$option3,$option3_price,$etc)
    	#mode 1 : insert 2: update, 
    	#oid : 주문아이디
    	#pid : 상품아이디
    	#qty : 수량
    	#price : 가격
    	#point : 포인트
    	# $option1,$option1_price,$option2,$option2_price,$option3,$option3_price : 옵션 및 옵션에 따른 가격 
    	#flag1 : 0 : 주문전 1 : 주문완료 2: 결제완료
    	#flag2 : 1 : 옵션가격차등적용, 2: 옵션가격으로 현가격변동|, 
    	#추가할 옵션 : 장바구니담기시 동일 아이템 존재시 갯수유지 or 갯수추가
    	#CART파일의 생성시간을 구해서 하루초과에 대해서는 자동삭제(여기서는 하루 기준)..
	
		$this->ResetCart();//하루전의 필요없는 카트에 담긴 상품은 삭제
		$flag1=0;//주문전
		$flag2=1;
		$wdate = time();
		#데이타를 분석하여 (oid, pid, option1, option2, option3) 중복되면 update를 그렇지 않으면 insert 를 실행한다.
		$sqlstr = "select count(*) from wizCart where oid='$oid' and pid='$pid' and option1='$option1' and option2='$option2' and option3='$option3'";
		$count = $this->dbcon->get_one($sqlstr);
		//echo "sqlstr = $sqlstr <br>";
	
		if(!$count){
			$sqlstr = "insert into wizCart (oid,pid,qty,price,point,option1,option1_price,option2,option2_price,option3,option3_price,etc,flag1,flag2,wdate) 
											values
											('$oid','$pid','$qty','$price','$point','$option1','$option1_price','$option2','$option2_price','$option3','$option3_price','$etc','$flag1','$flag2','$wdate')";
		
			$result = $this->dbcon->_query($sqlstr);
		}
	}	
	
	function ResetCart(){	#하루전 wizCart 데이타는 삭제
		$wdate = time();
	
		$deletetime = $wdate-60*60*24*1;
		$sqlstr = "delete from wizCart where flag1 = '0' and wdate < $deletetime";
		$result = $this->dbcon->_query($sqlstr);
	}

	#CART파일의 생성시간을 구해서 하루초과에 대해서는 자동삭제(여기서는 하루 기준)..
	function CartDbClear(){
		$termday = 7;
		$deletetime = time()-60*60*24*$termday;
		$sqlstr = "delete from wizCart where ostatus = '0' and wdate < $deletetime";
		$this->dbcon->_query($sqlstr);
	}
#######################################
########   [ 장바구니 담기 ] 
#######################################	
	## 장바구니 담기
	## $oid : 주문아이디
	## $pid : 제품번호
	## $qty : 갯수
	## $optionflag : 실렉트 된 옵션값  Array type
	function wizCartExe($oid,$post){
		$no				= $post["no"];
		$pid			= $post["source_id"];
		$qty			= $post["BUYNUM"];
		$optionfield	= $post["optionfield"];
	//function 
		$this->CartDbClear();//1일전 주문상품중 장바구니에만 담은 제품(결제까지 진행되지 못한 제품)은 삭제
		$tprice=0;//전체상품금액
		$op_price = 0; //옵션가격
		//실제 제품가격 및 제품 point를 구한다.
		$sqlstr	= "select Price, Point, opflag from wizMall where UID = '$pid'";
		$this->dbcon->_query($sqlstr);
		$list		= $this->dbcon->_fetch_array();
		$Price		= $list["Price"];
		$Point		= $list["Point"];
		$Popflag	= $list["opflag"];

		if($Popflag == "d"){//갯수별 차등 가격일 경우 그 정보를 가져온다.
			$sqlstr = "select qty,price from  wizMallDiffPrice where pid = '$pid' order by qty desc";
			$diffPrice = $this->dbcon->get_rows($sqlstr);
			for($i=0; $i<count($diffPrice); $i++){
				//$diffPrice[$i]["qty"]
				//$diffPrice[$i]["price"]
				if($qty <= $diffPrice[$i]["qty"]){
					$Price	= $diffPrice[$i]["price"];
				}
			}
			
			//$Price;
		}

		#mode 1 : insert 2: update, 
		#flag1 : 0 : 주문전 1 : 주문완료 2: 결제완료
		#flag2 : 1 : 옵션가격차등적용, 2: 옵션가격으로 현가격변동|, 
		#추가할 옵션 : 장바구니담기시 동일 아이템 존재시 갯수유지 or 갯수추가
		##옵션필드 저장방법 : "wizMalloptioncfg.oflag(계산방법)::wizMalloptioncfg.oname(옵션명)::wizMalloption.oname(옵션값)::wizMalloption.oprice(가격)||앞과동일반복
		
		##옵션필드 생성및 가격 저장
		##옵션필드 예 optionfield[77]=142|0 (optionfield[wizMalloptioncfg.uid]=wizMalloption.uid|wizMalloption.oprice
		//$concateOption .= wizMalloptioncfg.oflag(계산방법)::wizMalloptioncfg.oname(옵션명)::wizMalloption.oname(옵션값)::wizMalloption.oprice(가격)||
		$concateOption = "";
		if(is_array($optionfield)){
			foreach($optionfield as $key => $value){
				if($value){
					$tmp = explode("|", $value);
					$Cfg_uid = $key;
					$uid = $tmp[0];
					$oprice = $tmp[1];
					
					$sqlstr = "select oflag, oname from wizMalloptioncfg where uid = '$Cfg_uid'";
					$this->dbcon->_query($sqlstr);
					$list = $this->dbcon->_fetch_array();
					$Cfg_oflag = $list["oflag"];
					$Cfg_oname = $list["oname"];
					
					$sqlstr = "select oname from wizMalloption where uid = '$uid'";
					$this->dbcon->_query($sqlstr);
					$list = $this->dbcon->_fetch_array();
					$oname = $list["oname"];
					
					$concateOption .= $Cfg_oflag."::".$Cfg_oname."::".$oname."::".$oprice."||";
					if($Cfg_oflag == "2"){//기존 제품 가격 변경
						$Price = $oprice;
					}else if($Cfg_oflag == "1"){//옵션추가가격
						$op_price += $oprice;
					}
				}
			}
		}//if(is_array($optionfield){
		## 만약 환율적용상품이면 아래 $tprice에 환율 적용부분을 곱한다.
		$tprice = ($Price+$op_price)*$qty;
		$tpoint = ($Point)*$qty;
		
		$whereis = "where 1";
		
		#데이타를 분석하여 (oid, pid, option1, option2, option3) 중복되면 update를 그렇지 않으면 insert 를 실행한다.
		$sqlstr = "select count(1) from wizCart where oid='$oid' and pid='$pid' and optionflag='$concateOption'";
		$count = $this->dbcon->get_one($sqlstr);

		
		
		//echo $sqlstr;
		//$flag1=0;
		
		//echo "count = $count <br>";
		if(!$count){//동일제품이 존재하지 않을경우 담기 실행

			$sqlstr = "insert into wizCart (oid,pid,qty,price,tprice,point,tpoint, optionflag,wdate) 
						values
					 ('$oid','$pid','$qty','$Price','$tprice','$Point','$tpoint','$concateOption',".time().")";
			//echo $sqlstr;
			//exit;
			$this->dbcon->_query($sqlstr);
		}else{
			//갯수를 추가할 것인가 말건인가 프로그램(이후 진행예정)		
		
		}
		//exit;
	}
	
	## 장바구니 옵션값을 배열로 변환
	function optoArr($op){
		//$this->wizCartExe  참조
	    //1::가격추가::가격추가2::1100||
		$tmp = explode("||", $op);
		$cnt = 0;
		foreach($tmp as $key=>$value){
			if($value){
				$tmp2 =  explode("::", $value);
				$opArr[$cnt]["oflag"] = $tmp2[0];
				$opArr[$cnt]["oname"] = $tmp2[1];
				$opArr[$cnt]["ovalue"] = $tmp2[2];
				$opArr[$cnt]["oprice"] = $tmp2[3];
				$cnt++;
			}
		}
		return $opArr;		 
	}
	
	## 장바구니 옵션값을 텍스트로 변환
	function optoStr($op){
		$opArr = $this->optoArr($op);
		$rtn = "";
		if(is_array($opArr)){
			foreach($opArr as $key=>$value){
				$addstr = $value[oprice] ? "(".number_format($value[oprice]).")":"";
				$rtn .= "<br>".$value[oname].":".$value[ovalue].$addstr;
			}
		}
		return $rtn;
	}

	## 장바구니 상품갯수 변경
	function changeCartqty($uid, $qty){
		//현재 상품의 가격을 변동한다.
		$sqlstr = "select pid, price, point optionflag from wizCart where uid = '$uid'";
		$list		= $this->dbcon->get_row($sqlstr);
		$pid		= $list["pid"];
		//$price		= $list["price"];
		$op_price	= 0;
		$optionflag	= $list["optionflag"];
		$opArr = $this->optoArr($optionflag);
		
		//실제 제품가격 및 제품 point를 구한다.
		$sqlstr	= "select Price, Point, opflag from wizMall where UID = '$pid'";
		$list		= $this->dbcon->get_row($sqlstr);
		$Price		= $list["Price"];
		//$Point		= $list["Point"];
		$Popflag	= $list["opflag"];

		if($Popflag == "d"){//갯수별 차등 가격일 경우 그 정보를 가져온다.
			$sqlstr = "select qty,price from  wizMallDiffPrice where pid = '$pid' order by qty desc";
			$diffPrice = $this->dbcon->get_rows($sqlstr);
			for($i=0; $i<count($diffPrice); $i++){
				//$diffPrice[$i]["qty"]
				//$diffPrice[$i]["price"]
				if($qty <= $diffPrice[$i]["qty"]){
					$Price	= $diffPrice[$i]["price"];
				}
			}
			
			//$Price;
		}


		
		if(is_array($opArr)){
			foreach($opArr as $key=>$value){
				if($value[oflag] == "2"){//기존 제품 가격 변경
					$Price = $value["oprice"];
				}else if($value["oflag"] == "1"){//옵션추가가격
					$op_price += $value["oprice"];
				}
			}
		}
		
		## 만약 환율적용상품이면 아래 $tprice에 환율 적용부분을 곱한다.
		$tprice = ($Price+$op_price)*$qty;
		$tpoint	= $point*$qty;
		
		$sqlstr = "update wizCart set price=$Price, qty = $qty, tprice = $tprice, point = $tpoint where uid = $uid";
		$this->dbcon->_query($sqlstr);
		//echo $sqlstr;
		//exit;
	}

	function stock($arg1,$arg2,$arg3,$arg4=null){## 상품재고처리
		#$arg1 : 두번째 인자값의 특징을 받는다. flag1 = oid 이면 두번째 인자값은 wizCart.oid 혹은wizBuyers.OrderID  , cuid : wizCart.uid(개별처리)
		#arg3 : 현재 주문단계
		#arg4: 이전 주문단계
		if($arg1 == "oid"){
			if($arg3 == "10"){//주문신청시는 tmpOutput 에서만 증가 시킨다.
				$sqlstr = "select uid, pid, qty, point from wizCart where oid = '$arg2'";
				$qry = $this->dbcon->_query($sqlstr);
				while($list =$this->dbcon->_fetch_array($qry)):
				$uid = $list["uid"];
				$pid = $list["pid"];
				$qty = $list["qty"];
				$point = $list["point"];

				$substr = "update wizMall SET tmpOutput=tmpOutput + $qty WHERE UID='$pid'";
				$this->dbcon->_query($substr);
				endwhile;
			}
		}else if($arg3 == "50" && $arg4 == "40"){//주문완료시 tmpOutput를 실 Output로 전환
			if($arg1 == "cuid"){//주문당 개별처리
				$sqlstr = "select pid, qty from wizCart where uid = '$arg2'";
				$list = $this->dbcon->get_row($sqlstr);
				$pid = $list["pid"];
				$qty = $list["qty"];
				$substr = "update wizMall SET tmpOutput=tmpOutput - $qty, Output = Output + $qty, Stock = Stock - $qty WHERE UID='$pid'";
				$this->dbcon->_query($substr);
				$this->Stock_sta($qty, $pid);//실 통계 페이지용 재고 관리
			}
		}else if($arg3 == "10" && $arg4 == "50"){//주문완료에서 취소시 tmpOutput를 실 Output로 전환
			if($arg1 == "cuid"){//주문당 개별처리
				$sqlstr = "select pid, qty from wizCart where uid = '$arg2'";
				$list = $this->dbcon->get_row($sqlstr);
				$pid = $list["pid"];
				$qty = $list["qty"];
				$substr = "update wizMall SET tmpOutput=tmpOutput + $qty, Output = Output - $qty, Stock = Stock + $qty WHERE UID='$pid'";
				$this->dbcon->_query($substr);
				$this->Stock_sta(-$qty, $pid);//실 통계 페이지용 재고 관리
			}
		}else if($arg3 == "0" && $arg4 == "10"){//주문삭제시
			if($arg1 == "cuid"){//주문당 개별처리
				$sqlstr = "select pid, qty from wizCart where uid = '$arg2'";
				$list = $this->dbcon->get_row($sqlstr);
				$pid = $list["pid"];
				$qty = $list["qty"];
				$substr = "update wizMall SET tmpOutput=tmpOutput - $qty WHERE UID='$pid'";
				$this->dbcon->_query($substr);
				$this->Stock_sta(-$qty, $pid);//실 통계 페이지용 재고 관리
			}
		}

	}

	function Stock_sta($qty, $uid){
		$sqlstr = "insert into wizInputer (Ioid, Iinputqty, Iinputdate) values ($uid, $qty, ".time().")"; 
		$this->dbcon->_query($sqlstr);
	}

	function get_order_id($uid){
		$sqlstr	= "select OrderID from wizBuyers where UID = $uid";
		$oid	= $this->dbcon->get_one($sqlstr);
		return $oid;
	}

	function ch_buyer_sta($uid, $status){##wizBuyers의  OrderStatus 변경
		$sqlstr = "update wizBuyers SET OrderStatus = '$status' WHERE UID='$uid'";
		$this->dbcon->_query($sqlstr);
	}
	
	function ch_cart_sta($oid, $status){##wizCart의 ostatus 변경
		$sqlstr = "update wizCart set ostatus = '$status' where oid = '$oid'";
		$this->dbcon->_query($sqlstr);
	}

	function payresult($order_no, $result=true, $card_flag=null){//카드결제완료후 db 처리
		## card_flag 인자값은 배열로 전달
		$sqlstr = "select * from wizBuyers where CODE_VALUE = '$order_no'";
		//$this->dbcon->_query($sqlstr);
		//$list = $this->dbcon->_fetch_array();
		
		if ($result){ //결제 성공시 처리 작업
			 $sqlstr = "update wizBuyers set CardStatus = '', Co_Now = '30' where CODE_VALUE = '$order_no'";
			 $this->dbcon->_query($sqlstr); 
		}

	}

	function payresult_location($order_no, $result=true, $type="normal"){//카드결제완료후 로케이션 처리
		## card_flag 인자값은 배열로 전달
		$sqlstr = "select * from wizBuyers where CODE_VALUE = '$order_no'";
		$this->dbcon->_query($sqlstr);
		$list = $this->dbcon->get_row();

		if($result){
			echo "<script>parent.location.replace('../../../wizbag.php?query=step4&OrderID=".$list["CODE_VALUE"]."');</script>";
		}else{
			echo " <script>parent.location.replace('../../../wizbag.php?query=step3&paytype=".$list["How_Buy"]."&OrderID=".$list["CODE_VALUE"]."');</script>";
		}
	}
}