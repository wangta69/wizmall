<?php
class board
{
	var $dbcon;//db connect 관련 외부 클라스 받기
	var $common;//common 관련 외부 클라스 받기
	var $cfg;//외부 $cfg 관련 배열
	var $boardname;

	var $uid;
	var $bid;
	var $gid;
	//var $cp;//현재페이지
	//var $total_cnt; //총 게시물수
	var $page_var = array();//페이징 관련 변수
	var $listcnt;//한 리스트당 리스트될 게시물수
	var $pagecnt;//하단 페이지당 디스플레이 페이지 수
	var $cagegory;
	var $mode;
	var $adminmode;
	var $optionmode;//게시판별 다양한 인자값처리(frame|kor or eng..|);
	var $search_term;
	var $SEARCHTITLE;
	var $searchkeyword;

	var $whereis;
	var $orderby;
	

//하기 부분 추가 사용
	var $depth;//접근 상대 경로에 대한 설정		= "..";
	var $processmode; //접근 모드에 대한 설정	= "ajax";


## db 클라스 함수 호출용
	function db_connect(&$dbcon){//db_connection 함수 불러오기
		$this->dbcon = $dbcon;
	}
	
## common 클라스 함수 호출용
	function common(&$common){//db_connection 함수 불러오기
		$this->common = $common;
	}	


## 다중 클라스 함수 호출용(상기 대신 앞으로 이거 사용)
	function get_object(&$dbcon=null, &$common=null){//정의클라스 불러오기
		$this->dbcon	= $dbcon;
		$this->common	= $common;
	}

## 스팸글책크(spam prohibit)
	function is_spam($spamfree, $delaytime=5){
		if(!$spamfree){// 스팸글 방지로직
			$str = "잘못된 경로의 접근입니다.\\n\\n error_no = 1";
			$this->common->js_alert($str);
		}elseif($spamfree < time() - 60*60 || $spamfree > time() - $delaytime){
			$str = "잘못된 경로의 접근입니다.\\n\\n error_no = 2";
			$this->common->js_alert($str);
		} 
	}

## 접근 권한 
	function is_admin($path=null){
		//if(!$path) $path = $_SERVER['DOCUMENT_ROOT'];
		if(!$path) $path = "./";
		else $path = substr($path, -1) != "/"?$path."/":$path;
		
		if(!$this->admin){
			include $path."lib/class.admin.php";
			$this->admin = new admin();
		}
		//print_r($this->cfg["member"]["mgrade"]);
		//$result = $this->admin->accessGrade($this->cfg["member"]["mgrade"]);
		$result = admin::accessBoardGrade($this->cfg["member"]["mgrade"]);
		return $result;
		//$mgrade = $this->cfg["member"]["mgrade"];//"admin, 0, 1, 2......
		##나중에 보드별 접근 권한을 따로 준다.
	
	}
## view  관련 클라스 시작

