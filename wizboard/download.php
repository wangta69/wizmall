<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
2004. 06. 11 - 다운로드시 회원책크 부분을 더 넣음
2005. 07. 16 - group id (GID) 추가
*/

include "../lib/inc.depth1.php";
include "../lib/class.board.php";
$board = new board();
$board->db_connect($dbcon);
$board->common($common);

$GID	= $_GET["GID"];
$BID	= $_GET["BID"];
$UID	= $_GET["UID"];
$filename	= $_GET["filename"];

//echo "filename:".$filename;

//echo "filename:$filename <br />";
## 다운로딩시 회원등급 책크 
include "../config/wizboard/table/$GID/$BID/config.php";
$board->checkperm($cfg["member"]);

## 다운 카운트를 올립니다. 

$BOARD_NAME=preg_replace("/\s+/","","wizTable_".$GID."_".$BID);//공백제거
$BOARD_NAME=sqlInjection($BOARD_NAME);
$url = "../config/wizboard/table/${GID}/${BID}/updir/".$UID."/";

$str="UPDATE $BOARD_NAME SET DOWNCOUNT=DOWNCOUNT + 1 WHERE UID=$UID";
//$str=sqlInjection($str);
$dbcon->_query($str);
$common->filedownload($url, $filename);

/*


$filename = str_replace(" ", "+", $filename);
$filename = "64+Z7KCBc3FsLnR4dA==";
//$filename = "v7W+97G5sOi+4LytLmRvY3g=";
//echo "filename = $filename <br>";
//exit;
if(strrchr($filename, "/")){
	$filename = str_replace("/", "",strrchr($filename, "/"));//보안을 위해 상위경로는 삭제한다.
}

//echo "filename = $filename <br>";
 $url = $url."${filename}";
 $filename = "64+Z7KCBc3FsLnR4dA==";
 $url = "../config/wizboard/table/root/board01/updir/64+Z7KCBc3FsLnR4dA==";
//echo $url;
//echo $url;
echo $url;
	$dn = "1"; 							// 1 이면 다운, 0 이면 브라우져가 인식하면 화면에 출력 
	$dn_yn = ($dn) ? "attachment" : "inline"; 
	
	$bin_txt = "1"; 						// 아스키면 r, 바이너리면 rb
	$bin_txt = ($bin_txt) ? "r" : "rb";
		// echo "url:".$url."<br>";
		 
	$filename = base64_decode($filename);
	//echo "filename = $filename <br>";
	 //echo $url.$filename;
 //exit;
	if(eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) 		// 브라우져 구분 
	{ 
		Header("Content-type: application/octet-stream"); 
		Header("Content-Length: ".filesize("$url"));   		// 이 부분을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다. 
		Header("Content-Disposition: $dn_yn; filename=$filename");   
		Header("Content-Transfer-Encoding: binary");   
		Header("Pragma: no-cache");   
		Header("Expires: 0");   
	} else { 
		Header("Content-type: file/unknown");     
		Header("Content-Length: ".filesize("$url")); 
		Header("Content-Disposition: $dn_yn; filename=$filename"); 
		Header("Content-Description: PHP Generated Data"); 
		Header("Pragma: no-cache"); 
		Header("Expires: 0"); 
	} 
	if (is_file("$url")) 
	{ 

	$fp = fopen("$url", "$bin_txt"); 
	if (!fpassthru($fp))  						// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이... 
	fclose($fp); 
	} else { 
	echo "<script>alert('해당 파일이나 경로가 존재하지 않습니다');<script>"; 
	} 
	*/