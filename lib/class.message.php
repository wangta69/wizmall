<?php
class MessageClass{
	var $contentlist = array();
	var $dbcon;//db connect ��� �ܺ� Ŭ�� �ޱ�
	var $cfg;//�ܺ� $cfg ��� �迭
## ���� Ŭ�� �Լ� ȣ���
	function get_object(&$dbcon=null, &$common=null){//
		if($dbcon) $this->dbcon	= $dbcon;
		if($common) $this->common	= $common;
	}
####################################################################################
#### ���ǰ�� ��� �� ���� ��
####################################################################################
	function makeMessageDir($userid){

		$rootFolder = $_SERVER["DOCUMENT_ROOT"]."/config/message";
		$strlen = strlen($userid);
		$this->MessageFolder = $rootFolder;
		for($i=0; $i<$strlen; $i++){
			##�ѱ��϶��� ������غ���
			if(ord( substr($userid, $i, 1) ) >= 128){
				$this->MessageFolder .= "/".substr($userid, $i, 2);
				$i++;
			}else{
				$this->MessageFolder .= "/".substr($userid, $i, 1);
			}
			if(!file_exists($this->MessageFolder)){
				mkdir($this->MessageFolder);
			}
		}

	}
	
	function getMessageList($userid=null, $listcnt=30, $cp=1){
		##send : 0: �޽���Ÿ�� 1:�޽�������, 2:�޴¾��̵�, 3:�޴��̸�, 4:����, 5:ī��no, 6:������¥,  7:���ſ���, 8:����flag, 9:microtime
		##receive : 0:�޽�������, 1:�޽�������, 2:�������̵�, 3:�����̸�, 4:����, 5:ī��no, 6:���ų�¥, 7:���ſ���, 8:����flag, 9:microtime
		# �޽���Ÿ�� : r : ����, s : �߽�
		# �޽������� : 0 : �Ϲ�, 1 :ī��
		unset($contentlist);
		$contentlist = array();

		if($userid) $this->makeMessageDir($userid);
		$this->filemake($this->MessageFolder."/messagelist.php");
		$file = file($this->MessageFolder."/messagelist.php");
		$cnt=0;

		foreach($file as $line){
			if(trim($line)){

				$splitline = unserialize($line);
				foreach($splitline as $key=>$value){
					$contentlist[$cnt][$key] = trim($value);
				}
				$cnt++;	
			}
		}
		$this->contentlist = $contentlist;
		$this->newcnt = $newcnt;
	}
	
	//�÷��׺� �޽��� ����Ʈ�� �����´�.
	function getMessageFlagList($userid, $flag, $listcnt=30, $cp=1){//flag �� �޽����� ������
		## flag : s : ����������, r : ���� ������, f : ����������
		## �ߺ����� ������ ��� r+rf

		## �˻�����߰�
		## $this->s_field : ��Ī �ʵ� ��Ī �ʵ�� (0, 1, 2... ó�� �ѱ�� ������ ��� , �� �����Ͽ� �ѱ��.) , 2:�ۼ����� ���̵�, 3:�ۼ����ڸ�, 4:����, 10: ���� 2,3 (�����) �ۼ��������̵�or �۽��ڸ�
		## $this->s_word : ��Ī ����
		$this->getMessageList($userid);//return $this->contentlist 
		$cnt=0;

		$this->s_word = trim($this->s_word);
		$this->s_field	= trim($this->s_field);

		foreach($this->contentlist as $key=>$value){
			if($flag == "f"){
				if($value[0] == "sf" || $value[0] == "rf"){
					
					##�󼼳��뵵 ��������
					$messagefolder = substr($value[0],0, 1) == "s" ? "sendlist" : "receivelist";
					$cont_dir = $this->MessageFolder."/$messagefolder/".$value[9].".php";
					//if(file_exists($cont_dir)) array_push($value,  file_get_contents($cont_dir));//���� �迭�� ���� �������� �߰�
					if(file_exists($cont_dir)) $value[4] = file_get_contents($cont_dir);

					$returnlist[$cnt] = $value;
					$cnt++;
				}
			}else{
				$flagarr = explode("+", $flag);
				if(in_array($value[0], $flagarr)){

					##�󼼳��뵵 ��������
					$messagefolder = substr($value[0],0, 1) == "s" ? "sendlist" : "receivelist";
					$cont_dir = $this->MessageFolder."/$messagefolder/".$value[9].".php";
					//if(file_exists($cont_dir)) array_push($value,  file_get_contents($cont_dir));//���� �迭�� ���� �������� �߰�
					if(file_exists($cont_dir)) $value[4] = file_get_contents($cont_dir);
			
					if($this->s_word){//�˻�� ������
						//echo $this->s_word;
						$this->s_field	= $this->s_field ? $this->s_field:"2,3";
						$field = explode(",", $this->s_field);
						unset($is_val);
						foreach($field as $key1 => $val1){
							$is_val[$val1] = strpos($value[$val1], $this->s_word);
						}
						
						foreach($is_val as $key1 => $val1){
							if($val1 !== false){ 
								$returnlist[$cnt] = $value;
								$cnt++;
							}
						}
					}else{
						$returnlist[$cnt] = $value;
						$cnt++;
					}
				}
			}
		}
		return $returnlist;
	}	
	