	## 이전글 다음글에서 이전글의 UID 와 다음글의 UID를 구한다 */
	function getpreitem($uid, $cutlen=100){
		if($this->category) $catwhere = "AND b.CATEGORY = '".$this->category."'";
		$sqlstr = "SELECT b.UID, b.SUBJECT, b.NAME, m.mexp FROM ".$this->boardname." b left join wizMembers m on m.mid = b.Id WHERE b.UID < ".$uid."  ".$catwhere." ORDER BY b.UID DESC LIMIT 1"; 
		$this->dbcon->_query($sqlstr);
		$listpre = $this->dbcon->_fetch_array();
		$listpre["SUBJECT"] = $this->common->strCutting($this->common->gettrimstr($listpre["SUBJECT"], 0), $cutlen);
		$default_flag = "BID=".$this->bid."&GID=".$this->gid."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$this->category;
		$listpre["URL"] = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$listpre["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
		$this->listpre = $listpre;
		//return $listpre;
	}
	
//$PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->listpre["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term

	function getpnextitem($uid, $cutlen=100){
		if($this->category) $catwhere = "AND b.CATEGORY = '".$this->category."'";
		## 다음글 구하기 
		$sqlstr = "SELECT b.UID, b.SUBJECT, b.NAME, m.mexp FROM ".$this->boardname." b left join wizMembers m on m.mid = b.Id WHERE b.UID > ".$uid." ".$catwhere." ORDER BY b.UID ASC LIMIT 1";
		$this->dbcon->_query($sqlstr);
		$listnext = $this->dbcon->_fetch_array();
		$listnext["SUBJECT"] = $this->common->strCutting($this->common->gettrimstr($listnext["SUBJECT"], 0), $cutlen);
		$default_flag = "BID=".$this->bid."&GID=".$this->gid."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$this->category;
		$listnext["URL"] = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$listnext["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
		$this->listnext = $listnext;
		//echo "mexp".$this->listnext["mexp"];
		//return $listnext;
	}
	
	## view count  올리기
	function addviewcount($uid){
		$sqlstr="UPDATE ".$this->boardname." b SET COUNT=COUNT + 1 WHERE UID=".$uid;
		$this->dbcon->_query($sqlstr);
	}
	
	## 추천수 올리기addreccount($uid, $bid, $gid, $flag);
	function addreccount($uid, $bid, $gid, $flag){
		#flag : g GOOD, b BAD
		//아래부분에서 투표조건을 재설정(현재는 한게시물당 한번)
		## ajax 로 인한 alert 창 변경
		$tb_name = "wizTable_".$gid."_".$bid;
		
		$rtn = false;
		if($flag){
			if(!$this->cfg["member"]["mid"]){
				$str = "로그인후 사용 가능합니다.";
				//$this->common->js_alert("로그인후 사용 가능합니다.");
			}else{
				$sqlstr = "select count(*) from ".$tb_name."_reply where FLAG = '3' and ID = '".$this->cfg["member"]["mid"]."' and MID = ".$uid;
				$result = $this->dbcon->get_one($sqlstr);
	//$result = 0;//테스트용
				if($result){
					//$this->common->js_alert("이미 현재 게시물에 대해 투표하였읍니다.");
					$str = "이미 현재 게시물에 대해 투표하였읍니다.";		
				}else if($uid){
					if($flag == "g")
					{
						$sqlstr="UPDATE ".$tb_name." SET RECCOUNT=RECCOUNT + 1, GETPOINT = GETPOINT + ".$this->cfg["wizboard"]["bp_recommand"]." WHERE UID=".$uid;
						$result=$this->dbcon->_query($sqlstr);
						$str = "추천 카운트가 1 올라 갔습니다.";
						
					}
					else if($flag == "b")
					{
						$sqlstr="UPDATE ".$tb_name." SET NONRECCOUNT=NONRECCOUNT + 1, GETPOINT = GETPOINT + ".$this->cfg["wizboard"]["bp_nonerecommand"]." WHERE UID=".$uid;
						$result=$this->dbcon->_query($sqlstr);
						$str = "비추천 카운트가 1 올라 갔습니다.";
					}
					
                    unset($ins);
                    $ins["FLAG"]    = 3;
                    $ins["MID"]    = $uid;
                    $ins["ID"]    = $this->cfg["member"]["mid"];
                    $ins["W_DATE"]    = time();
					$this->dbcon->insertData($tb_name, $ins);
					$insertedid = $this->dbcon->_insert_id();
					## 포인트를 올린다.
					if($this->cfg["member"]["mid"]) $this->point_fnc($this->cfg["member"]["mid"], $this->bid, $this->gid, $insertedid, "recom");
					
					$rtn = true;
					//$goto = $PHP_SELF."?cp=".$this->page_var["cp"]."&mode=view&UID=".$uid."&BID=".$this->bid."&GID=".$this->gid."&category=".$this->catetory."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode;
					//if($result)  $this->common->js_alert($str, $goto);
				}
			}
		}
		$this->str = $str;
		return $rtn;
	}
	


	## 상세보기 관련 내용 가져오기
	function getview($uid){
		//$sqlstr="SELECT * FROM ".$this->boardname." b where UID='$uid'";
		$sqlstr="SELECT b.*, m.mexp FROM ".$this->boardname." b  left join wizMembers m on b.ID = m.mid where b.UID=".$uid;
		$this->dbcon->_query($sqlstr);
		$list=$this->dbcon->_fetch_array();
		$boardview = $list;//변수 충돌을 막기 위해 별도의 변수에 입력
		
		## 보기에서 글쓰기 삭제/수정권한을 위하여 전역설정
		$this->writeid = $list["ID"];
		
		$SPARE1 = explode("|", $list["SPARE1"]);
		# TxtType 0; text, 1:html, 2:txt+br
		$TxtType										= $SPARE1[0];
		$RepleMail									= $SPARE1[1];
		$Secret											= $SPARE1[2];
		$MainDisplay								= $SPARE1[3];
		$checkReple								= $SPARE1[4];
		$checkReply									= $SPARE1[5];
		$boardview["TxtType"]					= $TxtType;
		$boardview["RepleMail"]			= $RepleMail;
		$boardview["Secret"]					= $Secret;
		$boardview["MainDisplay"]				= $MainDisplay;
		$boardview["checkReple"]				= $checkReple;
		$boardview["checkReply"]				= $checkReply;
		//$boardview["SUBJECT"]					= $this->getContents($list["SUBJECT"], 0);
		//$boardview["NAME"]					= $this->getContents($list["NAME"], 0);
				

		$boardview["CONTENTS"]						= $this->getContents($list["CONTENTS"], $TxtType);
		if(!is_array(unserialize($list["SUB_CONTENTS1"]))) $boardview["SUB_CONTENTS1"] = $this->getContents($list["SUB_CONTENTS1"], $TxtType);
		//$boardview["SUB_CONTENTS1"]				= is_array(unserialize($list["SUB_CONTENTS2"])) ?  $this->getContents($list["SUB_CONTENTS1"], $TxtType);
		$boardview["SUB_CONTENTS2"]				= $this->getContents($list["SUB_CONTENTS2"], $TxtType);
		
		
		//$boardview["CONTENTS"]		= $this->common->RemoveXSS( $boardview["CONTENTS"] );
		//$boardview["SUB_CONTENTS1"]	= $this->common->RemoveXSS( $boardview["SUB_CONTENTS1"]	 );
		//$boardview["SUB_CONTENTS2"]	= $this->common->RemoveXSS( $boardview["SUB_CONTENTS2"] );


		## 제목에 테그가 들어가면 보안을 위해 테그를 삭제한다.
		//$SUBJECT=strip_tags(stripslashes($list["SUBJECT"]));
		$boardview["SUBJECT"]					= $this->common->gettrimstr($list["SUBJECT"], 0);
		//글자 폰트색상, bold를 입힌다.
		$myrtn	= json_decode($boardview["FLAG"]);
		if($myrtn->{'txtbold'} || $myrtn->{'txtcolor'}){
			if($myrtn->{'txtbold'}) $boardview["SUBJECT"] = "<b>".$boardview["SUBJECT"];
			if($myrtn->{'txtcolor'}) $boardview["SUBJECT"]	= "<font color = '#".$myrtn->{'txtcolor'}."'>".$boardview["SUBJECT"];
			if($myrtn->{'txtcolor'}) $boardview["SUBJECT"]	=$boardview["SUBJECT"]."</font>";
			if($myrtn->{'txtbold'}) $boardview["SUBJECT"] = $boardview["SUBJECT"]."</b>";
		}

		$boardview["NAME"]						= $this->common->gettrimstr($list["NAME"], 0);
		$boardview["EMAIL"]						= $this->common->gettrimstr($list["EMAIL"], 0);
		//if($SubjectLength) $SUBJECT=STR_CUTTING($SUBJECT, $SubjectLength);
		
		$boardview["filename"]					= $this->get_attached_file($uid);
		$this->common->filepath					= "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$uid."/";
		$this->common->width					= 540;
		$this->common->ViewMultiContents($boardview["filename"]);//결과값으로 $this->common->viewAttachedImg, $this->viewAttachedfilepath;
		$boardview["viewAttachedImg"]			= $this->common->viewAttachedImg;
		$boardview["viewAttachedfilepath"]		= $this->common->viewAttachedfilepath;
	
		return $boardview;
	}
	
	## 수정시 상세보기 관련 내용 가져오기
	function getmodifyview($uid){

		if ($_COOKIE["MODIFY"] != $this->uid."_".$this->bid."_".$this->gid){
			$this->common->js_location("./wizboard.php?mode=modlogin&BID=".$this->bid."&GID=".$this->gid."&nmode=".$this->mode."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&UID=".$this->uid."&cp=".$this->cp."&category=".$this->category);
		}


		$sqlstr="SELECT b.* FROM ".$this->boardname." b  where b.UID=".$uid;
		$this->dbcon->_query($sqlstr);
		$list				= $this->dbcon->_fetch_array();
		$boardview		= $list;//변수 충돌을 막기 위해 별도의 변수에 입력
		
		## 보기에서 글쓰기 삭제/수정권한을 위하여 전역설정
		$this->writeid	= $list["ID"];
		
		$SPARE1 = explode("|", $list["SPARE1"]);
		# TxtType 0; text, 1:html, 2:txt+br
		$TxtType						= $SPARE1[0];
		$RepleMail						= $SPARE1[1];
		$Secret							= $SPARE1[2];
		$MainDisplay					= $SPARE1[3];
		$checkReple						= $SPARE1[4];
		$checkReply						= $SPARE1[5];
		$boardview["TxtType"]			= $TxtType;
		$boardview["RepleMail"]			= $RepleMail;
		$boardview["Secret"]			= $Secret;
		$boardview["MainDisplay"]		= $MainDisplay;
		$boardview["checkReple"]		= $checkReple;
		$boardview["checkReply"]		= $checkReply;
				
		$boardview["SUBJECT"]		=  htmlspecialchars(stripslashes($list["SUBJECT"]));
		$boardview["CONTENTS"]		= stripslashes($list["CONTENTS"]);

		$boardview["filename"]			= $this->get_attached_file($uid);

		$myrtn	= json_decode($list["FLAG"]);
		$boardview["txtbold"]	= $myrtn->{'txtbold'};
		$boardview["txtcolor"]	= $myrtn->{'txtcolor'};

		return $boardview;
	}

	function getreplyview($uid){
		$sqlstr="SELECT b.SUBJECT, b.CONTENTS FROM ".$this->boardname." b  where b.UID=".$uid;
		$this->dbcon->_query($sqlstr);
		$list=$this->dbcon->_fetch_array();
		$boardview = $list;//변수 충돌을 막기 위해 별도의 변수에 입력

		$boardview["SUBJECT"]	= stripslashes($list["SUBJECT"]);
		$boardview["CONTENTS"] = stripslashes($list["CONTENTS"]);
		$boardview["CONTENTS"] = "\n\r\n\r\n\r\n\r\n\r ------------ [Original Message] --------------------------\r\n&gt;&gt;".str_replace("\n","\n&gt;&gt;",$list["CONTENTS"]);
		$boardview["SUBJECT"]	= "Re: ".$list["SUBJECT"];

		return $boardview;
	}

	## 상세내용의 contetns 파트 처리
	function getContents($CONTENTS, $TxtType){
		$CONTENTS	= stripslashes($CONTENTS);

		
		//관리자에서 책크시 자동링크 활성화
		if ($this->cfg["wizboard"]["AutoLink"] == 'yes') $this->common->autolink = 1;

		//관리자에서 책크시 iframe 금지
		if ($this->cfg["wizboard"]["setsecurityiframe"] == 'checked') {
			$CONTENTS = preg_replace("`<(/?)(iframe)`i", "&lt;$1$2", $CONTENTS);
		}

		//관리자에서 책크시 스크립트 금지
		if ($this->cfg["wizboard"]["setsecurityscript"] == 'checked') {
			//$CONTENTS = str_replace("<script", "&lt;script", $CONTENTS);
			//$CONTENTS = preg_replace("/script:/i","scri pt",$CONTENTS);
			$CONTENTS = preg_replace('/<\/?script[^>]*?>/i', 'scri pt', $CONTENTS); 
			$CONTENTS = preg_replace('/ onload/i', 'onloa d', $CONTENTS); //body onload 되어 실행되는 부분 삭제
			$CONTENTS = preg_replace('/ onerror/i', 'on error', $CONTENTS); //body onload 되어 실행되는 부분 삭제
			
			/*
			$CONTENTS = preg_replace("/&(?!amp;)(?!<\/script>)(?![^<]script.*?>)/", "&amp;", $CONTENTS);//-->이럴경우 모든 & -> &amp; 으로 변경됨
			$CONTENTS = preg_replace("`<(/?)(sc|!|co|t|if|x|p)`i", "&lt;$1$2", $CONTENTS);//이것을 사용하면 모든 스크립트가 나옮
			*/
			//if($TxtType == "1"){//html 이면 보안상 onmouseover 를 삭제한다.
				$CONTENTS = str_replace("onmouseover", "", $CONTENTS);
			//}
			
			$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
			$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
			$ra = array_merge($ra1, $ra2); 
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				$pattern = '/'; 
				for ($j = 0; $j < strlen($ra[$i]); $j++) { 
					//if ($j > 0) { 
						//$pattern .= '('; 
						//$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?'; 
						//$pattern .= '|(&#0{0,8}([9][10][13]);?)?'; 
						//$pattern .= ')?'; 
					//} 
					$pattern .= $ra[$i][$j]; 
				} 
				$pattern .= '/i'; 
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
				$CONTENTS = preg_replace($pattern, $replacement, $CONTENTS); // filter out the hex tags 
			} 
			//$found = true; // keep replacing as long as the previous round replaced something 
			/*while ($found == true) { 
				$val_before = $CONTENTS; 
				for ($i = 0; $i < sizeof($ra); $i++) { 
					$pattern = '/'; 
					for ($j = 0; $j < strlen($ra[$i]); $j++) { 
						if ($j > 0) { 
							$pattern .= '('; 
							$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?'; 
							$pattern .= '|(&#0{0,8}([9][10][13]);?)?'; 
							$pattern .= ')?'; 
						} 
						$pattern .= $ra[$i][$j]; 
					} 
					$pattern .= '/i'; 
					$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
					$CONTENTS = preg_replace($pattern, $replacement, $CONTENTS); // filter out the hex tags 
					//if ($val_before == $val) { 
						// no replacements were made, so exit the loop 
					//	$found = false; 
					//} 
				} 
			//} */


		}
		
		$CONTENTS = $this->common->gettrimstr($CONTENTS, $TxtType);
		$CONTENTS = $this->common->cImgResizePop($CONTENTS, $this->cfg["wizboard"]["TABLE_WIDTH"]);
					
		return $CONTENTS;	
	}

	##비밀글일경우 비밀글 읽을 권한 책크
	function is_secret_perm($Secret, $fid){
		/* 비밀게시물이면 관리자와 글작성시의 패스워드를 확인하여 맞으면 읽을 수 있게 한다. */
		if($Secret == 1){
		
		/* 만약 $_COOKIE[SECRET] 는 있고 $UID와 다를 경우 는 2차적으로 $_COOKIE[SECRET]의 FID 와 동일한 값을 가지고 있는지 상호 비교 */
			if( $_COOKIE["SECRET"] != $fid."_".$this->bid."_".$this->gid){
				$goto = "./wizboard.php?mode=secret&BID=".$this->bid."&GID=".$this->gid."&nmode=".$this->mode."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&UID=".$this->uid."&cp=".$this->page_var["cp"]."&category=".$this->category;
				$this->common->js_location($goto);
			}
		}	
	}



	##
	## 리스트에 필요한 함수
	##
	##정열값 구하기 function getorderby($oderflag)
	## 검색 키워드 및 WHERE 구하기  function getwhere($skey, $sstr, $andor=null, $search_term=null){
	##총갯수 구하기 function get_total_cnt()
	## 페이징 관련 변수 구하기 function getpagevar()


	function getnoticelist(){//보드상단 노티스 구하기
		$cnt=0;
		$NoticeWhere = "WHERE SUBSTRING(SPARE1,7,1)= '1'";
		$NoticeOrderBy = "order by UID DESC";
		$NoticeListNo=5;
		$sqlstr="SELECT * FROM ".$this->boardname." b ".$NoticeWhere." ".$NoticeOrderBy." LIMIT 0, ".$NoticeListNo;
		$this->dbcon->_query($sqlstr);
	}

	function getboardlist($notice=0){
		//$this->getorderby($oderflag); ##정열값 구하기
		//$this->getwhere($skey, $sstr); ## 검색 키워드 및 WHERE 구하기
		//$this->get_total_cnt(); ##총갯수 구하기
		//$this->getpagevar(); ## 페이징 관련 변수 구하기
		#카테고리 정보를 구한다.
		$start			= ($this->page_var["cp"] - 1) * $this->listcnt;
		$this->ini_board_no	= $this->page_var["tc"]-($this->listcnt*($this->page_var["cp"]-1));//리스트될 경우 최상위 숫자
		
		##query 최적화 작업
		$mem_join = $this->mem_join ? $this->mem_join:false;//추후 리스트 단에서 이곳 변경
		if($mem_join){
			$this->sel_field = "b.*, m.mexp";
			$leftjoin = " left join wizMembers m on b.ID = m.mid ";
		}else{
			$this->sel_field = "b.*";
		}
		
		
		if($notice == 1){
			$orderby = "order by b.UID DESC";
			$whereis = "WHERE SUBSTRING(b.SPARE1,7,1)= '1'";
			$listcnt = "5";
			//$leftjoin = " left join wizMembers m on b.ID = m.mid ";
			//$sqlstr		="SELECT b.*, m.mexp FROM ".$this->boardname." b ".$leftjoin.$whereis." ".$orderby." LIMIT 0, ".$listcnt;
			$sqlstr		="SELECT ".$this->sel_field." FROM ".$this->boardname." b ".$leftjoin.$whereis." ".$orderby." LIMIT 0, ".$listcnt;
		}else{
			//$sqlstr		="SELECT b.* FROM ".$this->boardname." b ".$this->whereis." ".$this->orderby." LIMIT $start, ".$this->listcnt;
			$limit = $this->limit == "unlimited" ? "":" LIMIT ".$start.", ".$this->listcnt;
			$sqlstr		="SELECT ".$this->sel_field."  FROM ".$this->boardname." b ".$leftjoin.$this->whereis." ".$this->orderby.$limit;
		}
		$this->dbcon->_query($sqlstr);
		return $this->dbcon->query_id;
	}



	function getorderby($oderflag){
		#$orderflag = subject@asc (필드값@정렬값);
		$tmp = explode("@", $oderflag);
		if(trim($tmp[0]) && trim($tmp[1])){
			$this->orderby = "ORDER BY b.".$tmp[0]." ".$tmp[1].", b.FID DESC, b.THREAD ASC, b.UID DESC";
		}else{
			$this->orderby = "ORDER BY b.FID DESC, b.THREAD ASC, b.UID DESC";
		}
	}

	# 검색 키워드 및 WHERE 구하기 
	function getwhere($skey, $sstr, $andor=null, $search_term=null){
	#skey : 필드, sstr : 검색어, $andor : and 검색 혹은 or검색, in 검색
	#다중필드 검색일경우(책크박스) 필드1+필드2...(이런식으로 자바 스크립트를 이용해서 처리)
	#search_term : 기간검색일경우 (금일을 기준으로 1주전.. 2주전. 값은 : 60*60*24*.. 형식(10230)
		$skey = trim($skey);
		$sstr = trim($sstr);

		$op		= unserialize(stripslashes($this->optionmode));
		$whereis  = "WHERE SUBSTRING(b.SPARE1,7,1) != '1'";
		if($this->category){
			$whereis .= " and b.CATEGORY = '".$this->category."'";
			if($op["oc"] != "true") $whereis .= "  or b.CATEGORY = '0'";
			
		}
		//이렇게 처리하면 개별 카테고리에는 전체에 해당하는 내용은 보이지 않음(추후 프로그램에서 옵션츠로 추가)
		if($this->cfg["wizboard"]["qnaboard"] == "1") $whereis  .= " and b.ID = '".$this->cfg["member"]["mid"]."'"; //1대1상담게시판용
		$sstr = $sstr?$sstr:$this->searchkeyword;
		$skey = $skey?$skey:$this->SEARCHTITLE;
		


		if($skey && $sstr){
			$fsearchtitle =  explode("+", $skey);
	
			if($andor == "and" || $andor == "or"){// and  or 검색일경우
				$fkeyword = explode(" ",$sstr);
				$whereis .= " and ( ";
				$tmpcnt = 0;
				for($j=0; $j<count($fkeyword); $j++){
					if($tmpcnt) $whereis .= " ".$andor." (";
					else $whereis .= " (";
					$cnt=0;
					for($i=0; $i<count($fsearchtitle); $i++){
						if(trim($fsearchtitle[$i])){
							if($cnt) $whereis .= " or ";
							$whereis .= "b.".$fsearchtitle[$i]." LIKE '%".$fkeyword[$j]."%'";
							$cnt++;
						}
					}
					$whereis .= " ) ";
				$tmpcnt++;
				}
				$whereis .= " ) ";	
			}else if($andor == "in"){// in 검색일경우(정확한 단어 검색)
				$fkeyword = str_replace(" ", "','", $sstr);
				$whereis .= " and ( ";
				$cnt = 0;
				for($i=0; $i<count($fsearchtitle); $i++){
					if(trim($fsearchtitle[$i])){
						if($cnt) $whereis .= " or ";
						$whereis .= "b.".$fsearchtitle[$i]." IN ('".$fkeyword."')";
						$cnt++;
					}
				}
				$whereis .= " ) ";
			}else{ //일반 검색일 경우
				$fkeyword = $sstr;
				$whereis .= " and (";
				$cnt = 0;

				for($i=0; $i<count($fsearchtitle); $i++){
					if(trim($fsearchtitle[$i])){
						if($cnt) $whereis .= " or ";
						$whereis .= "b.".$fsearchtitle[$i]." like '%".$fkeyword."%'";
						$cnt++;
					}
				}
				$whereis .= " ) ";
			}
		}else if($skey && $andor)
		{## gamech 용
			if($skey == "GETPOINT"){
				switch($andor){
					case "10"://중박
						$whereis .= " and b.GETPOINT >= ".$this->cfg["wizboard"]["np_lv10"]." and b.GETPOINT < ".$this->cfg["wizboard"]["np_lv20"];
					break;
					case "20"://명예
						$whereis .= " and b.GETPOINT >= ".$this->cfg["wizboard"]["np_lv20"]." and b.GETPOINT < ".$this->cfg["wizboard"]["np_lv30"];
					break;
					case "30"://대박
						$whereis .= " and b.GETPOINT >= ".$this->cfg["wizboard"]["np_lv30"];
					break;				
				}
			}
		}

		if($search_term){//전송값은 유닉스타임으로 넘어옮
			$search_term = $search_term?$search_term:$this->$search_term;
			$today = time();
			$boundary = $today - $search_term;
			$whereis .= " and b.W_DATE between '".$boundary."' and '".$today."'";
		} 
		$this->whereis = $whereis;
	}
	
	#총갯수 구하기
	function get_total_cnt(){
		$this->page_var["tc"] = $this->dbcon->get_one("SELECT count(UID) FROM ".$this->boardname." b ".$this->whereis);
	}

	## 페이징 관련 변수 구하기
	function getpagevar(){
		## 하단 페이지수 표시 for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) 
		$this->page_var["tp"] = ceil($this->page_var["tc"] / $this->listcnt) ; # 총페이지수(Total Page) : 총게시물수 / 페이지당 리스트
		$this->page_var["cb"] = ceil($this->page_var["cp"] / $this->pagecnt); #현재블록(Current Block) : 현재페이지 / 표시되는 페이지 수
		$this->page_var["sp"] = ($this->page_var["cb"] - 1) * $this->pagecnt + 1;#블록의 처음 페이지(Start Page) 구하기
		$this->page_var["ep"] = ($this->page_var["cb"] * $this->pagecnt);#블록의 마지막 페이지(End Page) : 현재 블록 * 표시되는 페이지수
		$this->page_var["tb"] = ceil($this->page_var["tp"] / $this->pagecnt);#총블록수(Total Block) : 총페이지수 / 표시되는 페이지 수
	}
	
	## 주어진 데이타를 리스팅에 맞게 재 배열
	function listtrim($arr, $flag=0){
		# flag = 0:일반, flag=1 : 공지.. 현재 0, 1만 정의 나중에 경우에 따라 이곳을 자유롭게
		$sub_len	= $this->cfg["wizboard"]["SubjectLength"];
		$name_len	= $this->cfg["wizboard"]["NameLength"];
		
		$arr["SUBJECT"]		= stripslashes($arr["SUBJECT"]);
		$arr["SUBJECT"]		= $this->common->strCutting($arr["SUBJECT"], $sub_len, "..");
        $arr["SUBJECT"]		= $this->common->gettrimstr($arr["SUBJECT"], 0);

		//echo $arr["SUBJECT"];
		$arr["NAME"]=stripslashes($arr["NAME"]);
		if($NameLength) $arr["NAME"]=$this->common->strCutting($arr["NAME"], $name_len, "");
        $arr["NAME"]        = $this->common->gettrimstr($arr["NAME"], 0);

		$optionflag			= explode("|",$arr["SPARE1"]);
		$arr["TxtType"]		= $optionflag[0];
		$arr["RepleMail"]	= $optionflag[1];
		$arr["Secret"]		= $optionflag[2];
		$arr["MainDisplay"]	= $optionflag[3];
		

		#첨부화일이 있을경우 첨부화일 표시
		$UPDIR1 = explode("|", $arr[UPDIR1]);
		$arr["attached"] = $UPDIR1;
		$arr["attachedImg"] = trim($UPDIR1[0])?"<img src='./wizboard/skin/".$this->cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/attached.gif'>":"";
		
		## 이미지를 보여주어야 할 경우 세팅
		$this->common->ViewMultiContents($UPDIR1);//결과값으로 $this->common->viewAttachedImg
		$arr["viewAttachedImg"] = $this->common->viewAttachedImg;

		#새글일 경우 new icon을 표시한다.
		$arr["NewWriteImg"] = time() < ($arr["W_DATE"]+ 24*60*60*$this->cfg["wizboard"]["NewTime"])? $this->showBoardIcon('new'):"";
		#REPLY에 이미지가 있을 경우 아래 방법을 사용합니다.
		$IMGNUM=strlen($arr[THREAD])-1;
		$SPACE="";
		for($i=0; $i<$IMGNUM-1; $i++){
			$SPACE .="&nbsp;&nbsp;";
		}

		#비밀게시물일경우 아래가 출력된다. 이 부분은 특수게시판 생성시는 SPARE1 필드를 다른 곳에서 사용할 가능성이 있으므로 주의한다.
		if($arr["Secret"] == "1"){
			$SecretImg = "<img src='./wizboard/skin/".$this->cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/key.gif'>";
			$Contents = "비밀게시물 입니다.";
		}
		else $SecretImg ="";

		//출력 제목에 관한 처리
		$arr["print_subject"] = $IMGNUM ? $SPACE.$this->showBoardIcon('re'):"";//리플이 존재 하면
		$tmpcatno = $arr["CATEGORY"];
		$arr["CATEGORYSTR"]	= $this->categoryname[$tmpcatno];
		$arr["print_subject"] .= $this->cfg["wizboard"]["CategoryEnable"] && $flag <> 1 ? "[".$arr["CATEGORYSTR"]."]":""; //분류가 존재하면
		$arr["print_subject"] .= $arr["SUBJECT"];
		
		//글자 폰트색상, bold를 입힌다.
		$myrtn	= json_decode($arr["FLAG"]);
		if($myrtn->{'txtbold'} || $myrtn->{'txtcolor'}){
			if($myrtn->{'txtbold'}) $arr["print_subject"] = "<b>".$arr["print_subject"];
			if($myrtn->{'txtcolor'}) $arr["print_subject"]	= "<font color = '#".$myrtn->{'txtcolor'}."'>".$arr["print_subject"];
			if($myrtn->{'txtcolor'}) $arr["print_subject"]	=$arr["print_subject"]."</font>";
			if($myrtn->{'txtbold'}) $arr["print_subject"] = $arr["print_subject"]."</b>";
		}

		$arr["print_subject"] .= $SecretImg;//비밀글 아이콘
		$arr["print_subject"] .= $arr["NewWriteImg"];//신규등록 new 아이콘
		$arr["print_subject"] .= $arr["RPLCOUNT"] ? "(<span class='reple'>".$arr["RPLCOUNT"]."</span>)":"";//리플이 존재하면
		//리스트에 컨텐츠 내용 표시하는 게시판용
		$CONTENTS = stripslashes($arr["CONTENTS"]);
		if ($this->cfg["wizboard"]["AutoLink"] == 'yes') $this->common->autolink = 1;
		$CONTENTS = $this->common->gettrimstr($CONTENTS, $TxtType);
		$CONTENTS = $this->common->cImgResizePop($CONTENTS, "800");
		$arr["CONTENTS"] = $CONTENTS;

		return $arr;
	}


	##보드관련 아이콘 함수
	function showBoardIcon($flag=null, $flag1=null){
	//echo "testing.. <br>";
	//echo "AdminOnly:".$this->cfg["wizboard"]["AdminOnly"];
	//echo "mgrade : ".$this->cfg["member"]["mgrade"]."<br>";
	

	$adminmode = $this->cfg["wizboard"]["AdminOnly"];//yes : 일반인에게 비노출, no : 일반인에게 노출
	//echo "adminmode:".$adminmode;
	//$mgrade = $this->cfg["member"]["mgrade"];//"admin, 0, 1, 2......
	$mid = $this->cfg["member"]["mid"];
	#flag : list, write, ....
	#flag : null or 1 단순모드
	#$this->writeid : 작성자 아이디를 받아와서 처리(view 페이지용)
		$default_flag = "BID=".$this->bid."&GID=".$this->gid."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$this->category;
		$icon_skin_path = "./wizboard/icon/".$this->cfg["wizboard"]["ICON_SKIN_TYPE"];
		$skin_path = $this->cfg["wizboard"]["BOARD_SKIN_TYPE"];//skin path가 default 이면 bootstrap 버튼 사용
	
		switch($skin_path){
			case "default":
				switch($flag){
					case "list":
						if($flag1 == 1){//전체리스트(view페이지에서)
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag);
							$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">목록보기</button><a>';
						}else{//현재 검색결과에서의 리스트(리스트 페이지에서)
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
							$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">목록보기</button><a>';
						}
					break;
					case "write":
						if($adminmode <> "yes" || $this->is_admin()){
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=write");
							$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">글쓰기</button><a>';
						}
					break;	
					case "modify":
						if($adminmode <> "yes" || $this->is_admin()){
							if($this->is_admin() || $this->writeid == $mid || $this->writeid == "" ){
								$uid = $flag1 ? $flag1 : $this->uid;//리스트등 별도에서 바로 수정시 uid값을 적용//$this->showBoardIcon('modify', $list["UID"]);
								$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=modify&UID=".$uid);
								$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">수정하기</button><a>';
							}
						}
					break;
					case "save":
						if($adminmode <> "yes" || $this->is_admin()){
							$icon = '<button type="submit" class="btn btn-default">저장하기</button>';
						}
					break;
					case "reply":
						if($adminmode <> "yes" || $this->is_admin()){
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=reply&UID=".$this->uid."&cp=".$this->page_var["cp"]);
							$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">답변달기</button><a>';
						}
					break;								
					case "cancel":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=list&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						$icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">취소하기</button><a>';
					break;
					case "delete":
						if($adminmode <> "yes" || $this->is_admin()){
							if($this->is_admin() || $this->writeid == $mid || $this->writeid == "" ){
								$uid = $flag1 ? $flag1 : $this->uid;//리스트등 별도에서 바로 수정시 uid값을 적용//$this->showBoardIcon('delete', $list["UID"]);
								$icon = '<a href="javascript:DELETE_THIS(\''.$uid.'\',\''.$this->page_var["cp"].'\',\''.$this->bid.'\',\''.$this->gid.'\',\''.$this->adminmode.'\',\''.$this->optionmode.'\')"><button type="button" class="btn btn-default">삭제하기</button><a>';
							}
						}
					break;
					case "prev":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->listpre["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						if($this->listpre["UID"]) $icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">이전글</button><a>';
					break;
					case "next":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->listnext["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						if($this->listnext["UID"]) $icon = '<a href="javascript:location.replace(\''.$goto.'\')"><button type="button" class="btn btn-default">다음글</button><a>';
					break;
					case "new":
						$icon = "<img alt=\"new\" src=\"".$icon_skin_path."/new_btn.gif\" onFocus=\"this.blur()\" border=0 />";
					break;
					case "print":
						$icon = '<a href="javascript:printThis()"><button type="button" class="btn btn-default">프린트</button><a>';
					break;
					case "re":
						$icon = "<img alt=\"re\" src=\"".$icon_skin_path."/re_btn.gif\" align=absmiddle onFocus=\"this.blur()\" border=0 />";
					break;
					case "recomm":
						##ajax로 처리
						$icon = '<a href="javascript:Vote('.$this->uid.',\'g\')"><button type="button" class="btn btn-default">추천</button><a>';
					break;
					case "none_recomm":
						##ajax로 처리
						$icon = '<a href="javascript:Vote('.$this->uid.',\'b\')"><button type="button" class="btn btn-default">비추천</button><a>';	
					break;			
					case "scrap":
						$icon = "";
					break;	
					case "search":
						$icon = "";
					break;	
					case "secrete":
						$icon = "";
					break;
					case "attached":
						$icon = "";
					break;
				}
				break;
			default:
				switch($flag){
			
					case "list":
						if($flag1 == 1){//전체리스트(view페이지에서)
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag);
							$icon = "<img alt=\"목록보기\" src=\"".$icon_skin_path."/list_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\" onFocus=\"this.blur()\" />";
						}else{//현재 검색결과에서의 리스트(리스트 페이지에서)
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
							$icon = "<img alt=\"목록보기\" src=\"".$icon_skin_path."/list_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\" onFocus=\"this.blur()\" />";
						}
					break;
					case "write":
						if($adminmode <> "yes" || $this->is_admin()){
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=write");
							$icon = "<img alt=\"글쓰기\" src=\"".$icon_skin_path."/write_btn.gif\" border=\"0\" onClick=\"javascript:location.replace('".$goto."')\"  style=\"cursor:pointer\" onFocus=\"this.blur()\" />";
						}
					break;	
					case "modify":
						if($adminmode <> "yes" || $this->is_admin()){
							if($this->is_admin() || $this->writeid == $mid || $this->writeid == "" ){
								$uid = $flag1 ? $flag1 : $this->uid;//리스트등 별도에서 바로 수정시 uid값을 적용//$this->showBoardIcon('modify', $list["UID"]);
								$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=modify&UID=".$uid);
								$icon = "<img alt=\"글수정\" src=\"".$icon_skin_path."/modify_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\" onFocus=\"this.blur()\" />";
							}
						}
					break;
					case "save":
						if($adminmode <> "yes" || $this->is_admin()){
							$icon = "<input type=\"image\" alt=\"저장\" src=\"".$icon_skin_path."/save_btn.gif\" onFocus=\"this.blur()\"  id=\"save_btn\" name=\"sava_btn\" />";
						}
					break;
					case "reply":
						if($adminmode <> "yes" || $this->is_admin()){
							$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=reply&UID=".$this->uid."&cp=".$this->page_var["cp"]);
							$icon = "<img alt=\"답변\" src=\"".$icon_skin_path."/reply_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
						}
					break;								
					case "cancel":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=list&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						$icon = "<img alt=\"취소\" src=\"".$icon_skin_path."/cancel_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
					break;
					case "delete":
						if($adminmode <> "yes" || $this->is_admin()){
							if($this->is_admin() || $this->writeid == $mid || $this->writeid == "" ){
								$uid = $flag1 ? $flag1 : $this->uid;//리스트등 별도에서 바로 수정시 uid값을 적용//$this->showBoardIcon('delete', $list["UID"]);
								$icon = "<img alt=\"삭제\" src=\"".$icon_skin_path."/del_btn.gif\" onClick=\"javascript:DELETE_THIS('".$uid."','".$this->page_var["cp"]."','".$this->bid."','".$this->gid."','".$this->adminmode."','".$this->optionmode."');\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
							}
						}
					break;
					case "prev":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->listpre["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						if($this->listpre["UID"]) $icon = "<img alt=\"이전\" src=\"".$icon_skin_path."/prev_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
					break;
					case "next":
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->listnext["UID"]."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term);
						if($this->listnext["UID"]) $icon = "<img alt=\"다음\" src=\"".$icon_skin_path."/next_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
					break;
					case "new":
						$icon = "<img alt=\"new\" src=\"".$icon_skin_path."/new_btn.gif\" onFocus=\"this.blur()\" border=0 />";
					break;
					case "print":
						$icon = "<img alt=\"프린트\" src=\"".$icon_skin_path."/print_btn.gif\" onClick=\"javascript:printThis()\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
					break;
					case "re":
						$icon = "<img alt=\"re\" src=\"".$icon_skin_path."/re_btn.gif\" align=absmiddle onFocus=\"this.blur()\" border=0 />";
					break;
					case "recomm":
						/*
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->uid."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term."&RECOMMAND=g");
						$icon = "<img alt=\"추천\" src=\"".$icon_skin_path."/recomm_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
						*/
						##ajax로 처리
						$icon = "<img alt=\"추천\" src=\"".$icon_skin_path."/recomm_btn.gif\" onClick=\"Vote(".$this->uid.",'g')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
					break;
					case "none_recomm":
						/*
						$goto = $PHP_SELF."?getdata=".$this->common->getencode($default_flag."&mode=view&UID=".$this->uid."&cp=".$this->page_var["cp"]."&SEARCHTITLE=".$this->SEARCHTITLE."&searchkeyword=".urlencode($this->searchkeyword)."&search_term=".$this->search_term."&RECOMMAND=b");			
						$icon = "<img alt=\"추천\" src=\"".$icon_skin_path."/recomm_non_btn.gif\" onClick=\"javascript:location.replace('".$goto."')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";
						*/
						##ajax로 처리
						$icon = "<img alt=\"추천\" src=\"".$icon_skin_path."/recomm_non_btn.gif\" onClick=\"Vote(".$this->uid.",'b')\" style=\"cursor:pointer\"; onFocus=\"this.blur()\" />";				
					break;			
					case "scrap":
						$icon = "";
					break;	
					case "search":
						$icon = "";
					break;	
					case "secrete":
						$icon = "";
					break;
					case "attached":
						$icon = "";
					break;
				}
				break;
		}
		
		

		return $icon;
	}
	function getattachedIcon($filename){
		$ext = $this->common->getextention($filename);
		switch ($ext){
			case "docx":
				$ext = "doc";
			break;
		}
		echo "<img src='./wizboard/iconattached/default/".$ext.".gif' width='16' height='16' align='absmiddle'>";
	}
	######## 읽기/쓰기등 각종 권한 관련
	function getNickName ($MemberGrade){
		include "./config/common_array.php";
		$rtn = $gradetostr_info[$MemberGrade];
		if(!$rtn) $rtn = $MemberGrade;
		return $rtn;
	}

	function MemberGradeBoundary($minfo){
		$mgrade					= $minfo["mgrade"];
		$MemberGradeBoundary	= $this->cfg["wizboard"]["ReadMemberGradeBoundary"];
		$MemberGrade			= $this->cfg["wizboard"]["ReadMemberGrade"];
		$alertstr = "";
		switch($MemberGradeBoundary){
			case("over"):
				if($MemberGrade < $mgrade && $MemberGrade ) $alertstr = $this->getNickName($MemberGrade)." 등급 이상 회원";
			break;
			case("less"):
				if($MemberGrade > $mgrade && $MemberGrade ) $alertstr = $this->getNickName($MemberGrade)." 등급 이하 회원";
			break;
			case("only"):
				if($MemberGrade != $mgrade && $MemberGrade ) $alertstr = $this->getNickName($MemberGrade)." 등급 회원";
			break;
		}
		return $alertstr;
	}

	function MemberGenderBoundary($minfo){
		$allowedgender	= $this["wizboard"]["ListMemberGenderBoundary"];
		$mid			= $minfo["mid"];
		$sqlstr			= "select gender from wizMembers_ind where id = '".$mid."'";
		$sqlqry			= $this->dbcon->_query($sqlstr);
		$list			= $this->dbcon->_fetch_array();
		$mygender		= $list["gender"];
		$gendertxt		= $allowedgender==2?"여성":"남성";
		if($mygender <> $allowedgender){
			$this->common->js_alert('".$gendertxt." 전용입니다');
			return false;
		}else return true;
	}

	function checkperm($minfo){//$cfg["member"]를 받아옮
				#$minfo["mid"];
				#$minfo["mpasswd"];
				#$minfo["mname"];
				#$minfo["mgrade"];
				#$minfo["mgrantsta"];
				#$minfo["mlogindate"];
				#$minfo["mpoint"];
				#$minfo["mpointlogindate"];
				#$minfo["adult"];

		if($MemberGrade == "") $MemberGrade = 0;

		switch($this->mode){
			case "list":
				if(!strcmp($this->cfg["wizboard"]["ListForMember"], "checked") && !$this->is_admin()){
					if(!$minfo){
						$str = "이곳은 회원전용 게시판입니다. \\n\\n 로그인 하시겠습니까?";
						$rtnurl = base64_encode("../wizboard.php?&BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&mode=".$this->mode);
						$goto = "wizmember.php?query=login&rtnurl=".$rtnurl;
						$this->common->js_confirm($str, $goto);
					}else if($this->MemberGradeBoundary($minfo)){
						 $this->common->js_alert($this->MemberGradeBoundary($minfo)." 전용입니다 \\n\\n 관리자에게 문의 하세요"); 
					}
				}
				if($this->cfg["wizboard"]["ListMemberGenderBoundary"] && !$this->is_admin()){
					if($this->MemberGenderBoundary($minfo) == false){
						exit;
					}
				}
			break;
			case "view":
				if(!strcmp($this->cfg["wizboard"]["ReadForMember"], "checked") && !$this->is_admin()){
					if(!$minfo){
						$str = "이곳은 회원전용 게시판입니다. \\n\\n 로그인 하시겠습니까?";
						$rtnurl = base64_encode("../wizboard.php?&BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&mode=".$this->mode."&UID=".$this->uid);
						$goto = "wizmember.php?query=login&rtnurl=".$rtnurl;
						$this->common->js_confirm($str, $goto);
					}else if($this->MemberGradeBoundary($minfo)){
						 $this->common->js_alert($this->MemberGradeBoundary($minfo)." 전용입니다 \\n\\n 관리자에게 문의 하세요"); 
					}
				}
				if($ReadMemberGenderBoundary && !$_COOKIE[BOARD_PASS] && !$this->is_admin()){
					if($this->MemberGenderBoundary($minfo) == false){
						exit;
					}
				}			 
			break;
			case "write":
				if(!strcmp($this->cfg["wizboard"]["WriteForMember"], "checked") && !$this->is_admin()){
					if(!$minfo){
						$str = "이곳은 회원전용 게시판입니다. \\n\\n 로그인 하시겠습니까?";
						$rtnurl = base64_encode("../wizboard.php?&BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&mode=".$this->mode."&UID=".$this->uid);
						$goto = "wizmember.php?query=login&rtnurl=".$rtnurl;
						$this->common->js_confirm($str, $goto);

					}else if($this->MemberGradeBoundary($minfo)){
						 $this->common->js_alert($this->MemberGradeBoundary($minfo)." 전용입니다 \\n\\n 관리자에게 문의 하세요"); 
					}
				}
				if($WriteMemberGenderBoundary && !$_COOKIE[BOARD_PASS] && !$this->is_admin()){
					if($this->MemberGenderBoundary($minfo) == false){
						exit;
					}
				}

		/* Admin Writing Only Page 일경우 아래를 실행한다. */
				if(!strcmp($this->cfg["wizboard"]["AdminOnly"],"yes") && !$this->is_admin()):
					if($GID) $CookieName=$this->gid."_".$this->bid."_MEMBER_PASS";
					if ( !$_COOKIE[$CookieName] ){ 
						$goto="./wizboard.php?mode=login&BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&nmode=".$this->mode."&adminmode=".$this->adminmode."&UID=".$this->uid."&cp=".$this->page_var["cp"];
						$this->common->js_location($goto);
					}
				endif;
			break;
			default:

			break;
		}

		/* 아래 부분은 다운로드 페이지에서 처리

		if(!strcmp($DownForMember, "checked") && !$_COOKIE[MEMBER_GRADE] && !$this->is_admin()){
		echo "<script>
		con = confirm(\"자료를 다운 받으시려면 로그인 하셔야 합니다.\\n\\n 로그인 하시겠습니까?\")
		if (con==true) location.href ='../wizmember.php?query=login&file=wizboard&goto=$BID&goto1=$GID&hiddenvalue1=$category&hiddenvalue2=view&hiddenvalue3=$UID';
		else location.replace('../wizboard.php?BID=$BID&GID=$GID&category=$category');
		</script> "; 
		exit;
		}
			 
		if(!strcmp($DownForMember, "checked") && $this->MemberGradeBoundary($DownMemberGradeBoundary, $DownMemberGrade, $_COOKIE[MEMBER_GRADE]) && !$_COOKIE[BOARD_PASS] && !$_COOKIE[ROOT_PASS]){
		echo "<script>window.alert('${Member_txt}이 다운 가능합니다. \\n\\n 관리자에게 문의 하세요'); history.go(-1);</script>"; 
		exit;
		}
		  */
		if($this->cfg["wizboard"]["SecretBoard"] == 1 && !$this->is_admin()){
			$CookieName=$BID."_MEMBER_PASS";
			if ( !$_COOKIE[$CookieName] ){ 
			echo "
			<script> if(confirm('이곳은 비밀게시판입니다. \\n 보드관리자로 로그인하시겠습니까?')){
			 location.href='./wizboard.php?mode=login&BID=".$BID."&goto1=".$GID."&nmode=".$mode."&UID=".$UID."&cp=".$cp."';
			}else{
			 history.go(-1);
			}
			</script>"; 
			exit;
			}
		}
	}


	## channel 생성
	function MakeChannel(){
		$channel = $this->gid."_".$this->bid;
		$today = time();
		$todayzero = mktime(0,0,0,date("m"),date("d"),date("Y"));
		//	mkdir("${SetupPath}/table/${NewTableName}/updir", 0777);
		/* channel 폴더가 없을 경우 channel 폴더 생성 */
			if(!file_exists("./config/wizboard/channel")) mkdir("./config/wizboard/channel", 0777);
			
		/* 현재 작업 channel이 없는 경우 */
			if(!file_exists("./config/wizboard/channel/".$channel)) mkdir("./config/wizboard/channel/".$channel, 0777);
			
		/* totalcount.php 가 없을 경우 totalcount.php를 초기화하여 만들고 있을 경우는 토탈 카운트를 1씩 올린다. */
			$filepath1 = "./config/wizboard/channel/".$channel."/totalcount.php";
			if(!file_exists($filepath1)){ 
				$fp = fopen($filepath1, "w");
				fwrite($fp,"1|".$todayzero);
				fclose($fp);
			}else{
				$fileLines = file($filepath1);
				$fileArr = explode("|", $fileLines[0]);
				$NewTotalCount = $fileArr[0] + 1;
				$fp = fopen($filepath1, "w");
				fwrite($fp,$NewTotalCount."|".$fileArr[1]);
				fclose($fp);
			}

		/*  금일 daily.txt 화일 생성 및 파일 업*/
		/* totalcount.php 가 없을 경우 totalcount.php를 초기화하여 만들고 있을 경우는 토탈 카운트를 1씩 올린다. */
			$filepath2 = "./config/wizboard/channel/".$channel."/".$todayzero.".php";
			if(!file_exists($filepath2)){ 
				$fp = fopen($filepath2, "w");
				fwrite($fp,$today."\n");
				fclose($fp);
			}else{
				$fp = fopen($filepath2, "a");
				fwrite($fp,$today."\n");
				fclose($fp);
			}

			$todaycount = sizeof(file($filepath2));
			
				
		/* 금일 카운트와 비교하여 max 카운트 발생시 maxcount.php를 업데이트 한다. */
			$filepath3 = "./config/wizboard/channel/".$channel."/maxcount.php";
			if(!file_exists($filepath3)){ 
				$fp = fopen($filepath3, "w");
				fwrite($fp,"1|".$today);
				fclose($fp);
			}
			/* 기존 max 카운트 불러오기 */
			$fileLines = file($filepath3);
			$fileArr = explode("|", $fileLines[0]);
				
			if($todaycount >= $fileArr[0]){
				$fp = fopen($filepath3, "w");
				$NewTotalCount = 
				fwrite($fp,$todaycount."|".$today);
				fclose($fp);
			}

		}


	function prohibitword($cont){
		if($cont){
			$cont = strtoupper($cont);
			$prohibit_word = explode(",",strtoupper($this->cfg["wizboard"]["Write_prohibition_Word"]));
			
			for($i=0; $i<sizeof($prohibit_word); $i++){
				if(trim($prohibit_word[$i])){
					//if(eregi($prohibit_word[$i],$cont)){ //내용 체크
					if(preg_match('/$prohibit_word[$i]/i',$cont)){ //내용 체크
						$prohibit_word[$i] = addslashes($prohibit_word[$i]); //스크립트 에러를 막기 위해 사용
						$this->common->js_alert("내용에 금지된 단어인 ".$prohibit_word[$i]." 가 \\n 사용되었기 때문에 글을 등록할 수 없습니다. \\n 내용을 수정 후 다시 올려 주시기 바랍니다.");
					}
				}
			}
		}
	}

	#카테고리정보가져오기
	function getcategorylist(){
		if($this->cfg["wizboard"]["CategoryEnable"]){
			$sqlstr = "select ordernum, catname from wizTable_Category  where bid = '".$this->bid."' and gid = '".$this->gid."'";
			$this->dbcon->_query($sqlstr);
			
			while($list	= $this->dbcon->_fetch_array()):
				$ordernum	= $list["ordernum"];
				$catname	= $list["catname"];
				$categoryname[$ordernum] = $catname;
			endwhile;	
		}
		$this->categoryname = $categoryname;
	}
	
	function getselectcategory($selcat=null){
		$sqlstr = "select ordernum, catname, uid from wizTable_Category where gid = '".$this->gid."' and bid = '".$this->bid."' order by ordernum asc";
		$catqry = $this->dbcon->_query($sqlstr);
		if($this->mode == "reply"){
			echo "<input type='hidden' name='CATEGORY' value='".$selcat."'>";
			//$k = $category -1;
			echo $this->categoryname[$selcat];

		}else{
			if($this->cfg["wizboard"]["CategoryType"] == "radio"){
				while($list = $this->dbcon->_fetch_array()):
					$checked = $selcat == $list["ordernum"]?" checked":"";
					echo "<input type=\"Radio\" name=\"CATEGORY\" value=\"".$list["ordernum"]."\"".$checked.">".$list["catname"]." &nbsp;";
				endwhile;
			}else{
				echo "<select name='CATEGORY' style='BACKGROUND-COLOR: #FFFFFF; BORDER: #D0D0D0 1 solid; font-family:Tahoma; font-size:12px; color:#5E5E5E; letter-spacing: -1px; HEIGHT: 20px;'>";
				while($list = $this->dbcon->_fetch_array()):
					$selected = $selcat== $list["ordernum"]?" selected":"";
					echo "<option value=\"".$list["ordernum"]."\"".$selected.">".$list["catname"]."</option>\n";
				endwhile;
				echo "</select>";
			}
		}	
	}

	## 테이블 신규 생성관련
	function createTable($bid, $gid="root", $desc, $adminname, $pass, $group="1", $SetupPath = "../config/wizboard", $SourcePath = ".",$default_option=null){
		if(!$bid) $this->common->js_alert("bid는 반드시 존재하여야 합니다.");
		if(!$gid) $this->common->js_alert("gid는 반드시 존재하여야 합니다.");

		$tb_name = "wizTable_".$gid."_".$bid;
		$result = $this->dbcon->is_table($tb_name);
		if(!$result){
			## 중복여부 책크
			$result = $this->dbcon->get_one("select count(*) from wizTable_Main where BID='".$bid."' and GID='".$gid."'");
			if($result) $this->common->js_alert("동일테이블이름은 사용될 수 없습니다");
			

			##관련 디렉토리 생성
			$path = $SetupPath."/table/".$gid;
			$this->common->mkfolder($path);

			$spath = $path = $path."/".$bid;
			$this->common->mkfolder($path);

			## 이미지 저장 디렉토리를 생성한다.
			$path = $path."/updir";
			$this->common->mkfolder($path);

			## config 관련 default 파일 copy
			$this->copyfile($spath,$SourcePath,$default_option);

			## 테이블 메인에 입력
			$this->insert_main($bid, $gid, $desc, $adminname, $pass, $group);
			
			## 카테고리에 기본입력
			$this->insert_cat($bid, $gid);

			## 기본 테이블 생성
			$this->make_default_table($bid, $gid);

			## 리플 테이블 생성
			$this->make_reply_table($bid, $gid);
		}
	}


    function insert_main($bid, $gid, $desc, $adminname, $pass, $group){## 테이블 메인에 입력
        $ins["BID"] = $bid;
        $ins["GID"] = $gid;
        $ins["BoardDes"] = $desc;
        $ins["AdminName"] = $adminname;
        $ins["Pass"] = $pass;
        $ins["Wdate"] = time();
        $ins["login_fail_cnt"] = 0;
        $this->dbcon->insertData("wizTable_Main", $ins);
    }

	function insert_cat($bid, $gid){## 카테고리에 기본입력
        $ins["bid"] = $bid;
        $ins["gid"] = $gid;
        $ins["ordernum"] = 0;
        $ins["catname"] = "전체";
		$this->dbcon->insertData("wizTable_Category", $ins);
	}
		
	function make_default_table($bid, $gid){## 기본 테이블 생성
		$QUERY = "CREATE TABLE IF NOT EXISTS wizTable_".$gid."_".$bid." (";
		$QUERY .= "UID int(6) NOT NULL auto_increment,";
		$QUERY .= "`CATEGORY` int(5) NOT NULL default '0',";//
		$QUERY .= "ID varchar(20) NOT NULL default '',";
		$QUERY .= "NAME varchar(50) NOT NULL default '',";
		$QUERY .= "PASSWD varchar(20) NOT NULL default '',";
		$QUERY .= "EMAIL varchar(30) NOT NULL default '',";
		$QUERY .= "URL varchar(250) NOT NULL default '',";
		$QUERY .= "SUBJECT varchar(100) NOT NULL default '',";
		$QUERY .= "FLAG varchar(100) NOT NULL default '',";
		$QUERY .= "SUB_TITLE1 varchar(100) NOT NULL default '',";
		$QUERY .= "SUB_TITLE2 varchar(100) NOT NULL default '',";
		$QUERY .= "CONTENTS text NOT NULL,";
		$QUERY .= "SUB_CONTENTS1 text NOT NULL,";
		$QUERY .= "SUB_CONTENTS2 text NOT NULL,";
		$QUERY .= "THREAD varchar(10) NOT NULL default '',";
		$QUERY .= "FID int(10) NOT NULL default '0',";
		$QUERY .= "`COUNT` int(5) NOT NULL default '0',";//읽기 카운트
		$QUERY .= "RECCOUNT int(5) NOT NULL default '0',";//추천 카운트
		$QUERY .= "NONRECCOUNT int(5) NOT NULL default '0',";//비추천 카운트
		$QUERY .= "DOWNCOUNT int(5) NOT NULL default '0',";//다운카운트
		$QUERY .= "RPLCOUNT int(5) NOT NULL default '0',";//리플수
		$QUERY .= "GETPOINT int(5) NOT NULL default '0',";//게시물 점수
		$QUERY .= "UPDIR1 varchar(250) NOT NULL default '',";
		//$QUERY .= "UPDIR2 varchar(250) NOT NULL default '',";//추후 삭제
		$QUERY .= "IP varchar(15)  NOT NULL default '',";
		$QUERY .= "SPARE1 varchar(30) NOT NULL default '',";//$TxtType."|".$RepleMail."|".$Secret."|".$MainDisplay;(html(1) or txt(0)|리플|리플라이  | 리플달릴때 메일 수신여부 | 비밀게시글여부 | 게시판의 메인 공지여부
		$QUERY .= "SDATE varchar(15) NOT NULL default '0',";
		$QUERY .= "W_DATE int(11) NOT NULL default '0',";
		$QUERY .= "PRIMARY KEY  (UID)) DEFAULT CHARSET=utf8";
		$this->dbcon->_query($QUERY);
	}

	//ALTER TABLE  `wizTable_root_board09_reply` ADD  `ATTACHED` VARCHAR( 255 ) NULL AFTER  `CONTENTS`  //14.03.26일 변경
	function make_reply_table($bid, $gid){## 리플 테이블 생성
		$QUERY = "CREATE TABLE IF NOT EXISTS wizTable_".$gid."_".$bid."_reply (";
		$QUERY .= "UID int(6) NOT NULL auto_increment,";
		$QUERY .= "FLAG int(1) NOT NULL default '1',";//1: 기본, 2:역인글(트랙백)
		$QUERY .= "MID int(11) NOT NULL default '0',";
		$QUERY .= "ID varchar(20) NOT NULL default '',";
		$QUERY .= "NAME varchar(100) NOT NULL default '',";//작성자명 , 트랙백일경우 블로그명 혹은 원본글 제목
		$QUERY .= "PASSWD varchar(20) NOT NULL default '',";
		$QUERY .= "EMAIL varchar(30) NOT NULL default '',";
		$QUERY .= "URL varchar(250) NOT NULL default '',";//트랙백일경우 트랙백 URL
		$QUERY .= "SUBJECT varchar(100) NOT NULL default '',";
		$QUERY .= "CONTENTS text NOT NULL,";
		$QUERY .= "`ATTACHED` varchar(255) DEFAULT NULL,";
		$QUERY .= "`COUNT` int(5) NOT NULL default '0',";
		$QUERY .= "`RECCOUNT` int(5) NOT NULL default '0',";
		$QUERY .= "`NONRECCOUNT` int(5) NOT NULL default '0',";		
		$QUERY .= "IP varchar(15)  NOT NULL default '',";
		$QUERY .= "W_DATE int(11) NOT NULL default '0',";
		$QUERY .= "PRIMARY KEY  (UID)) DEFAULT CHARSET=utf8";
		$this->dbcon->_query($QUERY);
	}

	function copyfile($SetupPath,$SourcePath, $default_option){ ## 관련 파일을 복사한다.
		if($default_option == "mall_default"){	
			copy($SourcePath."/mall_default/config.php",$SetupPath."/config.php");
			copy($SourcePath."/mall_default/top.php",$SetupPath."/top.php");
			copy($SourcePath."/mall_default/bottom.php",$SetupPath."/bottom.php");
		}else{		
			copy($SourcePath."/default/config.php",$SetupPath."/config.php");
			copy($SourcePath."/default/top.php",$SetupPath."/top.php");
			copy($SourcePath."/default/bottom.php",$SetupPath."/bottom.php");
		}	
	}
	
	




	function delete_content($UID, $BID, $GID)
	{
		$tb_name = "wizTable_".$GID."_".$BID;
		
		/******** 삭제될 정보 가져오기 **************/
		$sqlstr="SELECT UPDIR1, ID FROM ".$tb_name." b WHERE UID=".$UID;
		$this->dbcon->_query($sqlstr);
		$LIST=$this->dbcon->_fetch_array();
	
		/******** 업로딩된 파일 삭제 **************/
		$this->common->RemoveFiles("../config/wizboard/table/".$GID."/".$BID."/updir/".$UID);
		/*
		$Updir = explode("|", $LIST["UPDIR1"]);
		for($i=0; $i < sizeof($Updir); $i++){
			if($Updir[$i] && file_exists("../config/wizboard/table/".$GID."/".$BID."/updir/$Updir[$i]")) {
				unlink("../config/wizboard/table/".$GID."/".$BID."/updir/$Updir[$i]");
			}
		}
		*/
		
		/******* 포인터 점수 삭제 *********/
		if($LIST["ID"] && $this->cfg["wizboard"]["WritingPointEnable"]){
			$point = -$this->cfg["wizboard"]["WritingPoint"];
			$content = $BID.":".$GID.":".$UID;
			$ptype="12";

			$this->common->point_fnc($LIST["ID"], $point, $ptype, $contents);
		}
		
		/******* 리플 테이블로 부터 정보 삭제 *********/	
		$sqlstr="DELETE FROM ".$tb_name."_reply WHERE MID=".$UID;
		$this->dbcon->_query($sqlstr);

		/******* 테이블로 부터 정보 삭제 *********/
		$sqlstr="DELETE FROM ".$tb_name." WHERE UID=".$UID;
		$this->dbcon->_query($sqlstr);

		/******* wizTable_TotalSearch 로 부터 데이타 삭제 *********/
		$sqlstr="DELETE FROM wizTable_TotalSearch where UID=".$UID." and BID='".$BID."' and GID='".$GID."'";
		$this->dbcon->_query($sqlstr);
	}
	//$this->point_fnc($ID, $BID, $GID, $insertedid, "reple");
	function point_fnc($id, $bid, $gid, $uid, $flag){
		$tb_name = "wizTable_".$gid."_".$bid;
		$tb_name_re = $tb_name."_reply";
		$id = trim($id);

		if($id){
			switch($flag){
				case "write"://신규글 작성
					$point = $this->cfg["wizboard"]["writePoint"];
					$exp = $this->cfg["wizboard"]["writeExp"];
					$ptype = 11;
					$count = $this->getpointcnt($id, $ptype, $tb_name);
					$allowcnt = $this->cfg["wizboard"]["writePer"];
				break;
				case "reply"://리플라이등록
					# 자신의 글에 리플이 달릴경우 (포인트 제외)
					if($id){
						$sqlstr = "select FID from ".$tb_name." b where UID = '".$uid."'";
						$fid = $this->dbcon->get_one($sqlstr);
						
						$sqlstr = "select ID from ".$tb_name." b where FID = '".$fid."' and THREAD = 'A'";
						$tid = $this->dbcon->get_one($sqlstr);
						
						if(trim($tid) != $id){
							$point = $this->cfg["wizboard"]["replyPoint"];
							$exp = $this->cfg["wizboard"]["replyExp"];
							$ptype = 14;
							$count = $this->getpointcnt($id, $ptype, $tb_name);
							$allowcnt = $this->cfg["wizboard"]["writePer"];							
						}
					}
				break;
				case "reple"://리플(코멘트)등록
					# 자신의 글에 리플이 달릴경우 (포인트 제외)
					if($id){
						$sqlstr = "select MID from ".$tb_name_re." where UID = ".$uid;
						$mid = $this->dbcon->get_one($sqlstr);
						
						$sqlstr = "select ID from ".$tb_name." where UID = ".$mid;
						$tid = $this->dbcon->get_one($sqlstr);
						
						if(trim($tid) != $id){
							$point = $this->cfg["wizboard"]["commentPoint"];
							$exp = $this->cfg["wizboard"]["commentExp"];
							$ptype = 15;
							$count = $this->getpointcnt($id, $ptype, $tb_name_re);
							$allowcnt = $this->cfg["wizboard"]["commentPer"];	
							$tb_name  = $tb_name_re;	
						}
					}
				break;	
				case "recom"://추천/비추천 투표시
					# 자신의 글에 리플이 달릴경우 (포인트 제외)
					if($id){
						$point = $this->cfg["wizboard"]["rccomPoint"];
						$exp = $this->cfg["wizboard"]["rccomExp"];
						$ptype = 13;
						$count = $this->getpointcnt($id, $ptype, $tb_name_re);
						$allowcnt = $this->cfg["wizboard"]["rccomPer"];	
					}
				break;											
			
			}
			

			if(trim($id))
			{   
				if($count < $allowcnt){
					$contents = $tb_name;
					if($point) $this->common->point_fnc($id, $point, $ptype, $contents, null, $uid);
					if($exp) $this->common->point_fnc($id, $exp, $ptype, $contents, 6, $uid);
				}
			}
		}
	}
	
	function getpointcnt($id, $ptype, $contents=null)
	{
		## 금일 허락된 갯수를 책크
		$sdate = mktime(0,0,0,date("m"), date("d"), date("Y"));
		$edate = mktime(0,0,-1,date("m"), date("d")+1, date("Y"));
		if($ptype == "13")## 리플일 경우 전제 게시판에서의 총 값을 가져온다.
		{
			## 경험치에 대한 정보 가져오기
			$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='6' and wdate between ".$sdate." and ".$edate;
			$count1 = $this->dbcon->get_one($sqlstr);
			## 포인트에 대한 정보 가져오기
			$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='0' and wdate between ".$sdate." and ".$edate;
			$count2 = $this->dbcon->get_one($sqlstr);
			
			$count = $count1 > $count2 ? $count1:$count2;
			return $count;
		}
		else
		{
			## 경험치에 대한 정보 가져오기
			$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='6' and contents = '".$contents."' and wdate between ".$sdate." and ".$edate;
			$count1 = $this->dbcon->get_one($sqlstr);
			## 포인트에 대한 정보 가져오기
			$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='0' and contents = '".$contents."' and wdate between ".$sdate." and ".$edate;
			$count2 = $this->dbcon->get_one($sqlstr);
			
			$count = $count1 > $count2 ? $count1:$count2;
			return $count;
		}
	}
	
	## 지금 부터는 파일 업로드(에디터 포함)시 이미지 경로를 바꾸는 작업
	function chPathcontent($str, $uid){##본문내용의 경로 변경(에디터시)
		if(trim($str)){
			$str = str_replace("/tmp_upload/".session_id(), "/wizboard/table/".$this->gid."/".$this->bid."/updir/".$uid, $str);
		}
		return $str;
	}
	
	
	function htmleditorImg($uid){##에디터에 있는 경로 변경
		$source	= "./config/tmp_upload/".session_id();
		$dest	= "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$uid;

		if(is_dir($source)){
			$this->common->CopyFiles($source,$dest);
			$this->common->RemoveFiles($source);
		}
		return $str;
	}
	

	function moveupfile($file_arr, $uid){## 첨부된 파일 이동
		$depth	= $this->depth ?  $this->depth:".";//현재 ajax.board.php에서 호출할때는 ".."
		if(is_array($file_arr)) 
		{
			$path = $depth."/config/wizboard/table/".$this->gid."/".$this->bid."/updir/";
			$this->common->mkfolder($path.$uid);
			foreach($file_arr as $key=>$value)
			{
				if(is_file($path.$value)){
					copy($path.$value, $path.$uid."/".$value);
					unlink($path.$value);
				}
			}
		}
	}
	
	//uploadfy를 이용할 경우 현재 path가 다르다.
	function moveupfilefromTemp($file_arr, $frompath, $uid){## 첨부된 파일 이동
		if(is_array($file_arr)) 
		{
			$path = "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/";
			$this->common->mkfolder($path.$uid);
			foreach($file_arr as $key=>$value)
			{
				if(is_file($path.$value)){
					copy($frompath.$value, $path.$uid."/".$value);
					unlink($path.$value);
				}
			}

			//디렉토리를 날린다.
			$this->common->RemoveFiles($frompath);
		}
	}

	
	function gettablename($bid=null, $gid=null){
		if($bid == null) $bid = $this->bid;
		if($gid == null) $gid = $this->gid;
		$sqlstr = "select BoardDes from wizTable_Main where BID = '".$bid."' and GID = '".$gid."'";
		$tbname = $this->dbcon->get_one($sqlstr);
		return $tbname;
	}
	
	function get_attached_file($uid){
		$bid = $this->bid;
		$gid = $this->gid;
		$rtn = array();
		if($uid){
		$sqlstr = "select seq, filename from wizTable_File where bid='".$bid."' and gid='".$gid."' and pid = ".$uid." order by seq asc";
			$this->dbcon->_query($sqlstr);
			while($list = $this->dbcon->_fetch_array()):
				$seq = $list["seq"];
				$filename = $list["filename"];
				$rtn[$seq] = $filename;
			endwhile;
		}
		return $rtn;
	
	}
	
	function deletefile($bid,$gid,$file_name,$uid=null, $file_path=null){
		if(!$file_path) $file_path = "./config/wizboard/table/".$gid."/".$bid."/updir/";	
		$file = $file_path.$file_name;
		## database 정보 삭제
		$sqlstr = "select seq, pid from wizTable_File where gid='".$gid."' and bid='".$bid."' and `filename` = '".$file_name."'";
		$list = $this->dbcon->get_row($sqlstr);
		$seq = $list["seq"];
		$pid = $list["pid"];
		
		if($seq != ""){
			$sqlstr = "delete from `wizTable_File` where gid='".$gid."' and bid = '".$bid."' and `filename` = '".$file_name."'";
			$this->dbcon->_query($sqlstr);
			## 파일의 순서를 구하고 이후 파일들의 seq 를 1씩 감소시킨다.
			$sqlstr = "update wizTable_File set seq = seq - 1 where pid = '".$pid."' and seq > ".$seq;
			$this->dbcon->_query($sqlstr);
			
			if($seq == "0"){
				## 현재 seq 0(기존 1)의 파일명을 구해온다.
				$sqlstr = "select filename from wizTable_File where pid = '".$pid."' and seq = 0";
				$filename = $this->dbcon->get_one($sqlstr);				
				## 현재 게시판 테이블의 기본 파일명을 변경한다.
				$tb_name = "wizTable_".$gid."_".$bid;
				$sqlstr = "update ".$tb_name." set UPDIR1 = '".$filename."' where UID = '".$pid."'";
				$this->dbcon->_query($sqlstr);
			}
			## file삭제
			if(is_file($file)) unlink($file);
		}
	}
	
	
	
	function data_processing($post){
       // $IP        = $post["IP"] ? $REMOTE_ADDR;  $_SERVER['REMOTE_ADDR']
       
        //$tracback_wirte = new tracbackcls();
            
        $bmode				= $post["bmode"];
        $IP					= $_SERVER['REMOTE_ADDR'];
        if(is_file("./config/wizboard/table/prohibit_ip_list.php")) include "./config/wizboard/table/prohibit_ip_list.php";//쓰기 금지 아이피
        if(is_array($prohihit_ip)) if(in_array($IP, $prohibit_ip)) $this->common->js_alert("접근금지 아이피 입니다. 관리자에게 메일 주시기 바랍니다.");
        
        
        $TxtType			= $post["TxtType"] ? $post["TxtType"]:0;//텍스트 타입 0: text, 1:html
        $RepleMail			= $post["RepleMail"] ? $post["RepleMail"]:0;//리플달릴경우 메일 수신여부
        $Secret				= $post["Secret"] ? $post["Secret"]:0;//비밀 게시판 여부
        $MainDisplay		= $post["MainDisplay"] ? $post["MainDisplay"]:0;//공지글 여부
        $checkReple			= $post["checkReple"] ? $post["checkReple"]:0;//댓글가능 이기능과 아래 답글기능은 관리자단에서 허용될 경우 실지 적용된다.
        $checkReply			= $post["checkReply"] ? $post["checkReply"]:0;//답글가능
        
        $SPARE1 = $TxtType."|".$RepleMail."|".$Secret."|".$MainDisplay."|".$checkReple."|".$checkReply;
        
        $flag["txtbold"]	= $post["txtbold"];
        $flag["txtcolor"]	= $post["txtcolor"];
        $FLAG				= json_encode($flag);
        
        
       // if($CATEGORY == "" && $c_category != "") $CATEGORY = $c_category;
        //else if($CATEGORY == "") $CATEGORY = 0;
        $CATEGORY			= $post["CATEGORY"] == "" && $post["c_category"] != "" ? $post["c_category"]:$post["CATEGORY"]?$post["CATEGORY"]:0;
        
        $SUBJECT			= trim($post["SUBJECT"]);
        if(!$SUBJECT) $this->common->js_alert("제목이 빠졌네요^^");
        $SUBJECT			= addslashes($SUBJECT);
        ## DB에 저장될 DATA를 한 번 처리를 한다. */
        # 금지 단어 추출
        $this->prohibitword($post["CONTENTS"]);
        $this->prohibitword($post["SUBJECT"]);
       
		$SUB_TITLE1			= $post["SUB_TITLE1"];
        $SUB_TITLE2			= $post["SUB_TITLE2"];
		
       // if(!$NAME) $NAME    =  $cfg["member"]["mname"];
        $NAME				= !$post["NAME"] ? $cfg["member"]["mname"]:$post["NAME"];//답글가능
        $NAME				= addslashes(trim($NAME));
        //if(!$NAME) $NAME =  "admin";
        $ID					= !$post["ID"] ? $cfg["member"]["mid"]:$post["ID"];//답글가능
        $EMAIL				= !$post["EMAIL"] ? $cfg["member"]["email"]:$post["EMAIL"];//답글가능
        
       
        $W_DATE				= time();
        $SDATE				= $post["SDATE"] ? $post["SDATE"]:time();//답글가능


        $CONTENTS			= addslashes($this->ksesfilter($post["CONTENTS"]));
        $SUB_CONTENTS1		= addslashes($this->ksesfilter($post["SUB_CONTENTS1"]));
        $SUB_CONTENTS2		= addslashes($this->ksesfilter($post["SUB_CONTENTS2"]));
        
        $CONTENTS			= $this->common->puttrimstr($CONTENTS, $TxtType);
        $SUB_CONTENTS1		= is_array($post["SUB_CONTENTS1"]) ? serialize($SUB_CONTENTS1):$this->common->puttrimstr($SUB_CONTENTS1, $TxtType);//상품용등 여러개 필드를 하나에 둘때 json으로 db에 넣어 둔다.
        $SUB_CONTENTS2		= $this->common->puttrimstr($SUB_CONTENTS1, $TxtType);

        switch($bmode){
            case "write":
            $this->is_spam($post["spamfree"]);
            $THREAD = "A";
            $COUNT = 1;
            if($post["MultiFileValue"]){//다중파일 첨부로 넘어오는 경우(별도의 스킨 존재)
                //이경우 두가지 타입설정 : 1: 바로 첨부된 경우는 바로 타켓폴더에 저장,  임시적으로 tmp_upload 파일저장되는 경우 
                $uploadedFile = explode("|", $post["MultiFileValue"]);
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        @copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$value);
                        @unlink("./config/tmp_upload/".$value);
                    }
                }
            }else if($post["multiupload"] == "uploadify"){
                //uploadify 를 이용해서 이미 파일이 서버에 올라가 있는 상태임
                $uploadFilePath = "./config/tmp_upload/".session_id()."/";
                $uploadedFile   = $this->common->readFileList($uploadFilePath);
                //print_r($uploadedFile);
                
                if(is_array($uploadedFile)){
                    foreach($uploadedFile as $key => $val){
                        $cur_filename   = $uploadedFile[$key];
                        $uploadedFile[$key] = base64_encode($cur_filename);
                        rename($uploadFilePath.$cur_filename, $uploadFilePath.$uploadedFile[$key]);
                    }
                }
            }else{
                $this->common->upload_path = "./config/wizboard/table/".$this->gid."/".$this->bid."/updir";
                $this->common->ProhibitExtention = $this->cfg["wizboard"]["ProhibitExtention"];
                
                //$option1 = $Filenamereserver;
                $this->common->uploadfile("file");//업로드 완료후 아래의 $this->common->returnfile 생성됨
                $uploadedFile = $this->common->returnfile;
            }
            // 파일 업로딩 끝 
            
            /* 패밀리 아이디 생성 */
            $FID = $this->dbcon->get_one(" select max(FID)+1 from ".$this->boardname);
            
            /* board DB에 처리된 값들을 INSERT 한다. */
            unset($ins);
            $ins["CATEGORY"]		= $CATEGORY;
            $ins["ID"]				= $ID;
            $ins["NAME"]			= $NAME;
            $ins["PASSWD"]			= $post["PASSWD"];
            $ins["EMAIL"]			= $EMAIL;
            $ins["URL"]				= $URL;
            $ins["SUBJECT"]			= $SUBJECT;
            $ins["FLAG"]			= $FLAG;
            $ins["SUB_TITLE1"]		= $SUB_TITLE1;
            $ins["SUB_TITLE2"]		= $SUB_TITLE2;
            $ins["CONTENTS"]		= $CONTENTS;
            $ins["SUB_CONTENTS1"]	= $SUB_CONTENTS1;
            $ins["SUB_CONTENTS2"]	= $SUB_CONTENTS2;
            $ins["THREAD"]			= $THREAD;
            $ins["FID"]				= $FID;
            $ins["COUNT"]			= $COUNT;
            $ins["RECCOUNT"]		= $RECCOUNT;
            $ins["DOWNCOUNT"]		= $DOWNCOUNT;
            $ins["UPDIR1"]			= $uploadedFile[0];
            $ins["IP"]				= $IP;
            $ins["SPARE1"]			= $SPARE1;
            $ins["SDATE"]			= $SDATE;
            $ins["W_DATE"]			= $W_DATE;
            $this->dbcon->insertData($this->boardname, $ins);
            

            $insertedid = $this->dbcon->_insert_id();
            
            ## 업로드 관련 후단 처리시작
            //현재 업로된 파일을 db에 저장한다.
            
            //print_r($uploadedFile);
            //exit;
            if(is_array($uploadedFile)){
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        unset($ins);
                        $ins["pid"]    = $insertedid;
                        $ins["bid"]    = $this->bid;
                        $ins["gid"]    = $this->gid;
                        $ins["seq"]    = $key;
                        $ins["filename"]    = $value;
                        $this->dbcon->insertData("wizTable_File", $ins);
                    }
                }
            }
            
            
            //$현재 id를 이용해서 실제 upload 폴더 생성
            $CONTENTS = $this->chPathcontent($CONTENTS, $insertedid);
            $SUB_CONTENTS1 = $this->chPathcontent($SUB_CONTENTS1, $insertedid);
            $SUB_CONTENTS2 = $this->chPathcontent($SUB_CONTENTS2, $insertedid);
            
