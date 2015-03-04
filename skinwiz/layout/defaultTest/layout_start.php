<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>무료 쇼핑몰 솔루션 - 숍위즈(http://www.shop-wiz.com)</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>" />
<link rel="stylesheet" href="./css/base.css" type="text/css" />
<link rel="stylesheet" href="./css/common.css" type="text/css" />
<link rel="stylesheet" href="./css/mall.css" type="text/css" />
<script src="./js/AC_RunActiveContent.js" type="text/javascript"></script>
<script language=javascript src="./js/jquery.min.js"></script>
<script src="./js/wizmall.js" type="text/javascript"></script>
</head>

<body>
<a name="topAnchor"></a>
<div id="wrapper">
 <!--  
<div id=sidebar style="left:905px; top:280px; visibility: visible; width: 150px; position: relative;"> 
  <div id=sidebar style="left:0px; top:0px; visibility: visible; width: 0px; position: absolute;"> -->

  <div style="left:905px; top:100px; visibility: visible; width: 150px; position: relative;">
  <div id="inside_box" style="position: absolute; top:0px">

<table>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table>
                      
<?
$sqlstr = "select c.pid, m.Picture, m.Category from wizCart c 
left join wizMall m on c.pid = m.UID 
where c.oid = '".$_COOKIE["CART_CODE"]."'";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
$Picture = explode("|", $list["Picture"]);
$cookie_cat = $list["Category"];
$cookie_big_code = substr($cookie_cat, -3);
$cookie_uid = $list["pid"];
?>					  
					  <tr>
                        <td><a href="wizmart.php?query=view&code=<?=$cookie_cat?>&no=<?=$cookie_uid?>"><img src="./config/uploadfolder/productimg/<?=$cookie_big_code?>/<?=$Picture[0]?>"  width="50"></a>
						  
							  </td>
                      </tr>
                      
<?
endwhile;
?>					  
                    </table></td>
          </tr>
          <tr>
            <td><table><tr><td>
<div id=scrollupdown style="height:190px;overflow:hidden">
                              <?
$view_file = "./config/wizmember_tmp/view_product/".session_id().".php";
if (is_file($view_file)) include $view_file;
		
if(is_array($TODAY_PRODUCT)){

	$cnt=0;
	krsort($TODAY_PRODUCT[uid]);
	foreach($TODAY_PRODUCT[uid] as $key => $value){
		$cookie_uid = $value;
		$cookie_img = $TODAY_PRODUCT["img"][$key];
		$cookie_cat = $TODAY_PRODUCT["category"][$key];
		$cookie_imgcat = $TODAY_PRODUCT["imgcategory"][$key];
		//echo "cookie_cat=".$cookie_cat;
		$cookie_big_code = substr($cookie_imgcat, -3);
		if($cookie_uid){
		//if($cnt) echo "<tr><td></td></tr>";
?>
                              <div><a href="wizmart.php?query=view&code=<?=$cookie_cat?>&no=<?=$cookie_uid?>"><img src="./config/uploadfolder/productimg/<?=$cookie_big_code?>/<?=$cookie_img?>"  width="50"></a></div>
                              <div style="height:1px;"></div>
                              <?

			$cnt++;
		}
	//echo "cnt = $cnt <br />";
		//if($cnt == 3) break;
	}
}//if(is_array($TODAYPRODUCT)){
?>
                            </div>				  
                    </td></tr></table></td>
          </tr>
          <tr>
            <td><a href="javascript:scrollupdown(65)" onfocus=blur()>▼</a></td>
          </tr>
        </table>
    <img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/right_quick.gif" height="254" usemap="#quickMap"> 
    <map name="quickMap" id="quickMap">
      <area shape="rect" coords="5,21,66,77" href="wizboard.php?BID=board04&GID=root">
      <area shape="rect" coords="5,79,66,135" href="wizboard.php?BID=board01&GID=root">
      <area shape="rect" coords="5,137,66,189" href="wizboard.php?BID=board03&GID=root">
      <area shape="rect" coords="5,195,65,250" href="wizhtml.php?html=guide">
    </map>
<script language="javascript">
<!--
$(document).ready(function() {	 //따라다니는 배너
	var currentPosition = parseInt($('#inside_box').css('top')); 
	$(window).scroll(function() { 
		var position = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환
		$('#inside_box').stop().animate({'top':position+currentPosition+'px'},500); //여기서 1000은 속도. 값이 작을수록 빨리.
	}); 
});


function scrollupdown(gap)
{
	var scrollupdown = document.getElementById('scrollupdown');
	scrollupdown.scrollTop += gap;
}

//-->
</script>    
  </div>
</div>