	function getMessage($userid, $wdate){//Ư�� �޽��� ��������
		## flag : s : ����������, r : ���� ������, f : ����������
		$this->getMessageList($userid);//return $this->contentlist 

		$cnt=0;
		foreach($this->contentlist as $key=>$value){
			if($value[9] == $wdate){
				##�󼼳��뵵 ��������
				$messagefolder = substr($value[0],0, 1) == "s" ? "sendlist" : "receivelist";
				$cont_dir = $this->MessageFolder."/$messagefolder/".$value[9].".php";
				//if(file_exists($cont_dir)) array_push($value,  file_get_contents($cont_dir));//���� �迭�� ���� �������� �߰�
				if(file_exists($cont_dir)) $value[4] = file_get_contents($cont_dir);

				$returnlist = $value;
			}
		}
		return $returnlist;
	}	
## ���ο� ������ ���ϱ�
	function getnewMessageCnt($userid){
		##send : 0: �޽���Ÿ�� 1:�޽�������, 2:�޴¾��̵�, 3:�޴��̸�, 4:����, 5:ī��no, 6:������¥,  7:���ſ���, 8:����flag, 9:microtime, 10:subject
		##receive : 0:�޽�������, 1:�޽�������, 2:�������̵�, 3:�����̸�, 4:����, 5:ī��no, 6:���ų�¥, 7:���ſ���, 8:����flag, 9:microtime, 10:subject
		# �޽���Ÿ�� : r : ����, s : �߽�
		# �޽������� : 0 : �Ϲ�, 1 :ī��
		unset($contentlist);
		$contentlist = array();
		$this->makeMessageDir($userid);//�޽��� ��� ��θ� ���� $this->MessageFolder
		$this->filemake($this->MessageFolder."/messagelist.php");//������ �������� ������ ���� ��
		$file		= file($this->MessageFolder."/messagelist.php");
		$cnt		=0;
		$newcnt	= 0; //�������� �޽��� ������ ���Ѵ�.
		foreach($file as $line){
			if(trim($line)){
				//$splitline = explode(":sp:", $line);
				$splitline = unserialize($line);
				if($splitline[7] == "0" && substr($splitline[0], 0, 1) == "r") $newcnt++;
				$cnt++;	
			}
		}
		return $newcnt;
	}
	
## �޽��� ����Ʈ�� �׸� �߰�
	function addMessageList($type){
		##send : 0: �޽���Ÿ�� 1:�޽�������, 2:�޴¾��̵�, 3:�޴��̸�, 4:����, 5:ī��no, 6:������¥,  7:���ſ���, 8:����flag, 9:microtime, 10:subject
		##receive : 0:�޽�������, 1:�޽�������, 2:�������̵�, 3:�����̸�, 4:����, 5:ī��no, 6:���ų�¥, 7:���ſ���, 8:����flag, 9:microtime, 10:subject

		##11, 12 ����� ����(���̺��� ���̺� ������
		# �޽���Ÿ��($type) : r : ����(receive), s : �߽�(send)

		# �޽������� : 0 : �Ϲ�, 1 :ī��
		//$messageflag = $this->card_no ? 1:0;
		$messageflag		= $this->messageflag;
		$userid				= $type == "r" ? $this->senderid : $this->receiverid;
		$username = $type == "r" ? $this->sendername : $this->receivername;
		$addlist = array(
			0		=> $type,
			1		=> $messageflag,
			2		=> $userid,
			3		=> $username,
			4		=> "",//������ �׸����� ���Ϸ� ��ü but  ������ ������ ���� ����� �̰��� ������� ���ܵд�.
			5		=> $this->card_no,
			6		=> time(),
			7		=> 0,
			8		=> "",
			9		=> $this->savetime,
			10		=>	$this->subject,
			11		=>	$this->tbl_name,
			12		=>	$this->tbl_uid,
			13		=>	$this->parent_uid,
			
		);

		//if($type == "s"){//�߼�
		//	$addlist[14] = "";
		//}else{//����
		//	$addlist[13] = $this->parent_uid;
		//}


		array_unshift ($this->contentlist, $addlist);
		
		reset($this->contentlist);

		$str = "";
		$fp = fopen($this->MessageFolder."/messagelist.php", "w");		
		foreach($this->contentlist as $key => $value){
			if($this->parent_uid && $type=="s"){//�θ���� �ְ� �߽��� ���
				//## ����ۿ� child ������ ���Ѵ�.
				if($value["9"] == $this->parent_uid){
					$value["14"] = $this->savetime;
				}
			}
			$str .= serialize($value)."\n";
		}
		fwrite($fp,$str);
		fclose($fp);
	}	
	
