<?
/*
사용 실 예)

wizpoll_skin_include("soloout","poll1","250","300");

wizpoll_skin_include('스킨명','스킨 아이디','폭');
*/
function wizpoll_skin_include($skinname,$uid,$popwidth,$popheight){
$skin_dir=eregi_replace("wizpoll_func.php","",realpath(__FILE__)); 
include "${skin_dir}/$skinname/mainskin.php";
}
?>