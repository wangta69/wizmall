<?php
//사용하지 않음
/*
if(!$SetupPath) $SetupPath = ".";
$Wdate = time();
//New Table 생성	
// step1 -- 테이블의 config관련 파일들이 들어갈 디렉토리를 생성한다.
if($NewTableName && !is_dir("${SetupPath}/table/$NewTableName")){
$RESULT = mkdir("${SetupPath}/table/${NewTableName}", 0777);
if(!$RESULT){
echo "<script> window.alert('table 디렉토리의 퍼미션을 책크하세요'); history.go(-);</script>";
exit;
}
//이미지 저장 디렉토리를 생성한다. 
mkdir("${SetupPath}/table/${NewTableName}/updir", 0777);
// 관련 파일을 복사한다. 
copy("${SetupPath}/default/config.php","${SetupPath}/table/$NewTableName/config.php");
copy("${SetupPath}/default/top.php","${SetupPath}/table/$NewTableName/top.php");
copy("${SetupPath}/default/bottom.php","${SetupPath}/table/$NewTableName/bottom.php");
	}
// step2 -- wizTable_Main에 테이블 정보를 입력합니다. 
    if(!$Grp) $Grp = "1";
	$SQL_QRY = "INSERT INTO wizTable_Main (BID, BoardDes, AdminName, Pass, Grp, Wdate)
	VALUES ('$NewTableName', '$TABLE_DES', '$AdminName', '$Pass', '$Grp', '$Wdate')";
	$RESULT_CREATE_NEWTABLE = $dbcon->_query($SQL_QRY);
// step3 -- 새로운 테이블을 생성합니다.
	if($RESULT_CREATE_NEWTABLE):
// 메인테이블 생성
	$QUERY = "CREATE TABLE wizTable_${NewTableName} (
	UID int(6) NOT NULL auto_increment,
	BID varchar(20) NOT NULL default '',
	ID varchar(20) NOT NULL default '',
	NAME varchar(50) NOT NULL default '',
	PASSWD varchar(20) NOT NULL default '',
	EMAIL varchar(30) NOT NULL default '',
	URL varchar(250) NOT NULL default '',
	SUBJECT varchar(100) NOT NULL default '',
	SUB_TITLE1 varchar(100) NOT NULL default '',
	SUB_TITLE2 varchar(100) NOT NULL default '',
	CONTENTS text NOT NULL,
	SUB_CONTENTS1 text NOT NULL,
	SUB_CONTENTS2 text NOT NULL,
	TxtType varchar (10) NOT NULL default '',
	THREAD varchar(10) NOT NULL default '',
	FID int(10) NOT NULL default '0',
	COUNT int(5) NOT NULL default '0',
	RECCOUNT int(5) NOT NULL default '0',
	DOWNCOUNT int(5) NOT NULL default '0',
	UPDIR1 varchar(250) NOT NULL default '',
	UPDIR2 varchar(250) NOT NULL default '',
	IP varchar(15)  NOT NULL default '',
	SPARE1 varchar(30) NOT NULL default '',
	SDATE varchar(15) NOT NULL default '0',
	W_DATE int(13) NOT NULL default '0',
	PRIMARY KEY  (UID))";
	$dbcon->_query($QUERY);
	
//리플라이 테이블 생성 
	$QUERY = "CREATE TABLE wizTable_${NewTableName}_reply (
	UID int(6) NOT NULL auto_increment,
	MID int(11) NOT NULL default '0',
	ID varchar(20) NOT NULL default '',
	NAME varchar(50) NOT NULL default '',
	PASSWD varchar(20) NOT NULL default '',
	EMAIL varchar(30) NOT NULL default '',
	SUBJECT varchar(100) NOT NULL default '',
	CONTENTS text NOT NULL,
	COUNT int(5) NOT NULL default '0',
	W_DATE int(13) NOT NULL default '0',
	PRIMARY KEY  (UID))";
	$dbcon->_query($QUERY);
	endif;
