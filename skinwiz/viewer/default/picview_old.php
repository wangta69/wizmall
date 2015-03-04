<?
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
			left join wizMall m2 on m1.UID = m2.PID WHERE m2.UID='$no'";
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
$sqlstr = "select orderid, filename from wizMall_img where pid = '$no' and orderid <> 1 and orderid <> 2 order by orderid asc"; //소/중 이미지를 제외한 모든 이미지
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
	$orderid	= $list["orderid"];
	$filename	= $list["filename"];
	$imgname[$orderid] = $filename;
endwhile;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/jquery.plugins/jquery.wizimageoverlap-1.0.1.js"></script>
<link type="text/css" rel="stylesheet" href="../../../css/base.css"/>
<link type="text/css" rel="stylesheet" href="../../../css/mall.css"/>

<script language="JavaScript">
<!--
function ChangeImage(ImgName) { 
PathImg = "../../../config/uploadfolder/productimg/<?=$big_code?>/"+ImgName;
    if(ImgName != ""){
    document.all.GoodsBigPic.filters.blendTrans.stop();
    document.all.GoodsBigPic.filters.blendTrans.Apply();
    document.all.GoodsBigPic.src=PathImg;
    document.all.GoodsBigPic.filters.blendTrans.Play();
        }  
		
document['GoodsBigPic'].src = PathImg; 
}

function trimImgSize(v){
	var sizeX=500;//이미지 크기 제한
	
	if(v.width>sizeX) {
		Rate=v.width/sizeX;
		if(Rate>0) {
			v.width=sizeX;
			v.height=v.height/Rate;
		}
	}
}
-->
</script>
</head>
<body>
<div style="padding:20px">
	<div class="fleft">
		<?//=$cfg["admin"]["HOME_URL"]?>
		<p><a href="javascript:window.close();"> <img name="GoodsBigPic" src='../../../config/uploadfolder/productimg/<?=$big_code?>/<?=$imgname[0]?>' style="filter:blendTrans(duration=0.5)" onload="trimImgSize(this)"></a></p>
	</div>
	<div class="fright">
		<?=$Name?>
		<table class="table_main" style="width:400px">
			<col width="100px" />
			<col width="*" />
			<?if($Model):?>
			<tr>
				<th>모델명</th>
				<td><?=$Model?></td>
			</tr>
			<? endif;?>
			<?if($Brand):?>
			<tr>
				<th>제조사</th>
				<td><?=$Brand?>
				</td>
			</tr>
			<? endif;?>
			<?if($Point):?>
			<tr>
				<th>적립포인트</th>
				<td><?=number_format($Point)?>
				</td>
			</tr>
			<? endif; ?>
			<tr>
				<th> 가격</th>
				<td> \<?=number_format($Price)?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<?
$cnt=0;
if(is_array($imgname)){
	foreach($imgname as $key=>$value){
		if($key >= 3){
?>
				<td><img src="../../../config/uploadfolder/productimg/<?=$big_code?>/<?=$value?>" onMouseOver="ChangeImage('<?=$value?>')"></td>
</td>
				<?
		$cnt++;
		if(!($cnt%3)) ECHO"</tr><tr>";
		}
	}
}
?>
			</tr>
		</table>
		이미지위에 마우스 커서를 올려두시면 확대이미지를 보실수 
		있습니다. <a href="javascript:window.close();"><img src="./picviewimages/close_btn.gif" width="47" height="21" hspace="5"></a> </div>
</div>
</body>
</html>
