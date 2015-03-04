<?php
//삭제됨
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
/*
set_time_limit (0);
//ini_set(max_input_time, 0);
//ini_set(max_execution_time, 0); 
//ini_set(upload_max_filesize, "100M");
//ini_set(post_max_size, "100M");


	$IP		= $_SERVER["REMOTE_ADDR"];
	if(is_array($prohihit_ip)) if(in_array($IP, $prohibit_ip)) $common->js_alert("접근금지 아이피 입니다. 관리자에게 메일 주시기 바랍니다.");

	
	if(!$TxtType) $TxtType=0;//텍스트 타입 0: text, 1:html
	if(!$RepleMail) $RepleMail=0;//리플달릴경우 메일 수신여부
	if(!$Secret) $Secret=0;//비밀 게시판 여부
	if(!$MainDisplay) $MainDisplay=0;//공지글 여부
	if($checkReple == "") $checkReple=0;//댓글가능 이기능과 아래 답글기능은 관리자단에서 허용될 경우 실지 적용된다.
	if($checkReply == "") $checkReple=0;//답글가능
	
	$SPARE1 = $TxtType."|".$RepleMail."|".$Secret."|".$MainDisplay."|".$checkReple."|".$checkReply;
	
	$flag["txtbold"]	= $_POST["txtbold"];
	$flag["txtcolor"]	= $_POST["txtcolor"];
	$FLAG	= json_encode($flag);
		
	
	if($CATEGORY == "" && $c_category != "") $CATEGORY = $c_category;
	else if($CATEGORY == "") $CATEGORY = 0;

	$SUBJECT = trim($SUBJECT);
	if(!$SUBJECT) $common->js_alert("제목이 빠졌네요^^");
	
	## DB에 저장될 DATA를 한 번 처리를 한다. 
	# 금지 단어 추출
	$board->prohibitword($CONTENTS);
	$board->prohibitword($SUBJECT);
	
	if(!$NAME) $NAME	=  $cfg["member"]["mname"];
	$NAME				= addslashes(trim($NAME));
	//if(!$NAME) $NAME =  "admin";
			
	if(!$ID) $ID		=  $cfg["member"]["mid"];
	if(!$EMAIL) $EMAIL	=  $cfg["member"]["email"];
	
	
	$W_DATE=time();
	if(!$SDATE) $SDATE = time();
	
	$CONTENTS				= $common->puttrimstr($CONTENTS, $TxtType);
	$SUB_CONTENTS1	= is_array($SUB_CONTENTS1) ? serialize($SUB_CONTENTS1):$common->puttrimstr($SUB_CONTENTS1, $TxtType);//상품용등 여러개 필드를 하나에 둘때 json으로 db에 넣어 둔다.
	$SUB_CONTENTS2	= $common->puttrimstr($SUB_CONTENTS2, $TxtType);
	$SUBJECT					= addslashes($SUBJECT);
	$CONTENTS				= addslashes($CONTENTS);
		
		
					
			
	switch($bmode){
		case "write":
			$THREAD = "A";
			$COUNT = 1;
			if($MultiFileValue){//다중파일 첨부로 넘어오는 경우(별도의 스킨 존재)
				//이경우 두가지 타입설정 : 1: 바로 첨부된 경우는 바로 타켓폴더에 저장,  임시적으로 tmp_upload 파일저장되는 경우 
				$uploadedFile = explode("|", $MultiFileValue);
				foreach($uploadedFile as $key=>$value){
					if($value){
						@copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$GID."/".$BID."/updir/".$value);
						@unlink("./config/tmp_upload/".$value);
					}
				}
			}else if($multiupload == "uploadify"){
				//uploadify 를 이용해서 이미 파일이 서버에 올라가 있는 상태임
				$uploadFilePath	= "./config/tmp_upload/".session_id()."/";
				$uploadedFile	= $common->readFileList($uploadFilePath);
//print_r($uploadedFile);

				if(is_array($uploadedFile)){
					foreach($uploadedFile as $key => $val){
						$cur_filename	= $uploadedFile[$key];
						$uploadedFile[$key] = base64_encode($cur_filename);
						rename($uploadFilePath.$cur_filename, $uploadFilePath.$uploadedFile[$key]);
					}
				}
//print_r($uploadedFile);
//exit;
			}else{
				$common->upload_path = "./config/wizboard/table/".$GID."/".$BID."/updir";
				$common->ProhibitExtention = $cfg["wizboard"]["ProhibitExtention"];
				
				//$option1 = $Filenamereserver;
				$common->uploadfile("file");//업로드 완료후 아래의 $common->returnfile 생성됨
				$uploadedFile = $common->returnfile;
				//$UPDIR1 = "";
				//if(is_array($common->returnfile)) foreach($common->returnfile as $key=>$value) $UPDIR1 .= $value."|";
			
				//uploadfile($funcmode="insert", $file_field_name="file", $upload_path, $return1="UPDIR1", $return2="UPDIR2", $oldfilename1, $oldfilename2, $prohibitextension, $option1, $option2);
			}
			// 파일 업로딩 끝 
	
			//패밀리 아이디 생성 
			$FID = $dbcon->get_one(" select max(FID)+1 from ".$tb_name);
	
			// board DB에 처리된 값들을 INSERT 한다.
			$sqlstr = "INSERT INTO $tb_name 
			(CATEGORY,ID,NAME,PASSWD,EMAIL,URL,SUBJECT,FLAG,SUB_TITLE1,SUB_TITLE2,CONTENTS,SUB_CONTENTS1,SUB_CONTENTS2,THREAD,FID,COUNT,RECCOUNT,DOWNCOUNT,UPDIR1,IP,SPARE1,SDATE,W_DATE) 
			VALUES
			('$CATEGORY','$ID','$NAME','$PASSWD','$EMAIL','$URL','$SUBJECT','$FLAG','$SUB_TITLE1','$SUB_TITLE2','$CONTENTS','$SUB_CONTENTS1','$SUB_CONTENTS2','$THREAD'
			,'$FID','$COUNT','$RECCOUNT','$DOWNCOUNT','".$uploadedFile[0]."','$IP','$SPARE1','$SDATE','$W_DATE')"; 
	
			$dbcon->_query($sqlstr);
			$insertedid = $dbcon->_insert_id();
			
			## 업로드 관련 후단 처리시작
			//현재 업로된 파일을 db에 저장한다.

			//print_r($uploadedFile);
			//exit;
			if(is_array($uploadedFile)){
				foreach($uploadedFile as $key=>$value){
					if($value){
						$sqlstr = "insert into wizTable_File (pid, bid, gid, seq,filename) values ($insertedid, '$BID', '$GID', $key, '$value')";
						$dbcon->_query($sqlstr);
					}
				}
			}

			
			//$현재 id를 이용해서 실제 upload 폴더 생성
			$CONTENTS = $board->chPathcontent($CONTENTS, $insertedid);
			$SUB_CONTENTS1 = $board->chPathcontent($SUB_CONTENTS1, $insertedid);
			$SUB_CONTENTS2 = $board->chPathcontent($SUB_CONTENTS2, $insertedid);
			
			$board->htmleditorImg($insertedid);//에디터 경로 변경
			
			## 현재 첨부된 파일 위치 변경
			if($multiupload == "uploadify"){
				$frompath	= "./config/tmp_upload/".session_id()."/";
				$board->moveupfilefromTemp($uploadedFile, $frompath, $insertedid);

				//exit;
				//moveupfilefromTemp($file_arr, $frompath, $uid)
			}else{
				$board->moveupfile($common->returnfile, $insertedid);
			}
			//$Description1 = $board->htmleditorImg($Description1, $htmleditimgfolder, $uid);
			
			## 현재 변경된 자료를 다시 한번 업데이트 시킨다.
			$sqlstr = "update $tb_name set CONTENTS = '$CONTENTS',SUB_CONTENTS1 = '$SUB_CONTENTS1',SUB_CONTENTS2 = '$SUB_CONTENTS2'
						where
						UID = $insertedid";
			$dbcon->_query($sqlstr);
			## 업로드 관련 후단 처리끝
			
			
			//토탈 보드에 자료 입력(총 검색을 위해)
			$sqlstr = "INSERT INTO wizTable_TotalSearch 
			(`CATEGORY`,`BID`,`GID`,`UID`,`SUBJECT`,`CONTENTS`,`WDATE`)
			VALUES('$CATEGORY','$BID','$GID','$insertedid','$SUBJECT','$CONTENTS', ".time().")";
			$dbcon->_query($sqlstr);
			
			
			//엮인글(트랙백)에 데이타 날리기
			include_once ("./lib/class.trackback.php");
			$tracback_wirte	= new tracbackcls();
			$tracback_wirte->cfg = $cfg;
			$url = $cfg["admin"]["MART_BASEDIR"]."/wizboard.php?GID=".$GID."&BID=".$BID."&UID=".$insertedid."&mode=view";
			$tracback_wirte->send_trackback($tb_url, $url, $SUBJECT, $NAME, $CONTENTS);
			
			#포인트 입력하기
			$board->point_fnc($ID, $BID, $GID, $insertedid, "write");	
			
	
			
			//어드민에게 공지 메일 날리기 
			if($cfg["board"]["MailToAdmin"] == "1"){
			 $SEND_CONTENT = "<a href=\"$MART_BASEDIR/wizboard.php?BID=$BID&GID=$GID&mode=view&UID=$UID&category=$CATEGORY\">$MART_BASEDIR/wizboard.php?BID=$BID&GID=$GID&category=$CATEGORY&mode=view&UID=$UID</a> <br> 작성자 : $NAME <br> <br> $CONTENTS ";
						$TO = $cfg["admin"]["ADMIN_EMAIL"];
						$from = "$NAME <$EMAIL>";
						$SUBJECT = "$NAME 님이 게시판에 글을 남겼습니다.";
						$SEND_CONTENT = "<IFRAME SRC='$MART_BASEDIR/wizboard.php?BID=$BID&GID=$GID&mode=view&UID=$UID' WIDTH=780 HEIGHT=700 FRAMEBORDER=0></IFRAME>";
						$from = "From:$from\nContent-Type:text/html";
						$result = mail($TO, $SUBJECT , $SEND_CONTENT , $from);
						if(!$result) echo "<script>window.alert('메일발송이 실패 하였습니다.');</script>";
						//echo "\$TO=$TO, \$SUBJECT = \$SUBJECT, \$from = $from <br>";
						//exit;
			}
			// 메일보내기 끝 
					$getdata = $common->getencode("BID=$BID&GID=$GID&adminmode=$adminmode&optionmode=$optionmode&category=$CATEGORY");
					$goto = "./wizboard.php?getdata=".$getdata;
					$str = "자료가 성공적으로 등록되었습니다";
					$common->js_alert($str, $goto);
			
		break;
		case "modify":
			// ADMIN 패스워드 가져오기 
			$ADMINPWD = $dbcon->get_one("SELECT Pass FROM wizTable_Main WHERE BID='".$BID."' and GID='".$GID."'");

			//현재 등록 파일 정보 가져오기
			$board->bid	= $BID;
			$board->gid	= $GID;
			$rtn_attached_file	= $board->get_attached_file($UID);
			
			//현재 수정하기 직적에 막기 때문에 이부분에 대한 프로그램 새로 할 것
			//글 작성자 패스워드 및 업로딩 파일 가져오기 
				$dbcon->_query("SELECT ID, PASSWD, UPDIR1 FROM $tb_name WHERE UID='$UID'");
				$LIST=$dbcon->_fetch_array();
			//	$UPDIRF = explode("|", $LIST[UPDIR1]); // 현재 업로딩 된 파일 가져오기 
				$LIST["PASSWD"]=trim($LIST["PASSWD"]);
				if($PASSWD && $PASSWD != $LIST["PASSWD"] && $PASSWD !=$ADMINPWD["Pass"]) { // 비회원 게시판으로 패스워드를 입력하는 폼이라면 입력된 패스워드를 상효 비교한다.
					$common->js_alert("글작성시 패스워드를 입력해주세요.");
				}else if (($_COOKIE["MODIFY"] != $UID."_".$BID."_".$GID) ){ //회원전용폼으로 패스워드 입력란이 없으면 보드관리자가 아니고 super관리자가 아니면
			//현재 로그인된 아이디와 글작성시 아이디를 비교하여 수정여부를 선택한다. 
					$common->js_alert("등록자본인만이 수정가능합니다.");
				}else{ //마지막 까지 update flow start 
				
					if($MultiFileValue){//다중파일 첨부로 넘어오는 경우
						$uploadedFile = explode("|", $MultiFileValue);
						foreach($uploadedFile as $key=>$value){
							if($value){
								@copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$GID."/".$BID."/updir/".$value);
								@unlink("./config/tmp_upload/".$value);
							}
						}
					}else if($multiupload == "uploadify"){
						//uploadify 를 이용해서 이미 파일이 서버에 올라가 있는 상태임
						//$rtn_attached_file	= array();
						//$newuploadedFile	= array();
						if(is_array($file_del)){
							foreach($file_del as $key=>$val){
								$uploaded_path	= "./config/wizboard/table/".$GID."/".$BID."/updir/".$UID;
								unlink($uploaded_path."/".$rtn_attached_file[$key]);
								//echo $uploaded_path."/".$rtn_attached_file[$key];
								$rtn_attached_file[$key] = "";
							}
						}
						
//print_r($rtn_attached_file);
						//새로이 배열을 정리한다.
						if(is_array($rtn_attached_file))
							asort($rtn_attached_file);
							foreach( $rtn_attached_file as $key => $val){
								if($val){
									$uploadedFile[]	= $val;
								}
						}
//print_r($rtn_new_array);
//exit;
						$uploadFilePath	= "./config/tmp_upload/".session_id()."/";
						$newuploadedFile	= $common->readFileList($uploadFilePath);
						if(is_array($newuploadedFile)){
							foreach($newuploadedFile as $key => $val){
								$cur_filename	= $newuploadedFile[$key];
								$uploadedFile[] = $newuploadedFile[$key] = base64_encode($cur_filename);
								rename($uploadFilePath.$cur_filename, $uploadFilePath.$newuploadedFile[$key]);
							}
						}
//print_r($uploadedFile);					
//exit;
						//$uploadedFile = array_merge($rtn_new_array, $newuploadedFile);
						//exit;
					}else{	
						// 파일 업로딩 시작 
						
						$common->upload_path		= "./config/wizboard/table/".$GID."/".$BID."/updir";
						$common->ProhibitExtention	= $cfg["wizboard"]["ProhibitExtention"];
						$common->uploadmode			= "update";
						$common->oldfilename		= implode("|", $rtn_attached_file);
						$common->delfile			= $file_del;
						//$option1 = $Filenamereserver;
						$common->uploadfile("file");
						$uploadedFile = $common->returnfile;
						//$UPDIR1 = "";
						//if(is_array($common->returnfile)) foreach($common->returnfile as $key=>$value) $UPDIR1 .= $value."|";
						// 파일 업로딩 끝 	
					}	
					// 파일 업로딩 끝 
			
			
					## 업로드 관련 후단 처리시작
					//현재 업로된 파일을 db에 저장한다.
					if(is_array($uploadedFile)){
						asort($uploadedFile);
						$sqlstr = "delete from wizTable_File where bid='$BID' and gid = '$GID' and pid=$UID ";
						$dbcon->_query($sqlstr);
						foreach($uploadedFile as $key=>$value){
							if($value){


								//현재 정보를 다 날리고 새로이 insert 한다.

								$sqlstr = "insert into wizTable_File (pid, bid, gid, seq,filename) values ($UID, '$BID', '$GID', $key, '$value')";
								$dbcon->_query($sqlstr);
							}
						}
					}
					
					//$현재 id를 이용해서 실제 upload 폴더 생성
					$CONTENTS = $board->chPathcontent($CONTENTS, $UID);
					$SUB_CONTENTS1 = $board->chPathcontent($SUB_CONTENTS1, $UID);
					$SUB_CONTENTS2 = $board->chPathcontent($SUB_CONTENTS2, $UID);
					
					$board->htmleditorImg($UID);//에디터 경로 변경
					
					## 현재 첨부된 파일 위치 변경
					$board->moveupfile($common->returnfile, $UID);
					## 업로드 관련 후단 처리끝
			
			
					// board DB에 처리된 값들을 INSERT 한다.
					$sqlstr = "UPDATE $tb_name SET CATEGORY='$CATEGORY',NAME='$NAME',EMAIL='$EMAIL',URL='$URL',SUBJECT='$SUBJECT',FLAG='$FLAG', SUB_TITLE1='$SUB_TITLE1',
					SUB_TITLE2='$SUB_TITLE2',CONTENTS='$CONTENTS',SUB_CONTENTS1='$SUB_CONTENTS1',SUB_CONTENTS2='$SUB_CONTENTS2',UPDIR1='".$uploadedFile[0]."',SPARE1='$SPARE1',SDATE='$SDATE'
					
					WHERE UID='$UID'";
					$dbcon->_query($sqlstr);
	
	
					//토탈 보드에 자료 UPDATE 
					$sqlstr = "UPDATE wizTable_TotalSearch SET
					`CATEGORY`='$CATEGORY',`SUBJECT`='$SUBJECT',`CONTENTS`='$CONTENTS' where UID='$UID' and BID='$BID' and GID='$GID'";
					$dbcon->_query($sqlstr);
			
					if($flag == "write_only") $tmode = "write";
					else $tmode = "";
					$getdata = $common->getencode("BID=$BID&GID=$GID&mode=$tmode&adminmode=$adminmode&optionmode=$optionmode&category=$CATEGORY&mode=view&UID=$UID&cp=$cp&BOARD_NO=$BOARD_NO");
					$common->js_location("./wizboard.php?getdata=".$getdata);
				}
		break;
		case "reply":
			if(substr($SUBJECT,0,4)=="Re: ") $SUBJECT=substr($SUBJECT,4);
			//echo "\$CONTENTS1 = $CONTENTS <br>";
			$CONTENTSOri = explode("[원본내용]", $CONTENTS);
			$CONTENTS = addslashes($CONTENTSOri[0]);
			$THREAD = "A";
			$COUNT = 1;
			$NEW_THREAD="A";
			
			$dbcon->_query("SELECT FID,THREAD,EMAIL,SPARE1 FROM $tb_name WHERE UID='$UID'");
			$LIST							= $dbcon->_fetch_array();
			$CURRENT_FID			= $LIST["FID"];
			$CURRENT_THREAD		= $LIST["THREAD"];
			$CURRENT_EMAIL		= $LIST["EMAIL"];
			
			if($CURRENT_FID == ""){//참조아이디가 없거나 삭제된경우
				$common->js_alert("존재하지 않는 게시물에 리플을 달수가 없습니다.");
			}		
	
			$LIST = $dbcon->get_one("SELECT right(THREAD,1) from $tb_name WHERE FID='$CURRENT_FID' and length('$CURRENT_THREAD')+1=length(THREAD) and locate('$CURRENT_THREAD',THREAD)=1 order by THREAD DESC limit 0,1");
			if($LIST) {
				$MORE_THREAD=$LIST[0];
				$FUTURE_THREAD=$CURRENT_THREAD.chr(ord($MORE_THREAD)+1);
			} else {
				$FUTURE_THREAD=$CURRENT_THREAD."A";
			}
			
					
			if($MultiFileValue){//다중파일 첨부로 넘어오는 경우(별도의 스킨 존재)
				//이경우 두가지 타입설정 : 1: 바로 첨부된 경우는 바로 타켓폴더에 저장,  임시적으로 tmp_upload 파일저장되는 경우 
				$uploadedFile = explode("|", $MultiFileValue);
				foreach($uploadedFile as $key=>$value){
					if($value){
						@copy("./config/tmp_upload/".$value, "./config/wizboard/table/".$GID."/".$BID."/updir/".$value);
						@unlink("./config/tmp_upload/".$value);
					}
				}
			}else{
				$common->upload_path = "./config/wizboard/table/".$GID."/".$BID."/updir";
				$common->ProhibitExtention = $cfg["wizboard"]["ProhibitExtention"];
				$common->uploadfile("file");//업로드 완료후 아래의 $common->returnfile 생성됨
				$uploadedFile = $common->returnfile;
			}
			
	
			$sqlstr = "INSERT INTO $tb_name 
			(CATEGORY,ID,NAME,PASSWD,EMAIL,URL,SUBJECT,SUB_TITLE1,SUB_TITLE2,CONTENTS,SUB_CONTENTS1,SUB_CONTENTS2,THREAD,FID,COUNT,RECCOUNT,DOWNCOUNT,UPDIR1,IP,SPARE1,SDATE,W_DATE) 
			VALUES
			('$CATEGORY','$ID','$NAME','$PASSWD','$EMAIL','$URL','$SUBJECT','$SUB_TITLE1','$SUB_TITLE2','$CONTENTS','$SUB_CONTENTS1','$SUB_CONTENTS2','$FUTURE_THREAD'
			,'$CURRENT_FID','$COUNT','$RECCOUNT','$DOWNCOUNT','".$uploadedFile[0]."','$IP','$SPARE1','$SDATE','$W_DATE')"; 
			
			$dbcon->_query($sqlstr);
			$insertedid = $dbcon->_insert_id();
			
			## 업로드 관련 후단 처리시작
			//현재 업로된 파일을 db에 저장한다.
			if(is_array($uploadedFile)){
				foreach($uploadedFile as $key=>$value){
					if($value){
						$sqlstr = "insert into wizTable_File (pid, bid, gid, seq,filename) values ($insertedid, '$BID', '$GID', $key, '$value')";
						$dbcon->_query($sqlstr);
					}
				}
			}			
			//$현재 id를 이용해서 실제 upload 폴더 생성
			$CONTENTS = $board->chPathcontent($CONTENTS, $insertedid);
			$SUB_CONTENTS1 = $board->chPathcontent($SUB_CONTENTS1, $insertedid);
			$SUB_CONTENTS2 = $board->chPathcontent($SUB_CONTENTS2, $insertedid);
			
			$board->htmleditorImg($insertedid);//에디터 경로 변경
			
			## 현재 첨부된 파일 위치 변경
			$board->moveupfile($common->returnfile, $insertedid);
	
			//$Description1 = $board->htmleditorImg($Description1, $htmleditimgfolder, $uid);
			
			## 현재 변경된 자료를 다시 한번 업데이트 시킨다.
			$sqlstr = "update $tb_name set CONTENTS = '$CONTENTS',SUB_CONTENTS1 = '$SUB_CONTENTS1',SUB_CONTENTS2 = '$SUB_CONTENTS2'
						where
						UID = $insertedid";
			$dbcon->_query($sqlstr);
			## 업로드 관련 후단 처리끝
					
		//토탈 보드에 자료 입력(총 검색을 위해) 
			$sqlstr = "INSERT INTO wizTable_TotalSearch 
			(`CATEGORY`,`BID`,`GID`,`UID`,`SUBJECT`,`CONTENTS`)
			VALUES('$CATEGORY','$BID','$GID','$insertedid','$SUBJECT','$CONTENTS')";
			$dbcon->_query($sqlstr);
			
			
			

			#포인트 입력하기
			$board->point_fnc($ID, $BID, $GID, $insertedid, "reply");
	
	
			//Mail_Receive = 1 이면 Writer_Email 메일을 보낸다.
			if($RepleMail == "1" && $CURRENT_EMAIL){
				 $SEND_CONTENT = "<a href=\"".$cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=$BID&GID=$GID&mode=view&UID=$UID&category=$CATEGORY&tableskin=skip\">".$cfg["admin"]["MART_BASEDIR"]."/wizboard.php?BID=$BID&GID=$GID&category=$CATEGORY&mode=view&UID=$UID</a> <br> 작성자 : $NAME <br> <br> $CONTENTS ";
				$TO			= $CURRENT_EMAIL;
				$from			= "$NAME <$EMAIL>";
				$SUBJECT	= "답변글이 도착하였습니다.";
				$from			= "From:$from\nContent-Type:text/html";
				$result		= mail($TO, $SUBJECT , $SEND_CONTENT , $from);
				if(!$result) $common->js_alert("메일발송이 실패 하였습니다.", "", "alert");
			}
	
			if($flag == "write_only") $tmode = "write";
			else $tmode = "";
			$getdata = $common->getencode("BID=$BID&GID=$GID&mode=$tmode&adminmode=$adminmode&optionmode=$optionmode&category=$CATEGORY&cp=${cp}");
			$common->js_location("./wizboard.php?getdata=".$getdata);
		break;
	}
