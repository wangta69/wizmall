<?php
/* 
제작자 : 폰돌
스킨 : shopwiz default skin
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include ("../../../lib/inc.depth3.php");
include ("../../../lib/class.wizmall.php");
include ("../../../lib/inc.wizmart.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;

//$view = $mall->getview($no);
/* Get a information of a piece of First Image */ 
$sqlstr = "SELECT m1.Category, m1.Name, m1.Model, m1.Brand, m1.Point, m1.Price, m1.Category FROM wizMall m1 
			left join wizMall m2 on m1.UID = m2.PID WHERE m2.UID=".$no;
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
$orderid			= $list["orderid"];
$filename			= $list["filename"];
$big_code			= substr($list["Category"], -3);
$Name				= $list["Name"];
$Brand				= $list["Brand"];
$Point				= $list["Point"];
$Price				= $list["Price"];




//상품에 관한 모든 이미지를 가져온다.
$sqlstr = "select orderid, filename from wizMall_img where pid = '".$no."' and orderid <> 1 and orderid <> 2 order by orderid asc"; //소/중 이미지를 제외한 모든 이미지
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
	$orderid	= $list["orderid"];
	$filename	= $list["filename"];
	$imgname[$orderid] = $filename;
endwhile;
?>
<html>
<head>
<title>상품이미지 보기</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"]?>">
<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/jquery.plugins/jquery.wizimageoverlap-1.0.1.js"></script>
<link type="text/css" rel="stylesheet" href="../../../js/bootstrap/css/mallbootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../css/base.css"/>
<link type="text/css" rel="stylesheet" href="../../../css/mall.css"/>

<script>
$(function(){
	//로드시 초기 이미지 설정
	var iniImg = $(".thumimg:first").attr("src")
	//$("#bigImg img").attr("src", iniImg) ; 
	$(".thumimg:first").wizimagech();
	
	$(".thumimg").mouseover(function(){
		$(this).wizimagech();
	});
});
</script>

<body>
<div style="padding:10px">
	<div class="fleft" id="bigImg" style="position:relative;width:300px;height:250px;"><img src=""/></div>


	<div class="fright">
		<?php echo $Name?>
		<table class="table" style="width:350px">
			<col width="100px" />
			<col width="*" />
			<?php if($Model):?>
			<tr>
				<th>모델명</th>
				<td><?php echo $Model?></td>
			</tr>
			<?php endif;?>
			<?php if($Brand):?>
			<tr>
				<th>제조사</th>
				<td><?php echo $Brand?>
				</td>
			</tr>
			<?php endif;?>
			<?php if($Point):?>
			<tr>
				<th>적립포인트</th>
				<td><?php echo number_format($Point)?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th> 가격</th>
				<td> \<?php echo number_format($Price)?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
<?php
$cnt=0;
if(is_array($imgname)){
	foreach($imgname as $key=>$value){
		//if($key >= 3){
?>
				<td><img src="../../../config/uploadfolder/productimg/<?php echo $big_code?>/<?php echo $value?>" class="thumimg" width="100px" /></td>
</td>
<?php
		$cnt++;
		if(!($cnt%3)) echo "</tr><tr>";
		//}
	}
}
?>
			</tr>
		</table>
		이미지위에 마우스 커서를 올려두시면 확대이미지를 보실수 
		있습니다.  <br /><a href="javascript:window.close();"><img src="./picviewimages/close_btn.gif" width="47" height="21" hspace="5"></a> </div>
</div>
</body>
</html>
