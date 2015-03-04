<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
include "../common/header_pop.php";

$ListNo = "5";
$PageNo = "20";
$whereis = "WHERE UID <> '' and UID = PID";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
// 카테고리별 리스트를 책크한다.

$category = (int)$category;
if($category){
	$whereis = $whereis." and Category LIKE '%$category' AND None=''";
}

//----------------------------------------------------------
if (!$orderby) {$orderby = "order by UID desc";}

$sqlstr = "SELECT count(*) FROM wizMall WHERE UID <> '' and UID = PID";
$REALTOTAL = $dbcon->get_one($sqlstr);

$sqlstr = "SELECT count(*) FROM wizMall $whereis";
$TOTAL = $dbcon->get_one($sqlstr);

//--페이지 나타내기--
$TP = ceil($TOTAL / $ListNo) ; /* 페이지 하단의 총 페이지수 */
$CB = ceil($cp / $PageNo);
$SP = ($CB - 1) * $PageNo + 1;
$EP = ($CB * $PageNo);
$TB = ceil($TP / $PageNo);
?>
<html>
<head>
<title>[위즈몰] - 관리자 페이지</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link rel="stylesheet" href="../common/admin.css" type="text/css">
<script language="JavaScript">
<!--
function move(idx)
{
	var tb0 = document.getElementById('tb0');
	var tb = parent.document.getElementById('tb_refer');

	oTr = tb.insertRow(0);
	oTd = oTr.insertCell(-1);
	oTd.innerHTML = tb0.rows[idx].cells[0].innerHTML;
	oTd = oTr.insertCell(-1);
	oTd.innerHTML = tb0.rows[idx].cells[1].innerHTML;

	tb.rows[0].className = "hand";
	tb.rows[0].onclick = function(){ parent.spoit('refer',this); }
	tb.rows[0].ondblclick = function(){ parent.remove('refer',this); }
	parent.react_goods('refer');
}

function gotopage(page){
	location.href = "<?=$PHP_SELF;?>?category=<?=$category;?>&cp="+page;
}
//-->
</script>
</head>

<body>
<div class=boxTitle>- 상품리스트 <font class=small color=#F2F2F2>(등록하려면 더블클릭)</div>
<table>
  <tr> 
    <td>
      <table id=tb0>
        <form  action='<?=$PHP_SELF?>' name='mall_list'>
		 <input type="hidden" name=query value='save'>
		 <input type="hidden" name=mode value='<?=$mode?>'>
		<input type="hidden" name="sort" value="<?=$sort?>">
		<input type="hidden" name="sort1" value="<?=$sort1?>">
		<input type="hidden" name="sort2" value="<?=$sort2?>">
		<input type="hidden" name="keyword" value="<?=$keyword?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="cp" value=""> 	
  

          
          <?
$LIST_QUERY = "SELECT UID, Name, Picture, Category,Price FROM wizMall $whereis $orderby LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);
while( $list = $dbcon->_fetch_array( ) ) :
		$UID					= $list["UID"];
        $list["Name"]		= stripslashes($list["Name"]);
       	$Picture				= explode("|",$list["Picture"]); 
		$Price				= $list["Price"];
		$CatFolder			= substr($list["Category"], -2);
		$imgSrc				= "../../config/uploadfolder/productimg/".$CatFolder."/".$Picture[0];

?>
          <tr onDblClick="move(this.rowIndex)" style="cursor:pointer"> 
            <td><img src="<?=$imgSrc?>"></td>
            <td><div style="overflow:hidden;"><?=$list[Name]?></div>
	<?=number_format($Price);?>
	<input type="hidden" name=e_refer[] value="<?=$UID;?>"></td>
          </tr>
          <?endwhile;?>
          <tr> 
            <td colspan=2> <table>
                <tr> 
                  <td> 
                      
			  
					  <?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
//$PostValue = "category=$category";	  
if ( $CB > 1 ) {
$PREV_PAGE = $SP - 1;
echo "<a href=\"javascript:gotopage('$PREV_PAGE')\"><img src='../img/pre.gif'></a>";
} else {
echo "<img src='../img/pre.gif'>";
 }
/* LISTING NUMBER PART */
for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
if($cp == $i){$NUMBER_SHAPE= "${i}";}
else $NUMBER_SHAPE="".${i}."";
ECHO"&nbsp;<A HREF=\"javascript:gotopage('$i')\">$NUMBER_SHAPE</a>";
}
/* NEXT or END PART */
if ($CB < $TB) {
$NEXT_PAGE = $EP + 1;
ECHO "&nbsp;<a href=\"javascript:gotopage('$NEXT_PAGE')\"><img src='../img/next.gif'></a>";
} else {
ECHO"&nbsp;<img src='../img/next.gif'>";
}
?></td>
                </tr>
            </table></td>
          </tr>
        </form>
    </table></td>
  </tr>
</table>
</body>
</html>			