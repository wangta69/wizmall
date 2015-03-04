<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

include "./cfg.common.php";
include "../config/db_info.php";
include "../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

$uid	= $_GET["uid"];
## 클릭카운트 올리기
$sqlstr = "update wizbanner set cnt = cnt+1 where uid='$uid'";
$dbcon->_query($sqlstr);

## 필요시 상세클릭에 대한 세부 테이블 작성

## 테이블의 효율성을 위해 6개월 이상된 로그는 삭제
$olddate = time()-(60*60*24*30*6);
$sqlstr = "delete from wizbanner_log where wdate <".$olddate;
$dbcon->_query($sqlstr);

$user_ip	= $REMOTE_ADDR;
$referer	= $HTTP_REFERER;
$sqlstr = "insert into wizbanner_log (pid, referer, wdate) values ('$uid', '$referer', ".time().")";
$dbcon->_query($sqlstr);



## 리다이렉트 하기
$sqlstr = "select url from wizbanner where uid=$uid";
$url	= $dbcon->get_one($sqlstr);

header("location:".$url);
exit;