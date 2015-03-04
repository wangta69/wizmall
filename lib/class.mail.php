<?php
/*
 *  $Id: libmail.lib.php,v 1.3 2006/09/14 00:40:13 dydwlsl Exp $
 *
 *  Original script by Leo West - west_leo@yahoo.com
 *  Original URL: http://lwest.free.fr/doc/php/lib/Mail/
 *  Original Lastmod : Nov 2001
 *  Original Version : 1.3
 *
 *  Modified by Setec Astronomy - setec@freemail.it
 *  Modified URL : http://digilander.iol.it/setecastronomy/
 *  Modified Lastmod : Sep 2004
 *  Modified Version : 1.4.1
 *
 *  Credits
 *  Thanks to:
 *    Andrea - andreamarchetto [at] hotmail [dot] com for
 *     a small bugfix on line 342 (fopen rb windows/apache compatibility)
 *    Gian Leonardo Solazzi - iw2nke [at] yahoo [dot] it for
 *    a bugfix in To method.
 *    CodeIgniter 에서의 사용예제
 *		$this->load->library('Class_mail');//사용자 정의 함수 불러오기
 *
 *		## 메일스킨이 있을 경우 처리 시작
 *		$this->template_->define("MAINHTML", "mailform/mail_member_greeting.php");
 *		$this->template_->assign(array(
 *			"info"	=> $info
 *		));
 *		$body_msg = $this->template_->fetch('MAINHTML');
 *      ## 메일 스킨이 있을 경우 처리 끝
  *		$this->class_mail->charset = 'EUC-KR';//한국어
*       $this->class_mail->charset = "iso-2022-jp";//일본어로 메일 발송
 *		$this->class_mail->From ("메일어드래스", "발송자명");
*		$this->class_mail->ReplyTo ("메일어드래스", "발송자명");
 *		$this->class_mail->To ("수신자 메일 어드래스");
 *		$this->class_mail->Subject ("메일제목");
 *		$this->class_mail->Body ( "메일내용");
 *		$this->class_mail->Priority (3);


		
 *		$ret = $this->class_mail->Send();//메일 발송




 실제 inquire 폼에서의 예제(euc-kr로 변경후 날림)
 		$class_mail->From ($email, $common->conv_euckr($name));
		//$class_mail->To ("preclear@naver.com");
		//$class_mail->charset	= "UTF-8";
		$class_mail->To ("wangta69@naver.com");// info@phoenixdts.com , wangta69@naver.com
		$class_mail->Organization ("PHOENIX DTS");//
		$class_mail->Subject ($common->conv_euckr("온라인 상담"));
		$class_mail->Body ($common->conv_euckr($body_txt));
		$class_mail->Priority (3);
		$ret = $class_mail->Send();


 
 
 참조 : http://sir.co.kr/bbs/board.php?bo_table=tip_php&wr_id=348
 참조 : http://yodobashi.info/node/105
 
 */

class classMail
{
  var $sendtoex	= array();
  var $sendto		= array();
  var $acc			= array();
  var $abcc			= array();
  var $aattach		= array();
  var $fattach		= array();
  var $xheaders	= array();
  var $priorities		= array( '1 (Highest)', '2 (High)', '3 (Normal)', '4 (Low)', '5 (Lowest)' );
  var $content_type;
  var $charset;
  var $ctencoding;
  var $boundary;
  var $receipt = 0;
  var $lang;

