<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include ("../../config/cfg.core.php");
if(!$cfg["skin"]["ZipCodeSkin"]) $cfg["skin"]["ZipCodeSkin"] = "default";
include "./".$cfg["skin"]["ZipCodeSkin"]."/index.php";
