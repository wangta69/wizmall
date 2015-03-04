<?php
##���� �԰ݿ� �°� table schema ����
//http://mall.shop-wiz.com/malladmin/install/schemacheck.php
include "../../lib/inc.depth2.php";
$result = mysql_list_tables($cfg["sql"]["dbname"]);
for($i=0; $i < mysql_num_rows ($result); $i++){
	$tbname = mysql_tablename ($result, $i);
	if(substr($tbname, -6) == "_reply"){//_reply board �� ���̺� ���ɸ� ����
		$result1 = mysql_query("SELECT URL FROM $tbname");
		if(!$result1){//�ʵ� �߰�
			$dbcon->_query("ALTER TABLE  `$tbname` ADD  `URL` varchar( 50 ) NOT NULL AFTER  `EMAIL`");
		}
		
		$result1 = mysql_query("SELECT URL FROM $tbname");
		$len = mysql_field_len($result1, 0);
	//	echo $len."<br>";
		if($len == "100") $dbcon->_query("ALTER TABLE  `$tbname` CHANGE  `URL`  `URL` VARCHAR( 250 ) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL");
		
		/*
		$result1 = mysql_query("SELECT URL FROM $tbname");
		$field = mysql_field_type($result1, 0);
		//$type  = mysql_field_type($result, $i);
		//$name  = mysql_field_name($result, $i);
		//$len   = mysql_field_len($result, $i);
		//$flags = mysql_field_flags($result, $i);

		## �ʵ� ����
		if($field == "int") $dbcon->_query("ALTER TABLE  `$tbname` CHANGE  `URL`  `URL` VARCHAR( 50 ) NOT NULL");
		*/
		
		$result1 = mysql_query("SELECT RECCOUNT FROM $tbname");
		if(!$result1){//�ʵ� �߰�
			$dbcon->_query("ALTER TABLE  `$tbname` ADD  `RECCOUNT` INT( 5 ) NOT NULL DEFAULT  '0' AFTER  `COUNT`");
		}
		
		$result1 = mysql_query("SELECT NONRECCOUNT FROM $tbname");
		if(!$result1){//�ʵ� �߰�
			$dbcon->_query("ALTER TABLE  `$tbname` ADD  `NONRECCOUNT` INT( 5 ) NOT NULL DEFAULT  '0' AFTER  `RECCOUNT`");
		}
		
		$result1 = mysql_query("SELECT IP FROM $tbname");
		if(!$result1){//�ʵ� �߰�
			$dbcon->_query("ALTER TABLE  `$tbname` ADD  `IP` varchar( 15 ) NOT NULL AFTER  `NONRECCOUNT`");
		}
		
		//$flags = mysql_field_flags($result1, 0);
		//echo $flags."<br>";
	}
}