  function classMail () { 

    $this->boundary= "--" . md5 (uniqid ("myboundary")); 

	//$this->charset = $charset ? $charset :"iso-2022-jp";
	$this->charset = $this->charset ? $this->charset :"EUC-KR";
	$this->content_type	= $this->content_type ? $this->content_type : "text/html";
	//$this->content_type = "multipart/alternative";//첨부있을 경우
	//$this->ctencoding = $this->ctencoding ? $this->ctencoding : "base64";
	$this->ctencoding = $this->ctencoding ? $this->ctencoding : "7bit";
	//if($content_type) $this->content_type = $content_type;
	//else $this->content_type = "text/html";
	//$this->content_type = "multipart/alternative";

	
	
	//일본어 메일 일경우 세팅예제
	//$this->ctencoding	= "7bit";
	////$this->charset			= "iso-2022-jp";
	////$this->content_type = "text/html";
	//$this->content_type_header	= "Multipart/Mixed";

	$this->content_type_header	= "Multipart/Mixed";
	//$this->content_type_header = "multipart/alternative";
	
  }

function Subject ($subject = "") { 
	if($this->charset == 'EUC-KR') {
		$this->xheaders['Subject'] = '=?euc-kr?B?'.base64_encode(strtr($subject, "\r\n" , "  ")).'?='; 
	}
	else if($this->charset == 'iso-2022-jp') {
		$this->xheaders['Subject'] = '=?iso-2022-jp?B?'.base64_encode(strtr($subject, "\r\n" , "  ")).'?='; 
	}
	else {
		$this->xheaders['Subject'] = '=?utf-8?B?'.base64_encode(strtr($subject, "\r\n" , "  ")).'?='; 
	}


	return true;
}

	function From ($from_email, $from_name = "") {
		if (!is_string ($from_email)) { 
			return false; 
		}

		$this->from_email = $from_email;//mail 함수에 추가적으로 제공(localhost로 나가는 것을 방지하기 위해);

		if (empty ($from_name)) { 
			$this->xheaders['From'] = $from_email; 
		} else { 

			if($this->charset == 'EUC-KR') {
				$from_name = '=?euc-kr?B?'.base64_encode(strtr($from_name, "\r\n" , "  ")).'?='; 
			}else if($this->charset == 'iso-2022-jp') {
				$from_name = '=?iso-2022-jp?B?'.base64_encode(strtr($from_name, "\r\n" , "  ")).'?='; 
			}else {
					$from_name = '=?utf-8?B?'.base64_encode(strtr($from_name, "\r\n" , "  ")).'?='; 
			}

			$this->xheaders['From'] = $from_name."<".$from_email.">"; 
		}

		return true;
	}

	function ReplyTo ($replyto_email, $replyto_name = "") {
		if (!is_string ($replyto_email)) { 
			//return false; 
			$replyto_email = $this->from_email;
		}

		if (empty ($replyto_name)) { 
			$this->xheaders['Reply-To'] = $replyto_email; 
		} else { 


			if($this->charset == 'EUC-KR') {
			  $replyto_name = '=?euc-kr?B?'.base64_encode(strtr($replyto_name, "\r\n" , "  ")).'?='; 
			}
			else if($this->charset == 'iso-2022-jp') {
			  $replyto_name = '=?iso-2022-jp?B?'.base64_encode(strtr($replyto_name, "\r\n" , "  ")).'?='; 
			}
			else {
			  $replyto_name = '=?utf-8?B?'.base64_encode(strtr($replyto_name, "\r\n" , "  ")).'?='; 
			}



			$this->xheaders['Reply-To'] = $replyto_name."<".$replyto_email.">"; 
		}

		return true;
	}

	//리턴 이메일 설정
  function ReturnPath ($returnpath_email, $returnpath_name = "") { 
    if (!is_string ($returnpath_email)) { 
      return false; 
    }

    if (empty ($returnpath_email)) { 
      $this->xheaders['Return-Path'] = $returnpath_email; 
    } else { 
      $this->xheaders['Return-Path'] = "\"$returnpath_name\" <$returnpath_email>"; 
    }

    return true;
  }


 
  function Receipt () { 
    $this->receipt = 1; 
    return true;
  }
  
	function To ($address) {

		$this->sendto		= array ();
		$this->sendtoex	= array ();
		if (is_array ($address)) { 
			foreach ($address as $key => $value) {
				if (is_numeric ($key)) { 
					$this->sendto[] = $value; 
					$this->sendtoex[] = $value; 
				} elseif (is_string ($key) && is_string ($value)) { 
					$value = trim (str_replace('"', '', $value));
					$this->sendto[] = $key; 
					$this->sendtoex[] = "\"".$value."\" <".$key.">"; 
				}
			}
		} else { 
			$this->sendto[] = $address; 
			$this->sendtoex[] = $address; 
		}
		return true;
	}

