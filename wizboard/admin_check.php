<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

if($cfg["member"]["mgrade"] != "admin"){
	if($cfg["member"]["mgrade"] != "0") $common->js_alert("로그인해주시기 바랍니다.","./main.php");
	else $common->js_alert("접근이 금지된 페이지 입니다.");
}