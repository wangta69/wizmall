<?
include ("../common/header_pop.php");
include ("../../config/common_array.php");

switch($t_page){
	case "bankinfo":
	//온라인 무통장 결제
		switch($smode){
			case "qin":
				$sqlstr = "insert into wizaccount (bankname,account_no,account_owner) 
				values
				('".$bankname."','".$account_no."','".$account_owner."')";
				$dbcon->_query($sqlstr);			
			break;
			case "qup":
				$sqlstr = "update wizaccount set 
				bankname = '".$bankname."',  
				account_no = '".$account_no."', 
				account_owner = '".$account_owner."'
				where uid = '$uid'";
				$dbcon->_query($sqlstr);
			break;
			case "qde":
				$sqlstr = "delete from wizaccount where uid = '$uid'";
				$dbcon->_query($sqlstr);			
			break;
		}
	break;
	case "ch_shop_cat_skin":
		$sqlstr = "UPDATE wizCategory SET cat_skin='$cat_skin', cat_skin_viewer='$cat_skin_view' WHERE UID = '$uid'";
		echo $sqlstr;
		$dbcon->_query($sqlstr);	
	break;

}
?>