	function saveMessage(){
		$receiveridArr = explode(",", $this->receiver);

		foreach($receiveridArr as $receiverid){
			$MicroTsmp = explode(" ",microtime());
			$this->savetime = $MicroTsmp[1].str_replace(".", "", $MicroTsmp[0]);		
			$this->receiverid = $receiverid = trim($receiverid);//
			if(trim($receiverid)){
				

				//�������� ����					
				$this->makeMessageDir($receiverid);
				//echo "MessageFolder=".$this->MessageFolder."<br>";
				$this->getMessageList();
				$this->addMessageList('r');
				//echo $receiverid;
				//echo "MessageFolder=".$this->MessageFolder."<br>";
				if(!file_exists($this->MessageFolder."/receivelist")){
					mkdir($this->MessageFolder."/receivelist");
				}		
				$fp = fopen($this->MessageFolder."/receivelist/".$this->savetime.".php", "w");
				fwrite($fp,$this->memo);
				fclose($fp);
				
				if($this->SendBoxSave == "1"){
					//�������� ����
					$this->makeMessageDir($this->senderid);
					$this->getMessageList();
					$this->addMessageList('s');
					//echo $this->MessageFolder;
					
					if(!file_exists($this->MessageFolder."/sendlist")){
						mkdir($this->MessageFolder."/sendlist");
					}

					$fp = fopen($this->MessageFolder."/sendlist/".$this->savetime.".php", "w");
					fwrite($fp,$this->memo);
					fclose($fp);
				}
			}
		}
	}
	//���ο��� �޽��� ������
	function AdminSendMsg($mgrade, $ToUser="", $content){
		//���� �������϶�
		if($mgrade =="11"){//�������Ϻ�����
			$this->receiver = $ToUser;
			$this->senderid = "xman7";
			$this->sendername = "������";
			$this->memo = $content;
			$this->SendBoxSave = "1"; //������������
			$this->saveMessage();
		}else{//��ü������
		
			if($mgrade =="0"){
				$sqlstr = "select userid, namekr from MemberInfo order by regdate desc";
			}else if($mgrade =="15"){//������ �׽�Ʈ��
				$sqlstr = "select userid, namekr from MemberInfo where userid='winkzone' or userid='winkzonep' order by regdate desc";
			}else{
				$sqlstr = "select userid, namekr from MemberInfo where mgrade='$mgrade' order by regdate desc";
			}
			$qrystr = mysql_query($sqlstr, $this->dbcon);
			$cnt=1;
			echo $sqlstr;
			##����κ� ����
			$this->senderid = "xman7";
			$this->sendername = "������";
			$this->memo = $content;
			$this->SendBoxSave = "0"; //������������			
			while($mylist = mysql_fetch_array($qrystr)):
				$this->receiverid = $receiverid = $mylist["userid"];
				$this->receivername = $mylist["namekr"];					
				//�������� ����
				$this->makeMessageDir($receiverid);
				$this->getMessageList();
				$this->addMessageList('r');
				if(!file_exists($this->MessageFolder."/receivelist")){
					mkdir($this->MessageFolder."/receivelist");
				}		
				$fp = fopen($this->MessageFolder."/receivelist/".$this->savetime.".php", "w");
				fwrite($fp,$this->memo);
				fclose($fp);
			if($cnt % 1000 =="0"){	
				sleep(1);
			}
			$cnt++;
			endwhile;
		}
		## ���� ���� ���� (1ȸ�� ����);
		switch($mgrade){
			case "0":
				$mgradestr = "��ü";
			break;
			case "9":
				$mgradestr = "�л�";
			break;
			case "7":
				$mgradestr = "�кθ�";
			break;
			case "5":
				$mgradestr = "����";
			break;
			case "15":
				$mgradestr = "������ �׽�Ʈ��";
			break;					
			default:
				$mgradestr = "NONE";
			break;								
		}
		$this->receiverid = $this->receivername = $mgradestr;
		$this->makeMessageDir($this->senderid);
		$this->getMessageList();
		$this->addMessageList('s');			
		if(!file_exists($this->MessageFolder."/sendlist")){
			mkdir($this->MessageFolder."/sendlist");
		}

		$fp = fopen($this->MessageFolder."/sendlist/".$this->savetime.".php", "w");
		fwrite($fp,$this->memo);
		fclose($fp);
		
	}
	//�������� ���Ż��� �� �̸��� ���ؿ´�.
	function getReciverinfo($receiverid){
		$this->db_connect();
		unset($this->rejectflag);
		unset($this->receivername);
		//���� �ź� ���� ���� Ȯ���Ѵ�.
		$sqlstr = "select count(1) From MessageRejectList where userid='".$this->senderid."' and rejectid='$receiverid'";
		$sqlqry = mysql_query($sqlstr) or dberror($sqlstr); 
		$list = mysql_fetch_array($sqlqry);
		if($list[0]){
			$this->rejectflag = false;
		}else{
			$sqlstr = "select namekr from MemberInfo where userid='$receiverid'";
			$sqlqry = mysql_query($sqlstr) or dberror($sqlstr); 
			$list = mysql_fetch_array($sqlqry);
			$this->receivername = $list["namekr"];
			$this->rejectflag = true;		
			
		}
	}
	
	
## �޽��� ����
	function delMsg($userid, $wdate, $type){
		##	messagelist �� ����Ʈ ����		
		$this->getMessageList($userid);//return $this->contentlist
		
		//print_r($this->contentlist);
		foreach($this->contentlist as $key => $value){
			if($value[9] <> $wdate){
				$str .= serialize($value)."\n";
			}
		}

		$fp = fopen($this->MessageFolder."/messagelist.php", "w");	
		fwrite($fp,$str);
		fclose($fp);
		## �޽��� ���� ����
		$type = substr($type, 0, 1);
		if($type == "s"){
			@unlink($this->MessageFolder."/sendlist/".$wdate.".php");
		}else if($type == "r"){
			@unlink($this->MessageFolder."/receivelist/".$wdate.".php");
		}
		//echo $userid.", ".$wdate.", ".$type;
		//exit;
	}
		
## �������������� �޽��� �̵�
	function saveMsg($userid, $wdate){
		##	messagelist �� ����Ʈ ����		
		$this->getMessageList($userid);//return $this->contentlist
		foreach($this->contentlist as $key => $value){
			if($value[9] == "$wdate"){
				$value[0] = substr($value[0], 0, 1)."f";
			}
			$str .= serialize($value)."\n";
		}
		$fp = fopen($this->MessageFolder."/messagelist.php", "w");	
		fwrite($fp,$str);
		fclose($fp);
	}
	
## �޽��� ���� ���·� ����
	function readcheckMsg($userid, $wdate){
		$this->getMessageList($userid);//return $this->contentlist
## ���翡 ���Ե� ���� �����´�.
		foreach($this->contentlist as $key => $value){
			if($value[9] == "$wdate"){
				$returnvalue = $value;
				if($value[7] == "1") $this->refleshflag = "0";//������ ���� ��� opener reload disable �ϰ� ����
				$value[7] = 1;
				
			}
			$str .= serialize($value)."\n";
		}
		$fp = fopen($this->MessageFolder."/messagelist.php", "w");	
		fwrite($fp,$str);
		fclose($fp);
		//echo $str."<br>".
		
##����� ���̵� ���Ͽ� ���� ������ ������� ������Ʈ ��Ų��.		
		//echo $returnvalue;
		$remoteid = $returnvalue[2];
		$remoteunique = $returnvalue[9];
		$this->getMessageList($remoteid);

		$str = "";
		foreach($this->contentlist as $key => $value){
			if($value[9] == "$remoteunique"){
				$returnvalue = $value;
				$value[7] = 1;
			}

			$str .= serialize($value)."\n";
		}
		$fp = fopen($this->MessageFolder."/messagelist.php", "w");	
		fwrite($fp,$str);
		fclose($fp);	

##������·� �ڷḦ �����д�.		
	$this->getMessageList($userid);//return $this->contentlist	
	}
	
			
	function filemake($file){
		//echo "file:$file <br>";
		if(!is_file($file)){
			touch($file);
		}
	}
	
