<?php
if($common->checsrfkey($csrf)){
	if ($qry == "qup") {
			if($grantsta=="03"){//현재승인상태
				$mgrantsta = "04";
			}else if($grantsta=="00"){//현재 탈퇴상태
				$mgrantsta = "04";
			}else{//현재 보류샹태
				$mgrantsta = "03";
			}
	        $QUERY1 = "UPDATE wizMembers SET mgrantsta = '$mgrantsta' WHERE mid='$id'";
	        $dbcon->_query($QUERY1);
	}else if ($qry == "qde") {// 회원삭제하기
		foreach($DeleteMember as $key => $value){
		$sqlstr = "select mid from wizMembers WHERE uid='$key'";
		$mid = $dbcon->get_one($sqlstr);
			if($mid){
				$dbcon->_query("DELETE FROM wizMembers WHERE mid='$mid'");
				$dbcon->_query("DELETE FROM wizMembers_ind WHERE id='$mid'");
				//$dbcon->_query("DELETE FROM wizMembers_meeting WHERE id='$mid'");
				$dbcon->_query("DELETE FROM wizPoint WHERE id='$mid'");
			}
		}
	}
}
