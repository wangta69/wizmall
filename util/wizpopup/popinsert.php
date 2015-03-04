<script language="javascript" src="./js/jquery-ui.custom.min.js"></script>
<script language="javascript" src="./js/jquery.plugins/jquery.popup-1.0.0/jquery.popup-1.2.0.js"></script>
<link rel="stylesheet" href="./js/jquery.plugins/jquery.popup-1.0.0/css/popup.css" type="text/css" />
<script>
function getCookie( name ) {        
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )  endOfCookie = document.cookie.length; 
			return unescape( document.cookie.substring( y, endOfCookie ) ); 
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
	}
	return "";
}


function setCookie( name, value, expiredays ) 
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";";// domain=" + ".shop-wiz.com"+";
}

var cookieval = new Date();
cookieval = cookieval.getTime();
var rStr_1 = "" + Math.random();
var rStr_2 = "" + Math.random();
var rStr_3 = "" + Math.random();
var rStr_4 = "" + Math.random();
var rStr_5 = "" + Math.random();
rStr_1 = rStr_1.charAt(2);
rStr_2 = rStr_2.charAt(2);
rStr_3 = rStr_3.charAt(2);
rStr_4 = rStr_4.charAt(2);
rStr_5 = rStr_5.charAt(2);
cookieval = cookieval + rStr_1 + rStr_2 + rStr_3 + rStr_4 + rStr_5;

<?php
$sqlstr = "select * from wizpopup where popupenable = 1";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
    $pskinname  = $list["pskinname"];//shop-wiz에서는 default_layer : 레이어 타입, default : 일반 팝업 2개를 제공한다. 추가 제작시 현재 부분의 소스를 일부 수정하여야 한다.
    switch($pskinname){
        case "default_layer":
?>
if ( getCookie( "Notice_<?=$list["uid"]?>" ) != "done" ) 
{ 
        var url = "./util/wizpopup/index.php?uid=<?php echo $list["uid"]?>";
        $(this).popup({url:url, top:<?=$list["ptop"]?>, left:<?=$list["pleft"];?>, width:<?=$list["pwidth"]?>, height:<?=$list["pheight"]?>});
}
<?php
            break;


        default:
?>
if ( getCookie( "Notice_<?php echo $list["uid"]; ?>" ) != "done" ) 
{ 
    noticeWindow  =  window.open('./util/wizpopup/index.php?uid=<?=$list["uid"]?>','PopUpWindow_<?=$list["uid"]?>','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,left=<?=$list[pleft];?>,top=<?=$list[ptop]?>,width=<?=$list[pwidth]?>,height=<?=$list[pheight]?>');
    noticeWindow.opener = self; 
}
<?php
            break;
    }
?>

<?
endwhile;
?>
//-->
</script>