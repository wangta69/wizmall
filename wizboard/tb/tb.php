<?
include "../../lib/cfg.common.php"; 
include "../../config/db_info.php";
include_once "../../lib/class.database.php";

include_once "../../lib/class.trackback.php";
$tracback	= new tracbackcls();
$dbcon		= new database($cfg["sql"]);
$tracback->cfg = $cfg;

if($smode == "qin"){
	$tracback->send_trackback($tb_url, $url, $title, $blog_name, $excerpt);

}else{
		$title		= $tracback->trimdate($_POST["title"], "EUC-KR", "UTF-8");
		$excerpt	= $tracback->trimdate($_POST["excerpt"], "EUC-KR", "UTF-8");
		$url		= $tracback->trimdate($_POST["url"], "EUC-KR", "UTF-8");
		$blog_name	= $tracback->trimdate($_POST["blog_name"], "EUC-KR", "UTF-8");
		/*
		$title = "t";
		$excerpt = "t";
		$url = "root/etc1/752";
		$blog_name = "t";
		*/
		$tracback->db_connect($dbcon);
		$tracback->receive_trackback($title, $excerpt, $url, $blog_name);
}
?>