	//���� �ź� �����ϱ�
	function MsgReject($ck_userid, $rejectid){ //
		//���� �źλ��� ���� Ȯ���Ѵ�.
		$sqlstr  = "select count(1) from MessageRejectList where userid='$ck_userid' and rejectid='$rejectid'";
		$qrystr  = mysql_query($sqlstr, $this->dbcon) or die(mysql_error());
		$total  = @mysql_result($qrystr, 0,0);

		if($total > 0){
			echo "<script>
				//alert('$rejectid ���� �̹� ���� �ź� ���� �Դϴ�.');
				location.href='./Message.php?pg=ReceiveBoxList';
			   </script>";
			exit;
		}else{
			$regday = mktime();
			$insert = "insert into MessageRejectList(userid, rejectid, regday)";//mstatus, ����
			$insert .=" values('$ck_userid', '$rejectid', '$regday')";		
			mysql_query($insert , $this->dbcon) or die(mysql_error());
			echo "<script>location.href='./Message.php?pg=MessageSet';</script>";
			exit;
		}
	}
	
	//�������� ����
	function MsgRejectOff($userid, $seq){
		$delete ="delete from MessageRejectList where userid='$userid' and seq='$seq'";
		//echo $delete;
		//exit;
		mysql_query($delete);
		echo "<script>location.href='./Message.php?pg=MessageSet';</script>";
		exit;		
	}	
	
	
	
	
	###################################################################################################
	
