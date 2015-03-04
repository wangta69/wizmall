<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

*** Updating List ***
*/
include "../common/header_pop.php";
include "../../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);
$GID = "root";



$page	= $_GET['page']; // get the requested page
$limit	= $_GET['rows']; // get how many rows we want to have into the grid
$sidx	= $_GET['sidx']; // get index row - i.e. user click to sort
$sord	= $_GET['sord']; // get the direction

if(!$page) $page=10;
if(!$sidx) $sidx =1;
if(!$limit) $limit = 10; 

//아래는 검색관련
$searchField	= $_GET['searchField']; //검색필드명
$searchString	= $_GET['searchString']; //검색단어
$searchOper		= $_GET['searchOper']; //검색방ㅂ버  eq:equal, ne:not equal, bw : begins width, bn : does not begin with, ew : end width, en : does not end with, cn:contains, nc:does not contain, nu : is null, nn : is not null, in : is in, ni : is not in 
$filters		= $_GET['filters'];
//alert(printf($_GET));


$whereis = "where Grade != 'A' ";
switch($searchOper){
	case "eq":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." = '".$searchString."'"; 
		}
	break;
	case "ne":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." != '".$searchString."'"; 
		}
	break;
	case "bw":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." like '".$searchString."%'"; 
		}
	break;
	case "bn"://?
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." not like '".$searchString."%'"; 
		}
	break;
	case "ew":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." like '%".$searchString."'"; 
		}
	break;
	case "en":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." not like '%".$searchString."'"; 
		}
	break;
	case "cn":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." like '%".$searchString."%'"; 
		}
	break;
	case "nc":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." = '".$searchString."'"; 
		}
	break;
	case "nu":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." is null "; 
		}
	break;
	case "nn":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." is not null "; 
		}
	break;
	case "in":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." in '".$searchString."'"; 
		}
	break;
	case "ni":
		if($searchField && $searchString){
			$whereis .= " and ".$searchField." not in '".$searchString."'"; 
		}
	break;
	default:
	break;
}




$type	= $_GET["type"];//json, xml
$do		= $_GET["do"];//save_list, get_list




switch($do){
	case "save_list":
		$BoardDes	= $_POST["BoardDes"];
		$Pass		= $_POST["Pass"];
		$oper		= $_POST["oper"];//jqquery에서 자동설정되는 값 "edit"
		$id			= $_POST["id"];

		$sqlstr = "UPDATE ".$WIZTABLE["MAIN"]." SET BoardDes ='$BoardDes', Pass='$Pass' WHERE UID ='$id'";
		//echo $sqlstr;
		$dbcon->_query($sqlstr); 
		exit;	
	break;
	default:

		if($Grp) $whereis .= " AND Grp='$Grp'";

		//$TargetBoard = "wizTable_Main";
		/* 총 갯수 구하기 */
		$sqlstr = "SELECT count(UID) FROM ".$WIZTABLE["MAIN"]." $whereis";
		
		$count = $dbcon->get_one($sqlstr);

		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)

		$sqlstr="SELECT * FROM ".$WIZTABLE["MAIN"]." ".$whereis." ORDER BY $sidx $sord  LIMIT $start , $limit";
		$dbcon->_query($sqlstr);

		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		//,"<span class='btn_change button bull'><a>변경</a></span>","수정","관리","보기"
		while($row=$dbcon->_fetch_array()){
			$responce->rows[$i]['id']=$row["UID"];
			$responce->rows[$i]['cell']=array($row["GID"],$row["BID"],$row["BoardDes"],$row["Pass"],"wizboard.php?BID=".$row["BID"]."&GID=".$row["GID"],"","","","");
			$i++;
		}        
		echo json_encode($responce);

	break;

}
?>