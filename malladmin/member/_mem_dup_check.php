<?php
$formname = $_GET['formname'];
$id = $_GET['id'];

include "../../config/db_info.php";
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);


    $sqlstr = "select count(1) from wizMembers where mid = '$id'";
    $cnt->get_one($sqlstr);

	header("Content-Type: application/x-javascript");
	if($cnt){
		echo "alert('이미 가입된 회원정보가 존재합니다.');";
		echo "document.".$formname.".idavail.value=''";
	}else{
		echo "alert('사용가능한 아이디 입니다.');";
		echo "document.".$formname.".idavail.value='1'";
	}