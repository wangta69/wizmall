<?php
class tracbackcls
{
	var $dbcon;//db connect 관련 외부 클라스 받기
	var $parser;//xml parsing용
	var $cfg;//외부 $cfg 관련 배열

## db 클라스 함수 호출용
	function db_connect(&$dbcon){//db_connection 함수 불러오기
		$this->dbcon = $dbcon;
	}
	
## xml 파싱용 시작
	function xml() {//xml 파시용 함수 호출
		$this->parser = xml_parser_create();
	
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, "tag_open", "tag_close");
		xml_set_character_data_handler($this->parser, "cdata");
	}

	function parse($data){
		xml_parse($this->parser, $data);
	}
	
	function tag_open($parser, $tag, $attributes){
		var_dump($parser, $tag, $attributes); 
	}
	
	function cdata($parser, $cdata){
		//var_dump($parser, $cdata);
		if($this->tagname == "RESPONSE" && trim($cdata)){
			$this->parsingdata[] = $cdata;
		}		
	}
	

	function tag_close($parser, $tag){ 
		var_dump($parser, $tag);
	}
## xml 파싱용 끝



	function trimdate($str, $source="UTF-8", $target="EUC-KR"){
		$rtnstr = iconv($source, $target, strip_tags($str));
		return $rtnstr;
	}
	
	#tb_url : target blog;  url : 현재 url;  title : 글제목;  excerpt : 글내용; blog_name : 블로그 명
	function send_trackback($tb_url, $url, $title, $blog_name, $excerpt) {     
		$url		= $this->trimdate($url); 
		$title		= $this->trimdate($title); 
		$blog_name	= $this->trimdate($blog_name);
		$excerpt	= $this->trimdate($excerpt);
		
		$send_data	= "url=".rawurlencode($url)."&title=".rawurlencode($title)."&blog_name=".rawurlencode($blog_name)."&excerpt=".rawurlencode($excerpt); 

		//주소 처리 
		$uinfo = parse_url($tb_url); 
		if($uinfo[query]) $send_data .= "&".$uinfo[query]; 
		if(!$uinfo[port]) $uinfo[port] = "80"; 

		//최종 전송 자료 
		$send_str = "POST ".$uinfo[path]." HTTP/1.1\r\n". 
					"Host: ".$uinfo[host]."\r\n". 
					"User-Agent: SHOPWIZ\r\n". 
					"Content-Type: application/x-www-form-urlencoded\r\n". 
					"Content-length: ".strlen($send_data)."\r\n". 
					"Connection: close\r\n\r\n". 
					$send_data; 
					
		$fp = @fsockopen($uinfo[host],$uinfo[port]); 
		if(!$fp) return "트랙백 URL이 존재하지 않습니다."; 



		//전송 
		fputs($fp,$send_str); 

		//응답 받음 
		while(!feof($fp)) $response .= fgets($fp,128); 
		fclose($fp); 


		//echo $response;
/* //참조로 $response 출력 결과 이다.
 HTTP/1.1 200 OK
Date: Wed, 28 Oct 2009 04:22:04 GMT
Server: Apache/2.0.54 (Unix) mod_jk/1.2.14
Set-Cookie: JSESSIONID=D6A1524E53C21B20CCF1378EAE4E4E40.jvm1; Path=/
Cache-Control: no-cache
Pragma: no-cache
Expires: Thu, 01 Jan 1970 00:00:00 GMT
Content-Length: 85
P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"
Connection: close
Content-Type: text/xml; charset=ks_c_5601-1987
 
<?xml version="1.0" encoding="iso-8859-1"?>
<response>
	<error>0</error>
</response>
//<error>0</error> 이경우는 성공을 뜻함
*/
		//트랙백 URL인지 확인 
		if(!strstr($response,"<response>")) return "올바른 트랙백 URL이 아닙니다."; 
		
		//XML 부분만 뽑음 
		$response = strchr($response,"<?"); 
		$response = substr($response,0,strpos($response,"</response>")); 
		
	//	while ($data = fread($response, 4096)) {
	//		$this->xml_parser->parse($data);
	//	}
	//	exit;
	//	print_r($this->xml_parser->parsingdata);
		//echo $response;

	

	
		//에러 검사 
		if(strstr($response,"<error>0</error>")) return ""; 
		else { 
			$tb_error_str = strchr($response,"<message>"); 
			$tb_error_str = substr($tb_error_str,0,strpos($tb_error_str,"</message>")); 
			$tb_error_str = str_replace("<message>","",$tb_error_str); 
			return "트랙백 전송중 오류가 발생했습니다: $tb_error_str"; 
		} 
	} 


	function  returnMsg($msg=NULL){
		$err_flag = $msg ? "1":"0";
		echo "<?xml version=\"1.0\" encoding=\"".$this->cfg["common"]["lan"]."\"?>\n"; 
		echo "<response>\n"; 
		echo "<error>".$err_flag."</error>\n"; 
		if($msg) echo "<message>".$msg."</message>\n"; 
		echo "</response>\n"; 
		exit; 
	}

	function receive_trackback($title, $excerpt, $url, $blog_name){	

		if(!$title){
			$msg = "제목이 존재 하지 않습니다.";
			$this->returnMsg($msg); 
		}
		if(!$excerpt){
			$msg = "내용이 존재 하지 않습니다.";
			$this->returnMsg($msg); 
		}
		if(!$url){
			$msg = "URL이 존재 하지 않습니다.";
			$this->returnMsg($msg);
		} 
		if(!$blog_name){
			$msg = "블로그명이 존재 하지 않습니다.";
			$this->returnMsg($msg); 
		}
	
		$tmp = explode("/", $_SERVER["PATH_INFO"]);
		//http://mall.shop-wiz.com/wizboard/tb/index.php/root/board02/8
		$gid	= $tmp[1]; 
		$bid	= $tmp[2]; 
		$uid	= $tmp[3]; 
		
		$source_table  = "wizTable_".$gid."_".$bid ; //원글이 실린 테이블 
		$target_table  = "wizTable_".$gid."_".$bid."_reply" ; //글을 작성할 테이블 
		
		$count = $this->dbcon->_getone(" select count(1) from ".$source_table." where UID = '$uid' ");

		if(!$count){
			$msg = "원본글이 존재 하지 않습니다.";
			$this->returnMsg($msg); 
		}
		
		include "../../config/wizboard/table/".$gid."/".$bid."/config.php";
		if($cfg["wizboard"]["CommentEnable"] != "yes"){
			$msg = "엮인글이 허락되지 않은 게시물입니다.";
			$this->returnMsg($msg); 
		}
		
		$this->dbcon->_rollback();
			$str = "update $source_table set  RPLCOUNT = RPLCOUNT + 1 where UID = $uid"; 
			$result = $this->dbcon->_query($str, FALSE);
			if(!$result) $this->returnMsg("트랙백입력실패");
			//$result[] = $this->dbcon->_query($str);
		
		$str = " insert into $target_table 
		(FLAG,MID,NAME,SUBJECT,URL,CONTENTS,IP, W_DATE)
		values
		(2,".$uid.",'".$blog_name."','".$title."','".$url."','".$excerpt."','".$_SERVER["REMOTE_ADDR"]."',".time().")";
		$result = $this->dbcon->_query($str);
		if(!$result) $this->returnMsg("트랙백입력실패");
		//$result[] = $this->dbcon->_query($str, FALSE);
		//$this->dbcon->_exe_rollback($result);
		
		$this->returnMsg();
	}

}