  function Cc ($address) {
    if (is_array ($address)) { 
      $this->acc = array ();
      foreach ($address as $key => $value) {
        if (is_numeric ($key)) { 
          $this->acc[] = $value; 
        } elseif (is_string ($key) && is_string ($value)) { 
          $value = str_replace('"', '', $value);
          $this->acc[] = "\"$value\" <$key>"; 
        }
      }
    } else  { 
      $this->acc = array ($address); 
    }
    return true;
  }

  function Bcc ($address) {
    if (is_array ($address)) { 
      $this->abcc = array ();
      foreach ($address as $key => $value) {
        if (is_numeric ($key)) { 
          $this->abcc[] = $value; 
        } elseif (is_string ($key) && is_string ($value)) { 
          $value = str_replace('"', '', $value);
          $this->abcc[] = "\"$value\" <$key>"; 
        }
      }
    } else { 
      $this->abcc = array ($address); 
    }
    return true;
  }

	function Body ($body = "") {  
		if($this->ctencoding == "7bit"){
			
			switch($this->charset){
				case "iso-2022-jp":
					$this->body = $this->conv_sjis($body);
				break;
				default:
					$this->body = $body;
				break;

			}
			
		}else{
			switch($this->charset){
				case "iso-2022-jp":
					$this->body = $this->conv_sjis($body);
				break;
				default:
					$this->body = chunk_split(base64_encode($body));
				break;
			}
			
		}
		return true;
  }

  function Organization ($org = "") {
    if (!empty ($org)) { 
      $this->xheaders['Organization'] = $org; 
    }
    return true;
  }

