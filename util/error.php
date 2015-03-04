<?php
//문장 에러 발생 확인
//util/error.php?file=board/online.php
$file_name = $_GET["file"];
include_once "../lib/inc.depth1.php";
include $DOCUMENT_ROOT."/".$file_name;