	function transdbtofile($pkey, $m_status, $m_flag, $card_no, $from_userid, $from_name, $from_time, $title, $contents, $to_userid, $to_name, $to_time, $save, $save1, $del_flag){//���� db�� ���Ϸ� ��ȯ�ϴ� �Լ�
		$this->savetime = $pkey;
		$this->memo = stripslashes($contents);
		$this->senderid = $from_userid;
		$this->sendername = $from_name;
		$this->receiverid = $to_userid = trim($to_userid);//
		$this->receivername = $to_name;
		$this->messageflag = $m_flag;
		$this->card_no = $card_no;
		$this->inputtime = $from_time;
		$this->receivetime = $to_time;
		$this->save = $save;
		$this->save1 = $save1;
		
		if($del_flag <> "1"){
				//�������� ����
			$this->makeMessageDir($to_userid);
			$this->getMessageList();
			$this->addfullmessage('r');
			if(!file_exists($this->MessageFolder."/receivelist")){
				mkdir($this->MessageFolder."/receivelist");
			}		
			$fp = fopen($this->MessageFolder."/receivelist/".$this->savetime.".php", "w");
			fwrite($fp,$this->memo);
			fclose($fp);
		}
		if($del_flag <> "2"){
			//�������� ����
			$this->makeMessageDir($this->senderid);
			$this->getMessageList();
			$this->addfullmessage('s');
			//echo $this->MessageFolder;
			
			if(!file_exists($this->MessageFolder."/sendlist")){
				mkdir($this->MessageFolder."/sendlist");
			}

			$fp = fopen($this->MessageFolder."/sendlist/".$this->savetime.".php", "w");
			fwrite($fp,$this->memo);
			fclose($fp);
		}
	}
	