            $this->htmleditorImg($insertedid);//에디터 경로 변경
            
            ## 현재 첨부된 파일 위치 변경
            if($post["multiupload"] == "uploadify"){
                $frompath   = "./config/tmp_upload/".session_id()."/";
                $this->moveupfilefromTemp($uploadedFile, $frompath, $insertedid);
            }else{
                $this->moveupfile($this->common->returnfile, $insertedid);
            }
            //$Description1 = $this->htmleditorImg($Description1, $htmleditimgfolder, $uid);
            
            ## 현재 변경된 자료를 다시 한번 업데이트 시킨다.
            unset($ups);
            $ups["CONTENTS"]    = $CONTENTS;
            $ups["SUB_CONTENTS1"]    = $SUB_CONTENTS1;
            $ups["SUB_CONTENTS2"]    = $SUB_CONTENTS2;
            $this->dbcon->updateData($this->boardname, $ups, "UID=".$insertedid);

            ## 업로드 관련 후단 처리끝
            
            
            /* 토탈 보드에 자료 입력(총 검색을 위해) */
            unset($ins);
            $ins["CATEGORY"]    = $this->category;
            $ins["BID"]    = $this->bid;
            $ins["GID"]    = $this->gid;
            $ins["UID"]    = $insertedid;
            $ins["SUBJECT"]    = $SUBJECT;
            $ins["CONTENTS"]    = $CONTENTS;
            $ins["WDATE"]    = $W_DATE;  
            $this->dbcon->insertData("wizTable_TotalSearch", $ins);
            
            
            //엮인글(트랙백)에 데이타 날리기
            include_once ("./lib/class.trackback.php");
            $tracback_wirte = new tracbackcls();
            $tracback_wirte->cfg = $this->cfg;
            $url = $this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?GID=".$this->gid."&BID=".$this->bid."&UID=".$insertedid."&mode=view";
            $tracback_wirte->send_trackback($post["tb_url"], $url, $SUBJECT, $NAME, $CONTENTS);
            