  function AntiSpaming ($client_ip = "", $proxy_server = "", $user_agent = "") {
    if (empty ($client_ip)) { 
      if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']))
      { $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
      elseif (isset ($_SERVER['HTTP_CLIENT_IP']))
      { $client_ip = $_SERVER['HTTP_CLIENT_IP']; }
      elseif (isset ($_SERVER['HTTP_FROM ']))
      { $client_ip = $_SERVER['HTTP_FROM']; }
      elseif (isset ($_SERVER['REMOTE_ADDR']))
      { $client_ip = $_SERVER['REMOTE_ADDR']; }
      $this->xheaders['X-HTTP-Posting-Host'] = $client_ip; 
    } else { 
      $this->xheaders['X-HTTP-Posting-Host'] = $client_ip; 
    }

    if (empty ($proxy_server)) { 
      if ($client_ip != $_SERVER['REMOTE_ADDR'])
      { $this->xheaders['X-HTTP-Proxy-Server'] = $_SERVER['REMOTE_ADDR']; } 
    } else { 
      $this->xheaders['X-HTTP-Proxy-Server'] = $proxy_server; 
    }

    if (empty ($user_agent)) { 
      if (isset ($_SERVER['HTTP_USER_AGENT'])) { 
        $this->xheaders['X-HTTP-Posting-UserAgent'] = $_SERVER['HTTP_USER_AGENT']; 
      } else { 
        $this->xheaders['X-HTTP-Posting-UserAgent'] = "Unknown"; 
      }
    } else { 
      $this->xheaders['X-HTTP-Posting-UserAgent'] = $user_agent; 
    }

    return true;
  }
  
  function Priority ($priority = 3) {
    if (!isset ($this->priorities[$priority-1])) { 
      return false; 
    }

    $this->xheaders["X-Priority"] = $this->priorities[$priority-1]; 
    return true; 
  }
  
  function Attach ($filepath, $mimetype = "", $disposition = "inline", $filename = "") {
    if (empty ($filepath)) { 
      return false; 
    }
    
    if (empty ($mimetype)) { 
      $mimetype = "application/x-unknown-content-type"; 
    }
    
    if (empty ($filename)) { 
      $filename = basename ($filepath); 
    }
    
    $this->fattach[] = $filename;
    $this->aattach[] = $filepath;
    $this->actype[] = $mimetype;
    $this->adispo[] = $disposition;

    return true;
  }

  function BuildMail () {
    $this->headers = "";
    
    if (count ($this->sendtoex) > 0) { 
      $this->xheaders['To'] = implode (", ", $this->sendtoex); 
	  unset($this->sendtoex);
    }

    if (count ($this->acc) > 0) { 
      $this->xheaders['CC'] = implode (", ", $this->acc); 
	  unset($this->acc);
    }
    
    if (count ($this->abcc) > 0) { 
      $this->xheaders['BCC'] = implode ( ", ", $this->abcc); 
	  unset($this->abcc);
    }
      
    if ($this->receipt) {
      if (isset ($this->xheaders["Reply-To"])) { 
        $this->xheaders["Disposition-Notification-To"] = $this->xheaders["Reply-To"]; 
      } else { 
        $this->xheaders["Disposition-Notification-To"] = $this->xheaders['From']; 
      }
    }
    
	$this->xheaders["Mime-Version"] = "1.0";
	//$this->xheaders["Content-Type"] = $this->content_type_header."; boundary=\"".$this->boundary."\"";//첨부화일 있을 경우
	$this->xheaders["Content-Type"] = $this->content_type."; charset=".$this->charset;
	$this->xheaders["Content-Transfer-Encoding"] = $this->ctencoding;
	
   $this->xheaders["X-Mailer"] = "PHP/" . phpversion();
    if (count ($this->aattach ) > 0) { 
      $this->_build_attachement (); 
    } else { 
	  //$this->fullBody = "This is a multi-part message in MIME format\n\n"; //첨부화일 있을 경우
	 // $this->fullBody .= "--".$this->boundary."\n";//첨부화일 있을 경우
	  $this->fullBody .= $this->body."\n";
    }
  
	reset ($this->xheaders);
//print_r($this->xheaders);
    while (list ($hdr, $value) = each ($this->xheaders)) {
		if($this->UseSMTPServer == true){
			$this->headers .= $hdr.": ".$value."\n"; 
		}else if($hdr != "Subject" ) { //소켓방식이 아니면 subject를 뺀 해더 
				$this->headers .= $hdr.": ".$value."\n"; 
		}
    }

    return true;
  }

  //실지적으로 메일보내기
	function Send() {
		// exit;
		$this->BuildMail();
		$strTo = implode (", ", $this->sendto);

		if($this->debug){
			echo "=======================================================<br />";
			echo "To:".$strTo."<br />";
			echo "Subject:".$this->xheaders['Subject']."<br />";
			echo "Body:".$this->fullBody."<br />";
			echo "headers:".$this->headers."<br />";
			echo "=======================================================<br />";
			//exit;
		}



        if($this->UseSMTPServer) return $this->_SMTPSend($strTo);        // 외부 SMTP 서버를 이용할 경우
        else return $this->_LocalSend($strTo);                        // 로컬 SMTP 를 이용할 경우


	}

	//SMTP(소켓으로 메일 보내기);
	function _SMTPSend($strTo){
        /*
         * 외부 SMTP 서버를 이용할 경우 소켓접속을 통해서 메일을 전송한다
         */
        $Succ = 0;
        
        if($this->SMTPServer) {
					$Contents = $this->headers."\r\n" . $this->fullBody;
                    $this->Socket = fsockopen($this->SMTPServer, $this->SMTPPort);            // 소켓접속한다
                    if($this->Socket) {
                        $this->_sockPut('HELO ' . $this->SMTPServer);
                        if($this->SMTPAuthUser) {                                // SMTP 인증
                            $this->_sockPut('AUTH LOGIN');
                            $this->_sockPut(base64_encode($this->SMTPAuthUser));
                            $this->_sockPut(base64_encode($this->SMTPAuthPasswd));
                        }
						//echo "MAIL From:" . $this->xheaders['From'];
                        $this->_sockPut('MAIL From:' . $this->xheaders['From']);            // 보내는 메일
                        $this->_sockPut('RCPT To:' . $strTo);                    // 받는메일
                        $this->_sockPut('DATA');
                        $this->_sockPut($Contents);                                // 메일내용
                        $Result = $this->_sockPut('.');                            // 전송완료
                        if(strpos($Result, 'Message accepted for delivery') !== false) $Succ++;        // 성공여부판단
                        $this->_sockPut('QUIT');                // 접속종료
                    }
        } else $result = $this->_LocalSend();            // 외부 SMTP 서버를 이용하지 않으면 로컬 SMTP를 이용해서 전송한다
        
        return $result;
	}


    protected function _sockPut($str)
    {
        // 소켓접속시 내용전송 및 결과값 받기
        @fputs($this->Socket, $str . "\r\n");
        return @fgets($this->Socket, 512);
    }

	
	//기본 메일함수를 이용해서 메일 보내기
	function _LocalSend($strTo){
		


		if($this->charset == "iso-2022-jp"){
			//mb_language("Ja"); 
			//mb_internal_encoding("SJIS");
		}

		//ini_set("SMTP","shop-wiz.com");//수동으로 메일 서버를 처리할 경우
		//ini_set("sendmail_from",$this->from_email);


		return mail ($strTo, $this->xheaders['Subject'], $this->fullBody, $this->headers);
	}



  
  function Get() {
    $this->BuildMail();
    $mail = $this->headers . "\n";
    $mail .= $this->fullBody;
    return $mail;
  }
  
  function _build_attachement () {
	  /*
	  //일본어가 들어간 송신자이름, 수신자이름, 제목, 파일명은 반드시 iso-2022-jp코드로 64B인코딩해야합니다. 
    $this->xheaders["Content-Type"] = "multipart/mixed;\n boundary=\"$this->boundary\"";
	//$this->xheaders["Content-Type"] = "multipart/alternative;\n boundary=\"$this->boundary\"";

    $this->fullBody = "This is a multi-part message in MIME format.\n--$this->boundary\n";
    $this->fullBody .= "Content-Type: $this->content_type; charset=$this->charset\nContent-Transfer-Encoding: $this->ctencoding\n\n" . $this->body ."\n";
    //$this->fullBody .= "Content-Type:".$this->content_type;
    $sep = chr(13) . chr(10);
    
    $ata = array();
    $k = 0;

    for ($i = 0; $i < count( $this->aattach); $i++) {
      $filename = $this->aattach[$i];
      $basename = basename($this->fattach[$i]);
      $ctype = $this->actype[$i];  // content-type
      $disposition = $this->adispo[$i];
      
      if (!file_exists ($filename)) { 
        return false; 
      }
      
      $subhdr = "--$this->boundary\nContent-type: $ctype;\n name=\"$basename\"\nContent-Transfer-Encoding: ".$this->ctencoding."\nContent-Disposition: $disposition;\n  filename=\"$basename\"\n";
      $ata[$k++] = $subhdr;

      $linesz = filesize ($filename) + 1;
      $fp = fopen ($filename, 'rb');
      $ata[$k++] = chunk_split (base64_encode (fread ($fp, $linesz)));
      fclose ($fp);
    }
    $this->fullBody .= implode ($sep, $ata);

	*/
  }

	//일본어로 변경시 참조  url : http://www.shop-wiz.com/board/main/view/root/php3/111/0/1
	function conv_euckr($str){
		if(iconv("EUC-KR","EUC-KR",$str) == $str){
			return $str;
		}else return iconv("UTF-8","EUC-KR",$str);

	}

	function conv_utf8($str){
		if(iconv("UTF-8","UTF-8",$str) == $str){
			return $str;
		}else return  iconv("EUC-KR","UTF-8",$str);
	}

	function conv_jis_subject($str){
		$str	= mb_convert_encoding($str, "SJIS", "UTF-8");
		return $str;
	}

	function conv_sjis($str){
		$str	= mb_convert_encoding($str, "SJIS", "UTF-8");
		return $str;
	}

		function conv_jis($str){
		$str	= mb_convert_encoding($str, "JIS", "UTF-8");
		return $str;
	}


	function mail_encoding($str){
		//echo $this->charset;
		switch($this->charset){
			case "EUC-KR":
				$str = $this->conv_euckr($str);
			break;
			case "iso-2022-jp":
				$str = $this->conv_jis($str);
			break;

		}
		return $str;
	}

	function mail_subject_encoding($str){
		//echo $this->charset;
		switch($this->charset){
			case "EUC-KR":
				$str = $this->conv_euckr($str);
			break;
			case "iso-2022-jp":
				$str = $this->conv_jis_subject($str);
			break;

		}

		return $str;
	}

} // class Mail