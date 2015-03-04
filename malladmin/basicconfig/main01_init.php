<?
include "../common/header_pop.php";

function copyimg($img){
	copy("./init_banner/".$img, "../../config/banner/".$img);
}

$sqlstr = "truncate table `wizbanner`";
$dbcon->_query($sqlstr);

$sqlstr = "INSERT INTO `wizbanner` VALUES (1, 1, 1, '','/', '_self', 'dG9wbG9nby5naWY=', 0, 0,1236666446);";
$dbcon->_query($sqlstr);
copyimg("dG9wbG9nby5naWY=");

$sqlstr = "INSERT INTO `wizbanner` VALUES (2, 2, 1, '', '', '_self', 'bG9nb19ib3R0b20uZ2lm', 0, 0,1236666577);";
$dbcon->_query($sqlstr);
copyimg("bG9nb19ib3R0b20uZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (3, 5, 1, '', '', '_self', 'bGVmZmJhbm5lcjEuZ2lm', 0, 0,1236669778);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcjEuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (4, 5, 2, '', '', '_self', 'bGVmZmJhbm5lcjIuZ2lm', 0, 0,1236669789);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcjIuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (5, 5, 3, '', '', '_self', 'bGVmZmJhbm5lcjMuZ2lm', 0, 0,1236669799);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcjMuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (6, 5, 4, '', '', '_self', 'bGVmZmJhbm5lcjQuZ2lm', 0, 0,1236669990);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcjQuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (7, 5, 5, '', 'http://www.shop-wiz.com/html/pg.php', '_blank', 'bGVmZmJhbm5lcjUuZ2lm', 0, 0,1236670038);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcjUuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (8, 5, 6, '', '', '_self', 'bGVmZmJhbm5lcl9ibGFuay5naWY=', 0, 0,1236670065);";
$dbcon->_query($sqlstr);
copyimg("bGVmZmJhbm5lcl9ibGFuay5naWY=");

$sqlstr = "INSERT INTO `wizbanner` VALUES (9, 5, 7, '',  '', '_self', 'MDI1MTE0NzAwX2xlZmZiYW5uZXJfYmxhbmsuZ2lm', 0, 0,1236670073);";
$dbcon->_query($sqlstr);
copyimg("MDI1MTE0NzAwX2xlZmZiYW5uZXJfYmxhbmsuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (10, 3, 1, '',  '', '_self', 'bWFpbmltZy5qcGc=', 0, 0,1236670716);";
$dbcon->_query($sqlstr);
copyimg("bWFpbmltZy5qcGc=");

$sqlstr = "INSERT INTO `wizbanner` VALUES (11, 4, 1, '',  '', '_self', 'bWFpbmJhbm5lcjEuZ2lm', 0, 0,1236673146);";
$dbcon->_query($sqlstr);
copyimg("bWFpbmJhbm5lcjEuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (12, 4, 2, '',  '', '_self', 'bWFpbmJhbm5lcjIuZ2lm', 0, 0,1236673155);";
$dbcon->_query($sqlstr);
copyimg("bWFpbmJhbm5lcjIuZ2lm");

$sqlstr = "INSERT INTO `wizbanner` VALUES (13, 4, 3, '',  '', '_self', 'bWFpbmJhbm5lcjMuZ2lm', 0, 0,1236673163);";
$dbcon->_query($sqlstr);
copyimg("bWFpbmJhbm5lcjMuZ2lm");
?>