            #포인트 입력하기
            $this->point_fnc($ID, $this->bid, $this->gid, $insertedid, "write");   
            
            
            
            /* 어드민에게 공지 메일 날리기 */
            if($this->cfg["board"]["MailToAdmin"] == "1"){
                $SEND_CONTENT = "<a href=\"".$this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=".$this->bid."&GID=".$this->gid."&mode=view&UID=".$insertedid."&category=category=".$this->category."\">".$this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&mode=view&UID=".$insertedid."</a> <br> 작성자 : ".$NAME." <br> <br> ".$CONTENTS;
                $TO = $cfg["admin"]["ADMIN_EMAIL"];
                $from = $NAME." <".$EMAIL.">";
                $SUBJECT = $NAME." 님이 게시판에 글을 남겼습니다.";
                $SEND_CONTENT = "<IFRAME SRC='".$this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=".$this->bid."&GID=".$this->gid."&mode=view&UID=".$insertedid."' WIDTH=780 HEIGHT=700 FRAMEBORDER=0></IFRAME>";
                $from = "From:".$from."\nContent-Type:text/html";
                $result = mail($TO, $SUBJECT , $SEND_CONTENT , $from);
                if(!$result) echo "<script>window.alert('메일발송이 실패 하였습니다.');</script>";
            //echo "\$TO=$TO, \$SUBJECT = \$SUBJECT, \$from = $from <br>";
            //exit;
            }
            /* 메일보내기 끝 */
            $getdata = $this->common->getencode("BID=".$this->bid."&GID=".$this->gid."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$this->category);
            $goto = "./wizboard.php?getdata=".$getdata;
            $str = "자료가 성공적으로 등록되었습니다";
            $this->common->js_alert($str, $goto);
        
        break;
        case "modify":
            /*** ADMIN 패스워드 가져오기 ******/
            $ADMINPWD = $this->dbcon->get_one("SELECT Pass FROM wizTable_Main WHERE BID='".$this->bid."' and GID='".$this->gid."'");
            $rtn_attached_file  = $this->get_attached_file($this->uid);
            
            //현재 수정하기 직적에 막기 때문에 이부분에 대한 프로그램 새로 할 것
            /*** 글 작성자 패스워드 및 업로딩 파일 가져오기 *****/
            $sql = "SELECT ID, PASSWD, UPDIR1 FROM ".$this->boardname." WHERE UID=".$this->uid;
            $LIST=$this->dbcon->get_row($sql);
            //  $UPDIRF = explode("|", $LIST[UPDIR1]); /* 현재 업로딩 된 파일 가져오기 */
            $LIST["PASSWD"]=trim($LIST["PASSWD"]);
            if($post["PASSWD"] && $post["PASSWD"] != $LIST["PASSWD"] && $post["PASSWD"] !=$ADMINPWD["Pass"]) { // 비회원 게시판으로 패스워드를 입력하는 폼이라면 입력된 패스워드를 상효 비교한다.
                $this->common->js_alert("글작성시 패스워드를 입력해주세요.");
            }else if (($_COOKIE["MODIFY"] != $this->uid."_".$this->bid."_".$this->gid) ){ //회원전용폼으로 패스워드 입력란이 없으면 보드관리자가 아니고 super관리자가 아니면
            //현재 로그인된 아이디와 글작성시 아이디를 비교하여 수정여부를 선택한다. 
                $this->common->js_alert("등록자본인만이 수정가능합니다.");
            }else{ //마지막 까지 update flow start 
            
            if($post["MultiFileValue"]){//다중파일 첨부로 넘어오는 경우
                $uploadedFile = explode("|", $post["MultiFileValue"]);
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        @copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$value);
                        @unlink("./config/tmp_upload/".$value);
                    }
                }
            }else if($post["multiupload"] == "uploadify"){
                //uploadify 를 이용해서 이미 파일이 서버에 올라가 있는 상태임
                //$rtn_attached_file    = array();
                //$newuploadedFile  = array();
                if(is_array($post["file_del"])){
                    foreach($file_del as $key=>$val){
                        $uploaded_path  = "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$this->uid;
                        unlink($uploaded_path."/".$rtn_attached_file[$key]);
                        $rtn_attached_file[$key] = "";
                    }
                }
                
                //print_r($rtn_attached_file);
                //새로이 배열을 정리한다.
                if(is_array($rtn_attached_file)){
                   asort($rtn_attached_file);
                    foreach( $rtn_attached_file as $key => $val){
                        if($val){
                            $uploadedFile[] = $val;
                        }
                    } 
                }
                
                $uploadFilePath = "./config/tmp_upload/".session_id()."/";
                $newuploadedFile    = $this->common->readFileList($uploadFilePath);
                if(is_array($newuploadedFile)){
                    foreach($newuploadedFile as $key => $val){
                        $cur_filename   = $newuploadedFile[$key];
                        $uploadedFile[] = $newuploadedFile[$key] = base64_encode($cur_filename);
                        rename($uploadFilePath.$cur_filename, $uploadFilePath.$newuploadedFile[$key]);
                    }
                }
            }else{  
                // 파일 업로딩 시작 
                
                $this->common->upload_path        = "./config/wizboard/table/".$this->gid."/".$this->bid."/updir";
                $this->common->ProhibitExtention  = $this->cfg["wizboard"]["ProhibitExtention"];
                $this->common->uploadmode         = "update";
                $this->common->oldfilename        = implode("|", $rtn_attached_file);
                $this->common->delfile            = $post["file_del"];
                //$option1 = $Filenamereserver;
                $this->common->uploadfile("file");
                $uploadedFile = $this->common->returnfile;
                // 파일 업로딩 끝     
            }   
            // 파일 업로딩 끝 
            
            
            ## 업로드 관련 후단 처리시작
            //현재 업로된 파일을 db에 저장한다.
            if(is_array($uploadedFile)){
                asort($uploadedFile);
                $sqlstr = "delete from wizTable_File where bid='".$this->bid."' and gid = '".$this->gid."' and pid=".$this->uid;
                $this->dbcon->_query($sqlstr);
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        unset($ins);
                        $ins["pid"]    = $this->uid;
                        $ins["bid"]    = $this->bid;
                        $ins["gid"]    = $this->gid;
                        $ins["seq"]    = $key;
                        $ins["filename"]    = $value;
                        $this->dbcon->insertData("wizTable_File", $ins);
                    }
                }
            }
            
            //$현재 id를 이용해서 실제 upload 폴더 생성
            $CONTENTS = $this->chPathcontent($CONTENTS, $this->uid);
            $SUB_CONTENTS1 = $this->chPathcontent($SUB_CONTENTS1, $this->uid);
            $SUB_CONTENTS2 = $this->chPathcontent($SUB_CONTENTS2, $this->uid);
            
            $this->htmleditorImg($this->uid);//에디터 경로 변경
            
            ## 현재 첨부된 파일 위치 변경
            $this->moveupfile($this->common->returnfile, $this->uid);
            ## 업로드 관련 후단 처리끝
            
            
            /* board DB에 처리된 값들을 INSERT 한다. */
            unset($ups);
            $ups["CATEGORY"]    = $CATEGORY;
           // $ups["ID"]    = $ID;
            $ups["NAME"]    = $NAME;
            //$ups["PASSWD"]    = $PASSWD;
            $ups["EMAIL"]    = $EMAIL;
            $ups["URL"]    = $URL;
            $ups["SUBJECT"]    = $SUBJECT;
            $ups["FLAG"]    = $FLAG;
            $ups["SUB_TITLE1"]    = $SUB_TITLE1;
            $ups["SUB_TITLE2"]    = $SUB_TITLE2;
            $ups["CONTENTS"]    = $CONTENTS;
            $ups["SUB_CONTENTS1"]    = $SUB_CONTENTS1;
            $ups["SUB_CONTENTS2"]    = $SUB_CONTENTS2;
            //$ups["THREAD"]    = $THREAD;
            //$ups["FID"]    = $FID;
            //$ups["COUNT"]    = $COUNT;
            //$ups["RECCOUNT"]    = $RECCOUNT;
           // $ups["DOWNCOUNT"]    = $DOWNCOUNT;
            $ups["UPDIR1"]    = $uploadedFile[0];
           // $ups["IP"]    = $IP;
            $ups["SPARE1"]    = $SPARE1;
            $ups["SDATE"]    = $SDATE;
           //$ups["W_DATE"]    = $W_DATE;
            $this->dbcon->updateData($this->boardname, $ups, "UID=".$this->uid);

            
            
            /* 토탈 보드에 자료 UPDATE */
            unset($ups);
            $ups["CATEGORY"]    = $CATEGORY;
            //$ups["BID"]    = $this->bid;
            //$ups["GID"]    = $this->gid;
            //$ups["UID"]    = $upsertedid;
            $ups["SUBJECT"]    = $SUBJECT;
            $ups["CONTENTS"]    = $CONTENTS;
            //$ups["WDATE"]    = $W_DATE;  
            $this->dbcon->updateData("wizTable_TotalSearch", $ups, "UID=".$this->uid." and BID='".$this->bid."' and GID='".$this->gid."'");
            
            
            if($flag == "write_only") $tmode = "write";
            else $tmode = "";
            $getdata = $this->common->getencode("BID=".$this->bid."&GID=".$this->gid."&mode=".$tmode."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$CATEGORY."&mode=view&UID=".$this->uid."&cp=".$post["cp"]."&BOARD_NO=".$post["BOARD_NO"]);
            $this->common->js_location("./wizboard.php?getdata=".$getdata);
            }
        break;
        case "reply":
            $this->is_spam($post["spamfree"]);
            if(substr($SUBJECT,0,4)=="Re: ") $SUBJECT=substr($SUBJECT,4);
            //echo "\$CONTENTS1 = $CONTENTS <br>";
            $CONTENTSOri = explode("[원본내용]", $CONTENTS);
            $CONTENTS = addslashes($CONTENTSOri[0]);
           // $THREAD = "A";
            $COUNT = 1;
           // $NEW_THREAD="A";
            
            $sql = "SELECT FID,THREAD,EMAIL,SPARE1 FROM ".$this->boardname." WHERE UID=".$this->uid;
            $LIST               = $this->dbcon->get_row($sql);
            $CURRENT_FID        = $LIST["FID"];
            $CURRENT_THREAD     = $LIST["THREAD"];
            $CURRENT_EMAIL      = $LIST["EMAIL"];
            
            if($CURRENT_FID == ""){//참조아이디가 없거나 삭제된경우
            $this->common->js_alert("존재하지 않는 게시물에 리플을 달수가 없습니다.");
            }       
            
            $LIST = $this->dbcon->get_one("SELECT right(THREAD,1) from ".$this->boardname." WHERE FID='".$CURRENT_FID."' and length('".$CURRENT_THREAD."')+1=length(THREAD) and locate('".$CURRENT_THREAD."',THREAD)=1 order by THREAD DESC limit 0,1");
            if($LIST) {
                $MORE_THREAD=$LIST[0];
                $FUTURE_THREAD=$CURRENT_THREAD.chr(ord($MORE_THREAD)+1);
            } else {
                $FUTURE_THREAD=$CURRENT_THREAD."A";
            }
            
            
            if($post["MultiFileValue"]){//다중파일 첨부로 넘어오는 경우(별도의 스킨 존재)
                //이경우 두가지 타입설정 : 1: 바로 첨부된 경우는 바로 타켓폴더에 저장,  임시적으로 tmp_upload 파일저장되는 경우 
                $uploadedFile = explode("|", $post["MultiFileValue"]);
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        @copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$this->gid."/".$this->bid."/updir/".$value);
                        @unlink("./config/tmp_upload/".$value);
                    }
                }
            }else{
                $this->common->upload_path = "./config/wizboard/table/".$this->gid."/".$this->bid."/updir";
                $this->common->ProhibitExtention = $cfg["wizboard"]["ProhibitExtention"];
                $this->common->uploadfile("file");//업로드 완료후 아래의 $this->common->returnfile 생성됨
                $uploadedFile = $this->common->returnfile;
            }
            
            
            
            
            unset($ins);
            $ins["CATEGORY"]    = $CATEGORY;
            $ins["ID"]    = $ID;
            $ins["NAME"]    = $NAME;
            $ins["PASSWD"]    = $post["PASSWD"];
            $ins["EMAIL"]    = $EMAIL;
            $ins["URL"]    = $URL;
            $ins["SUBJECT"]    = $SUBJECT;
            //$ins["FLAG"]    = $FLAG;
            $ins["SUB_TITLE1"]    = $SUB_TITLE1;
            $ins["SUB_TITLE2"]    = $SUB_TITLE2;
            $ins["CONTENTS"]        = $CONTENTS;
            $ins["SUB_CONTENTS1"]    = $SUB_CONTENTS1;
            $ins["SUB_CONTENTS2"]    = $SUB_CONTENTS2;
            $ins["THREAD"]    = $FUTURE_THREAD;
            $ins["FID"]    = $CURRENT_FID;
            $ins["COUNT"]    = $COUNT;
            $ins["RECCOUNT"]    = $RECCOUNT;
            $ins["DOWNCOUNT"]    = $DOWNCOUNT;
            $ins["UPDIR1"]    = $uploadedFile[0];
            $ins["IP"]    = $IP;
            $ins["SPARE1"]    = $SPARE1;
            $ins["SDATE"]    = $SDATE;
            $ins["W_DATE"]    = $W_DATE;
            $this->dbcon->insertData($this->boardname, $ins);
            

            $insertedid = $this->dbcon->_insert_id();
                       
            ## 업로드 관련 후단 처리시작
            //현재 업로된 파일을 db에 저장한다.
            if(is_array($uploadedFile)){
                foreach($uploadedFile as $key=>$value){
                    if($value){
                        unset($ins);
                        $ins["pid"]    = $insertedid;
                        $ins["bid"]    = $this->bid;
                        $ins["gid"]    = $this->gid;
                        $ins["seq"]    = $key;
                        $ins["filename"]    = $value;
                        $this->dbcon->insertData("wizTable_File", $ins);
                    }
                }
            }           
            //$현재 id를 이용해서 실제 upload 폴더 생성
            $CONTENTS = $this->chPathcontent($CONTENTS, $insertedid);
            $SUB_CONTENTS1 = $this->chPathcontent($SUB_CONTENTS1, $insertedid);
            $SUB_CONTENTS2 = $this->chPathcontent($SUB_CONTENTS2, $insertedid);
            
            $this->htmleditorImg($insertedid);//에디터 경로 변경
            
            ## 현재 첨부된 파일 위치 변경
            $this->moveupfile($this->common->returnfile, $insertedid);
            
            //$Description1 = $this->htmleditorImg($Description1, $htmleditimgfolder, $uid);
            
            ## 현재 변경된 자료를 다시 한번 업데이트 시킨다.
            unset($ups);
            $ups["CONTENTS"]    = $CONTENTS;
            $ups["SUB_CONTENTS1"]    = $SUB_CONTENTS1;
            $ups["SUB_CONTENTS2"]    = $SUB_CONTENTS2;
            $this->dbcon->updateData($this->boardname, $ups, "UID=".$insertedid);
            ## 업로드 관련 후단 처리끝
            
            /* 토탈 보드에 자료 입력(총 검색을 위해) */
            unset($ins);
            $ins["CATEGORY"]    = $this->category;
            $ins["BID"]    = $this->bid;
            $ins["GID"]    = $this->gid;
            $ins["UID"]    = $insertedid;
            $ins["SUBJECT"]    = $SUBJECT;
            $ins["CONTENTS"]    = $CONTENTS;
            $ins["WDATE"]    = $W_DATE;  
            $this->dbcon->insertData("wizTable_TotalSearch", $ins);
            
            
            #포인트 입력하기
            $this->point_fnc($ID, $this->bid, $this->gid, $insertedid, "reply");
            
            
            /* Mail_Receive = 1 이면 Writer_Email 메일을 보낸다. */
            if($post["RepleMail"] == "1" && $post["CURRENT_EMAIL"]){
            $SEND_CONTENT = "<a href=\"".$this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=".$this->bid."&GID=".$this->gid."&mode=view&UID=".$insertedid."&category=category=".$this->category."\">".$this->cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=".$this->bid."&GID=".$this->gid."&category=".$this->category."&mode=view&UID=".$insertedid."</a> <br> 작성자 : ".$NAME." <br> <br> ".$CONTENTS;
            $TO         = $post["CURRENT_EMAIL"];
            $from           = $NAME." <".$EMAIL.">";
            $SUBJECT    = "답변글이 도착하였습니다.";
            $from           = "From:".$from."\nContent-Type:text/html";
            $result     = mail($TO, $SUBJECT , $SEND_CONTENT , $from);
            if(!$result) $this->common->js_alert("메일발송이 실패 하였습니다.", "", "alert");
            }
            
            if($flag == "write_only") $tmode = "write";
            else $tmode = "";
            $getdata = $this->common->getencode("BID=".$this->bid."&GID=".$this->gid."&mode=".$tmode."&adminmode=".$this->adminmode."&optionmode=".$this->optionmode."&category=".$this->category."&cp=".$post["cp"]);
            $this->common->js_location("./wizboard.php?getdata=".$getdata);
        break;
        } 
	}

	
	/**
     * 댓글 등록(reply table)
     */
     function insertreple($post){
        $ID     = $post["ID"] ? $post["ID"]: $this->cfg["member"]["mid"];
        $NAME   = $post["NAME"] ? $post["NAME"]: $this->cfg["member"]["mname"];

		$CONTENTS               = addslashes($this->ksesfilter($post["CONTENTS"]));       
        $CONTENTS               = $this->common->puttrimstr($CONTENTS, 0);//텍스트

        $FLAG		=  $post["FLAG"] ? $post["FLAG"] : 1;
        
		$depth	= $this->depth ?  $this->depth:".";//현재 ajax.board.php에서 호출할때는 ".."
		$this->common->upload_path			= $depth."/config/wizboard/table/".$this->gid."/".$this->bid."/updir";
		$this->common->ProhibitExtention	= $this->cfg["wizboard"]["ProhibitExtention"];
		//$option1 = $Filenamereserver;
		$this->common->uploadfile("file");//업로드 완료후 아래의 $this->common->returnfile 생성됨
		$uploadedFile = $this->common->returnfile;
				
        $ins["FLAG"]    = $FLAG;
        $ins["MID"]    	= $this->uid;
        $ins["ID"]    	= $ID;
        $ins["NAME"]    = $NAME;
        $ins["PASSWD"]  = $post["PASSWD"];
        $ins["EMAIL"]   = $post["EMAIL"];
        $ins["URL"]		= $post["URL"];
        $ins["SUBJECT"]	= $post["SUBJECT"];
        $ins["CONTENTS"]= $post["CONTENTS"];
		$ins["ATTACHED"]= $uploadedFile[0];
		
        $ins["COUNT"]   = 0;
        $ins["W_DATE"]  = time();
		//print_r($ins);
		//exit;
        $this->dbcon->insertData($this->boardname."_reply",$ins );
        $insertedid = $this->dbcon->_insert_id();
        //게시글 아이디를 구한후 파일을 이동시킨다.
		$this->moveupfile($this->common->returnfile, $this->uid);
        
        ## 부모글에 리플 카운트 올리기
        $sqlstr = "update ".$this->boardname." set RPLCOUNT = RPLCOUNT + 1 where UID = ".$this->uid; 
        $this->dbcon->_query($sqlstr);
        
        #포인트 입력하기
        $this->point_fnc($ID, $this->bid, $this->gid, $insertedid, "reple");
        
		if($this->processmode == "ajax"){
			echo "<script>var result = 0;</script>";
		}else{
			$goto = "./wizboard.php?BID=".$this->bid."&GID=".$this->gid."&mode=view&adminmode=".$this->adminmode."&UID=".$this->uid."&category=".$this->category."&cp=".$post["cp"]."&BOARD_NO=".$post["BOARD_NO"];
        	$this->common->js_alert("자료가 성공적으로 등록되었습니다", $goto);
		}
      
         
     }

     /**
      * 댓글 수정(reply table)
      */
      function updatereple($post){
        //0. 관리자인지 비교
        //1. 현재아이디와 등록자 아이디 비교
        //2. 현재패스워드와 등록시 패스워드 비교
        $this->is_spam($post["spamfree"]);
        
        if($cfg["member"]["mgrade"] == "admin"){
        $status = "1";
        }else{
        if(!$ID) $ID    = $cfg["member"]["mid"];
            $sql = "SELECT ID, PASSWD FROM ".$this->boardname."_reply WHERE UID=".$post["RUID"];
            $list = $this->dbcon->get_row($sql);
            if($list["ID"] == $post["ID"]){
                $status = "1";
            }else if($list["PASSWD"] == $post["PASSWD"]){
                $status = "1";
            }
        }
        //echo "status = $status <br>";
        //exit; 
        if($status <> "1"){
            $this->common->js_alert("본인이 작성한 글이 아니거나 \\n수정할 권한이 없습니다.");
        }else{
            $ID     = $post["ID"] ? $post["ID"]: $this->cfg["member"]["mid"];
            $NAME   = $post["NAME"] ? $post["NAME"]: $this->cfg["member"]["mname"];
            $W_DATE=time();
            $CONTENTS = addslashes($CONTENTS);
            $CONTENTS = str_replace("<", "&lt;", $CONTENTS);
            $CONTENTS = str_replace(">", "&gt;", $CONTENTS);
            $CONTENTS = str_replace("\"", "&quot;", $CONTENTS);
            $CONTENTS = str_replace("|", "&#124;", $CONTENTS);
            
            $ups["EMAIL"]    = $post["EMAIL"];
            $ups["SUBJECT"]    = $post["SUBJECT"];
            $ups["CONTENTS"]    = $post["CONTENTS"];
            $ups["RUID"]    = $post["RUID"];

            $this->dbcon->updateData($this->boardname."_reply", $ups, "UID=".$post["RUID"]);
            $goto = "./wizboard.php?BID=".$this->bid."&GID=".$this->gid."&mode=view&adminmode=".$this->adminmode."&UID=".$this->uid."&category=".$this->category."&cp=".$post["cp"]."&BOARD_NO=".$post["BOARD_NO"];
       
            $this->common->js_alert("자료가 성공적으로 수정되었습니다", $goto);
        }
      }
      
	/**
     * 댓글 삭제(reply table)
	 * deletecomment 로 데처
	 * @DEPRECATED
     */
	function deletereple($uid, $tb_name){//댓글삭제
		## 부모글 구하기
		$sqlstr = "select MID from ".$tb_name." WHERE UID=".$uid;
		$mid = $this->dbcon->get_one($sqlstr);
		
		$this->dbcon->deleteData($tb_name, "UID = ".$uid);
		## 부모글에 리플 카운트 내리기
		$m_tb_name = substr($tb_name, 0, -6);//wizTable_${GID}_${BID}_reply";
		$sqlstr = "update ".$m_tb_name." set RPLCOUNT = RPLCOUNT - 1 where UID = ".$mid; 
		$this->dbcon->_query($sqlstr);
        
	}
	
	/**
	 * 
	 */
	function deletecomment(){
		
		$gid			= $_POST["GID"];
		$bid			= $_POST["BID"];
		$comment_uid	= $_POST["CUID"];
		$tb_name="wizTable_".$gid."_".$bid."_reply";
		
		$passwd			= trim($_POST["passwd"]);
		
		if($comment_uid){
			
			## 게시글 정보 가져오기
			$sqlstr="SELECT ID,NAME,PASSWD,MID FROM ".$tb_name." WHERE UID=".$comment_uid;
			$list=$this->dbcon->get_row($sqlstr);
			$list["PASSWD"]=trim($list["PASSWD"]);
			
			if($list["ID"] == $this->cfg["member"]["mid"] || $this->is_admin() || $list["PASSWD"] == $passwd){
				//삭제 실행	
				$this->dbcon->deleteData($tb_name, "UID = ".$comment_uid);
				## 부모글에 리플 카운트 내리기
				$m_tb_name = substr($tb_name, 0, -6);//wizTable_${GID}_${BID}_reply";
				$sqlstr = "update ".$m_tb_name." set RPLCOUNT = RPLCOUNT - 1 where UID = ".$list["MID"]; 
				$this->dbcon->_query($sqlstr);
				$rtn["result"]	= 0;
				$rtn["msg"]		= "성공적으로 삭제되었습니다.";
			}else{
				$rtn["result"]	= 2;
				$rtn["msg"]		= "권한이 없습니다.";
			}
		}else{
			$rtn["result"]	= 1;
			$rtn["msg"]		= "잘못된 경로로 접근하였습니다.";
		}
		
		echo json_encode($rtn);
			## ADMIN 패스워드 가져오기 
			//$ADMIN_STR="SELECT Pass FROM wizTable_Main WHERE BID='$BID' and GID='$GID'";
			//$ADMINPWD=$dbcon->get_one($ADMIN_STR);;
			
			/*** 글 작성자 패스워드 가져오기 *
			if($member != "1"){ //회원제가 아닐경우
				if($passwd != $list["PASSWD"] && $passwd !=$ADMINPWD) $common->js_alert("패스워드가 틀립니다.");
			
			}else if(!$board->is_admin("../../../")){ //회원제일 경우 로그인 여부를 책크 및 로그인 아이디및 게시판 아이디 필드를 비교한다. 
				if(!$cfg["member"]) $common->js_windowclose("먼저 로그인 하여 주시기 바랍니다.");
				if(!trim($list[ID]) || ($cfg["member"]["mid"] != $list[ID])){
					$common->js_windowclose("글을 삭제할 권한이 없습니다 \\n\\n 글작성시 아이디로 로긴 하여 주시기 바랍니다.");
				}
			}
			
			$sqlstr = "select MID from ".$tb_name." WHERE UID=".$comment_uid;
			$mid = $this->dbcon->get_one($sqlstr);
			
			$this->dbcon->deleteData($tb_name, "UID = ".$comment_uid);
			## 부모글에 리플 카운트 내리기
			$m_tb_name = substr($tb_name, 0, -6);//wizTable_${GID}_${BID}_reply";
			$sqlstr = "update ".$m_tb_name." set RPLCOUNT = RPLCOUNT - 1 where UID = ".$mid; 
			$this->dbcon->_query($sqlstr);
		}
		/*
		 * $tb_name="wizTable_${GID}_${BID}_reply";
//include "../../../config/wizboard/table/${GID}/${BID}/config.php";

if($mode==ok) {
	if($UID=='') $common->js_alert("잘못된 경로의 접근입니다.","/wizboard.php?BID=$BID&GID=$GID");

	/* 현재 삭제될 글의 상세정보를 가져온다 *
		 * 	
	

/******* 테이블로 부터 정보 삭제 **
	$board->deletereple($UID, $tb_name);
	$goto = "../../../wizboard.php?BID=${BID}&GID=${GID}&mode=view&adminmode=${adminmode}&UID=${BUID}&cp=${cp}&BOARD_NO=${BOARD_NO}";
	$common->js_windowclose("게시물을 삭제했습니다.", $goto);
}
*/		
		
	}
    
    /**
     * 보안필터 적용
     */
    function ksesfilter($val){
    	$depth	= $this->depth ? $this->depth:".";
        include_once ($depth."/lib/function.kses.php");
        $allowed = array('b' => array(),
            'i' => array(),
            'a' => array('href'  => 1, 'title' => array('valueless' => 'n'), 'target'=>1),
            'p' => array('align' => 1,
            'dummy' => array('valueless' => 'y')),
            'table' => array('align' => 1, 'border' => 1, 'cell' => 1, 'style' => 1, 'cellpadding' => 1, 'cellspacing'=>1, 'class'=>1), 
			'tr' => array('align' => 1, 'class'=>1), 
			'td' => array('style' => 1, 'width' => 1, 'class'=>1), 
			'tbody' => array(),
            'img' => array('src' => 1), # FIXME
            'font' => array('size' =>
            array('minval' => 4, 'maxval' => 20)),
            'br' => array());
        $val = stripslashes($val);//slahse가 있을 경우 모두 지움
        $val = kses($val, $allowed, array('http', 'https'));
        if (get_magic_quotes_gpc()) $val = stripslashes($val);
        return $val;
    }
		
}