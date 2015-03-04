<?
include "../../../lib/cfg.common.php";
include ("../../../config/db_info.php");
include ("../../../config/cfg.core.php");
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include ("../../../lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon);

class compare{

	var $dbcon;
	var $common;
	var $mall;
	var $cfg;//외부 $cfg 관련 배열
	
	## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null, &$mall=null){//
		if($dbcon) $this->dbcon	= &$dbcon;
		if($common) $this->common	= &$common;
		if($mall) $this->mall	= &$mall;
	}
	
	function get_init(){
		$this->$shopurl	= $this->$cfg["admin"]["MART_BASEDIR"]."/";
		$sqlstr		= "select UID, Name, Price, Point, Picture, Category, Model from wizMall where UID = PID and None <> 1";
		$this->qry		= $this->dbcon->_query($sqlstr);
		$this->total	= $this->dbcon->_num_rows($this->qry);
		
	}
	
	function get_bestbuyer(){## 베바 관련 출력 옵션
		echo "<P>Total : ".$this->total."\n";
		echo "<P>Serial : ".date("YmdHis")."\n";
		while($list = $this->dbcon->_fetch_array($this->qry)):
			$uid		= $list["UID"];
			$cat		= $list["Category"];
			$name		= $list["Name"];
			$price		= $list["Price"];
			$point		= $list["point"];
			$model		= $list["Model"];
			$pic		= explode("|", $list["Picture"]);
			$viewurl	= $this->shopurl."wizmart.php?query=view&code=".$cat."&no=".$uid;
			$imgurl		= $this->mall->getpdimgpath($cat, $pic[0], $shopurl);
			$catarr		= $this->mall->getCategory($cat);
			
			$catstr		= $catarr[0]["cat_name"]."^".$catarr[1]["cat_name"]."^".$catarr[2]["cat_name"];
			echo "<P>".$uid."^".$catstr."^".$name."^".$model."^".$viewurl."^".$imgurl."^".$price."\r\n";   
		
		endwhile;      
	}
	function get_danawa(){## 베바 관련 출력 옵션
		echo "http://".$_SERVER[HTTP_HOST]."\n";
		while($list = $this->dbcon->_fetch_array($this->qry)):
			$uid		= $list["UID"];
			$cat		= $list["Category"];
			$name		= $list["Name"];
			$price		= $list["Price"];
			$point		= $list["point"];
			$model		= $list["Model"];
			$pic		= explode("|", $list["Picture"]);
			$viewurl	= $this->shopurl."wizmart.php?query=view&code=".$cat."&no=".$uid;
			$imgurl		= $this->mall->getpdimgpath($cat, $pic[0], $shopurl);
			$catarr		= $this->mall->getCategory($cat);
			
			$catstr		= $catarr[0]["cat_name"]."#".$catarr[1]["cat_name"];
			echo $uid."#".$catstr."#".$model."#".$viewurl."#".$price."\n";   
		
		endwhile;     
	}
	function get_empas(){## 베바 관련 출력 옵션
		echo "http://".$_SERVER[HTTP_HOST]."\n";
		while($list = $this->dbcon->_fetch_array($this->qry)):
			$uid		= $list["UID"];
			$cat		= $list["Category"];
			$name		= $list["Name"];
			$price		= $list["Price"];
			$point		= $list["point"];
			$model		= $list["Model"];
			$pic		= explode("|", $list["Picture"]);
			$viewurl	= $this->shopurl."wizmart.php?query=view&code=".$cat."&no=".$uid;
			$imgurl		= $this->mall->getpdimgpath($cat, $pic[0], $shopurl);
			$catarr		= $this->mall->getCategory($cat);
			
			$catstr		= $catarr[0]["cat_name"]."@".$catarr[1]["cat_name"];
			echo "<<<begin>>>
					<<<상품ID>>>".$uid."
					<<<분류>>>".$catstr."
					<<<상품명>>>".$name."
					<<<모델명>>>".$model."
					<<<출시일자>>> 
					<<<제조회사>>>
					<<<가격>>>".$price."
					<<<상품URL>>>".$viewurl."
					<<<포인트>>>".$point."
					<<<배송료>>>
					<<<이벤트>>>
					<<<end>>>
					"; 
		endwhile;     
	}			
}

$compare = new compare;
$compare->cfg = $cfg;
$compare->get_object($dbcon, $common, $mall);
$compare->get_init();

switch($com){
	case "bestbuyer":$compare->get_bestbuyer();break;
	case "danawa":$compare->get_danawa();break;
	case "empas":$compare->get_empas();break;
}

	



?>