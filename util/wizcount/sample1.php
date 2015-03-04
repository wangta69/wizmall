<?
include "../lib/cfg.common.php";
include "../config/db_info.php";
require "./wizcounter.php";
require "./scrollcounter.php";

?>

<html>

<head>

    <title>카운터 테스트</title>
    <? sCounterHead(400, 100); ?>

</head>

<body bgcolor=white text=black link=blue vlink=purple alink=red onLoad="window_onload();">

<? sCounterView(); ?>

</body>

</html> 