		function addfullmessage($type){
		##send : 0: �޽���Ÿ�� 1:�޽�������, 2:�޴¾��̵�, 3:�޴��̸�, 4:����, 5:ī��no, 6:������¥,  7:���ſ���, 8:����flag, 9:microtime
		##receive : 0:�޽�������, 1:�޽�������, 2:�������̵�, 3:�����̸�, 4:����, 5:ī��no, 6:���ų�¥, 7:���ſ���, 8:����flag, 9:microtime
		# �޽���Ÿ�� : r : ����, s : �߽�
		# �޽������� : 0 : �Ϲ�, 1 :ī��
		$userid = $type == "r" ? $this->senderid : $this->receiverid;
		$username = $type == "r" ? $this->sendername : $this->receivername;
		$saveflag = $type == "r" ? $this->save : $this->save1;
		if($type == "r" && $this->save <> "0"){
			$type1 = "rf";
		}else if($type == "r"){
			$type1 = "r";
		}else if($type == "s" && $this->save1 <> "0"){
			$type1 = "sf";
		}else if($type == "s"){
			$type1 = "s";
		}
		
		$saveflag = $type == "r" ? $this->save1 : $this->save;
		$addlist = array(
		0=>$type1,
		1=>$this->messageflag,
		2=>$userid,
		3=>$username,
		4=>"",
		5=>$this->card_no,
		6=>$this->inputtime,
		7=>0,
		8=>"",
		9=>$this->savetime
		);

		array_unshift ($this->contentlist, $addlist);
		
		reset($this->contentlist);

		$str = "";
		$fp = fopen($this->MessageFolder."/messagelist.php", "w");		
		foreach($this->contentlist as $key => $value){
			$str .= serialize($value)."\n";
		}
		fwrite($fp,$str);
		fclose($fp);
	}	
	
	###################################################################################################
	####### �׷�����
	###################################################################################################
	//�׷� �߰� �κ�
	function GroupAdd($ChkMember, $type, $groupname="", $ck_userid="", $groupid=""){
		if($type=="1"){
			$MemberCounter = substr_count($ChkMember, ",");
			$MemberNum = $MemberCounter - 1;
			list($MemberFirst) = explode(",",$ChkMember);
			$sqlstr = "select namekr from MemberInfo where userid ='$MemberFirst'";
			$qrystr = mysql_query($sqlstr, $this->dbcon) or die(mysql_error());
			$mylist = mysql_fetch_array($qrystr);
			//echo $sqlstr;
			echo $MemberFirst."(".$mylist[namekr].")�� ".$MemberNum." ��";
			//echo $this->MemberInsertInfo;
		}elseif($type=="2"){
			$MemberCounter = substr_count($ChkMember, ",");
			$regday = mktime();
			
			$MemberFirst = explode(",",$ChkMember);
			//echo $MemberCounter;
			for($i=0; $i< $MemberCounter; $i++){
				$sqlstr = "select count(*) from MessageGroupDetail where muserid ='$MemberFirst[$i]'";
				$qrystr = mysql_query($sqlstr, $this->dbcon) or die(mysql_error());
				$total = @mysql_result($qrystr,0,0);
				//echo $sqlstr."<br>";
				if($total < 1){
					$insert = "insert into MessageGroupDetail(groupid, userid, muserid, regday) values('$groupid','$ck_userid','$MemberFirst[$i]','$regday')";
					mysql_query($insert);
					//echo $insert."<br>";
				}
			}
			
			echo "
					<script>	
							if(confirm('[$groupname] �׷쿡 ��ϵǾ���ϴ�.\\n���� Ȯ�� �Ͻðڽ��ϱ�?')){
								opener.location.href='./MessageGroup.php';
								window.close();
							}else{
								window.close();
							}
					</script>";
						
		}
	}
	
	//�׷����� ģ���� �̵�
	function GroupFriendAdd($ChkMember, $groupname="", $ck_userid="", $groupid=""){

			$MemberCounter = substr_count($ChkMember, ",");
			$regday = mktime();
			$MemberFirst = explode(",",$ChkMember);
			for($i=0; $i< $MemberCounter; $i++){
					$update = "update  MessageGroupDetail set groupid='$groupid' where muserid='$MemberFirst[$i]' and userid='$ck_userid'";
					mysql_query($update);
				}
		
			echo "
					<script>	
							if(confirm('[$groupname] �׷쿡 ���� �̵��߽��ϴ�..\\n���� Ȯ�� �Ͻðڽ��ϱ�?')){
								opener.location.href='./MessageGroup.php';
								window.close();
							}else{
								opener.window.close();
								window.close();
							}
					</script>";
						
	}
	
	// ģ�� ����Ʈ���� �����ϱ�
	function FriendDel($ChkMember, $ck_userid=""){

			$MemberCounter = substr_count($ChkMember, ",");
			$regday = mktime();
			$MemberFirst = explode(",",$ChkMember);
			for($i=0; $i< $MemberCounter; $i++){
					$delete = "delete  from MessageGroupDetail where muserid='$MemberFirst[$i]' and userid='$ck_userid'";
					mysql_query($delete);
				}
		
			echo "
					<script>	
							if(confirm('ģ���� �������� �����Ͽ����ϴ�.\\n���� Ȯ�� �Ͻðڽ��ϱ�?')){
								opener.location.href='./MessageGroup.php';
								window.close();
							}else{
								opener.location.href='./MessageGroup.php';
								opener.window.close();
								window.close();
							}
					</script>";
						
	}	
		//�׷� ����Ʈ �κ�
	function GroupSelect($ck_userid, $ntype=""){
		$sqlstr = "select *from MessageGroup where userid='$ck_userid' order by regday asc";
		$qrystr = mysql_query($sqlstr, $this->dbcon);
		$total = mysql_num_rows($qrystr);
		//echo $sqlstr;
		if($total < 1){ //�׷��� ��ٸ� ���׷��̶� mgroup 0 ���� ���Ѵ�.
			$regday = mktime();
			$insertg = "insert into MessageGroup(groupid, groupname, userid, regday) values('0', '���׷�', '$ck_userid', '$regday')";
			mysql_query($insertg);
			echo "<script>location.reload();</script>	";
		}
		if(!$ntype){
			echo "<select name='GroupSelect'>";
			while($mylist = mysql_fetch_array($qrystr)):
				echo "<option value='$mylist[groupname]'>$mylist[groupname]</option>";				
			endwhile;
			echo "</select>";
		}
	} 
	
	
	//�׷� �� ����
	function GroupSubTotal($ck_userid, $groupid){
		$sqlstr = "select count(*) from MessageGroupDetail where userid='$ck_userid' and groupid='$groupid'";
		$qrystr = mysql_query($sqlstr, $this->dbcon);
		$total = @mysql_result($qrystr, 0,0);
		echo $total;
	}
	
	//�׷� �߰��ϱ�
	function NewGrouAdd($GroupName, $ck_userid){
		$sqlstr = "select max(groupid) as maxgroupid from MessageGroup where userid='$ck_userid'";
		$qrystr = mysql_query($sqlstr, $this->dbcon);
		$mylist = mysql_fetch_array($qrystr);
		
		//�ߺ����� Ȯ���Ѵ�.
		$sql = "select count(*) from MessageGroup where userid='$ck_userid' and groupname='$GroupName'";
		$qry = mysql_query($sql, $this->dbcon);
		$total = @mysql_result($qry, 0,0);
		
		$maxid =  $mylist[maxgroupid]+1;
		if($maxid > 4){
			echo "<script>alert('�׷��� �ִ� 5������ ���� �� �ֽ��ϴ�.');location.href='./MessageGroup.php';</script>";
			exit;
		}elseif($total > 0){
			echo "<script>alert('$GroupName �׷��� �̹� ��Ǿ��ֽ��ϴ�.\\nȮ�����ּ���.');location.href='./MessageGroup.php';</script>";
			exit;
		}else{
			$regday = mktime();	
			$insertg = "insert into MessageGroup(groupid, groupname, userid, regday) values('$maxid', '$GroupName', '$ck_userid', '$regday')";
			mysql_query($insertg);
			echo "<script>location.href='./MessageGroup.php';</script>	";
		}
		
		
	}
	//�׷� ���� �� �׷� ����Ʈ ����
	function DelGroupList($GroupId, $ck_userid){
		$delete = "delete from MessageGroup where groupid='$GroupId' and userid='$ck_userid'";
		$delete1 = "delete from MessageGroupDetail where groupid='$GroupId' and userid='$ck_userid'";
			
		mysql_query($delete, $this->dbcon);
		mysql_query($delete1, $this->dbcon);	
		//�׷�id�� ���׷��̵� �Ѵ�. 
		$update = "update MessageGroup set groupid = groupid-1 where groupid > $GroupId and userid='$ck_userid'";
		mysql_query($update, $this->dbcon);
		
		echo "<script>location.href='./MessageGroup.php';</script>	";
	}
	
}