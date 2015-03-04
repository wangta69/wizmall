<?php
class member{

	var $dbcon;//db connect 관련 외부 클라스 받기
	var $dbcons;//db connect 관련 외부 클라스 받기(slave);
	var $cfg;//외부 $cfg 관련 배열

## db 클라스 함수 호출용
	function db_connect(&$dbcon){//db_connection 함수 불러오기
		$this->dbcon = $dbcon;
	}

## common 클라스 함수 호출용
	function common(&$common){//db_connection 함수 불러오기
		$this->common = &$common;
	}	

## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null){//
		if($dbcon) $this->dbcon	= $dbcon;
		if($common) $this->common	= $common;
	}
	
	
	function point_fnc($id, $point, $ptype){//수정시 class.common.php 으로 통일(현재는 에러 방지용으로..)
		$this->common->point_fnc($id, $point, $ptype, $contents=null, $flag=0);
	}	
#######################################
########   [ 로그인 시작] 
#######################################
	function login_check($userid, $userpwd){
		$userid = trim($userid);
		$userpwd = trim($userpwd);
		if(!$this->savepath) $this->savepath = "../config/wizmember_tmp/login_user";//파일처리시 저장경로 설정
		$result = $this->availCheck($userid, $userpwd);//아이디와 패스워드의 유효성 검사

		if($result["result"]  != 0){//오류 발생시
			if($this->ajax == true){
				return $result;
			}else{
				$this->common->js_alert($result["msg"]);
			}
		}else{//$id, $pwd 등에 대한 유효성 책크 통과시
			$rtn = $this->start_login($userid, $userpwd);//실제 로그인 처리
			if($rtn["result"] != 0){//ajax 용 alert 처리
				return $rtn;
			}else{
				$this->updatelogindate($userid);//로그인 데이타를 업데이트 시킨다.
				##회원가입이 아니고 로그인 포인트가 있으면
				if($this->loginform	!= "regis" && $this->loginpoint && $this->membertype!="admin") $this->updateloginpoint($userid, $list["mpointlogindate"]);//로그인 포인트를 업데이트 시킨다.
				
				$this->makelogin($rtn["list"]);//각종 쿠키파일 및 로그인 관련 정보를 만든다.
		
				// 아이디 기억일경우 아이디 저장(3개월간)
				if ($this->saveflag=="1"){
					setcookie("saved_id", $userid, time()+86400*31*3, "/");
					setcookie("saveflag", $this->saveflag, time()+86400*31*3, "/");
				}else{
					setcookie("saved_id", "", 0, "/");
					setcookie("saveflag", "", 0, "/");
				}
				return $rtn;
			}
		}
		
	}
	
	function renewLogininfo($userid, $userpwd){//각종 세션값(포인트 등등)이 변경되었을 경우 로그인 정보를 새로 변경
		$list = $this->start_login($userid, $userpwd);//실제 로그인 처리
		$this->makelogin($list);
	}
	
	function availCheck($userid, $userpwd){//아이디/패스워드 유효성 책크
		$id_leng = strlen($userid);
		if(!$userid || !$userpwd) {
			$rtn["result"] = 1;
			$rtn["msg"] = "아이디와 패스워드를 모두 입력해주세요";
			return $rtn;
				/*		
			if($this->ajax == true){

				return $rtn;
			}else{
				$str = "아이디와 패스워드를 모두 입력해 주십시오.\\n\\n";
				$this->common->js_alert($str);
			}
			*/
		}else if(($id_leng >= 13) || ($id_leng < 4)) {
			$rtn["result"] = 1;
			$rtn["msg"] = "아이디는 4~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.";
			return $rtn;
			/*		
			if($this->ajax == true){

			}else{		
				$str = "아이디는 4~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.\\n\\n";
				$this->common->js_alert($str);
			}
			*/
		}else{
			$rtn["result"] = 0;
			return $rtn;		
		}
	}
	
	function get_encrypt_pwd($userpwd){//암호화된 패스워드를 만든다
		$sqlstr = " SELECT PASSWORD('".$userpwd."') ";
		$list = $this->dbcon->get_one($sqlstr);
		return $list;
	}

	function start_login($userid, $userpwd){
        
        
        if(!$this->loginattemptIp($_SERVER['REMOTE_ADDR'])){
            $rtn["result"] = 5;
            $rtn["msg"]    = "1분후 다시 시도해 주세요";
            return $rtn;
        }
		if($this->membertype=="admin"){
				//$sqlstr = "SELECT AdminName, Pass FROM wizTable_Main WHERE Grade ='A' and AdminName = binary('$userid')";//한글일경우 binary 사용시 에러 발생
				$sqlstr = "SELECT AdminName, Pass FROM wizTable_Main WHERE Grade ='A' and AdminName = '".$userid."'";
				$this->dbcon->_query($sqlstr);
				$list = $this->dbcon->_fetch_array();
				if($list){
					$list["mpasswd"]	= $list["Pass"];
					$list["mid"]		= $list["AdminName"];
					$list["mgrade"]		= "admin";
					$list["mname"]		= "관리자";
					$list["mgrantsta"]	="03";
					$list["mpoint"]		="0";
					$list["gender"]		="1";
					$list["nickname"]	= "관리자";
					$this->meminfo		= $list;
				}
		}else{
			/* 아이디 책크 */
			$sqlstr = "SELECT 
			m.mid,m.mpasswd,m.mname,m.mgrade,m.mgrantsta,m.mlogindate,m.mpoint,m.mpointlogindate,m.mexp
			,i.nickname, i.jumin1, i.jumin2, i.email, i.gender
			FROM wizMembers m
			left join wizMembers_ind i on m.mid = i.id
			WHERE m.mid=binary('".$userid."')";
			//mysql_real_escape_string 이부분을 사용하여 보안강화
			$this->dbcon->_query($sqlstr);
			$this->meminfo = $list = $this->dbcon->_fetch_array();
		}

		$mlogindate			= $list["mlogindate"];
		$mpointlogindate	= $list["mpointlogindate"];
		$encrypt_pwd		= $this->get_encrypt_pwd($userpwd);

		if ( !$list ) {	
			$rtn["result"] = 1;
			$rtn["msg"] = "존재하지 않는 아이디 입니다.";
            
			return $rtn;			
		}else if($list["mpasswd"] != $userpwd && $list["mpasswd"] != $encrypt_pwd){//패스워드가 일치하지 않을 경우
		//echo $list[mpasswd].", ".$userpwd.", ".$encrypt_pwd;
		//exit;
			$rtn["result"] = 1;
			$rtn["msg"] = "패스워드가 일치하지 않습니다.";	
		}else if($list["mgrantsta"] =='00'){//탈퇴회원
		/*
		 승인여부 책크 00 : 탈퇴  01 : 승인(위즈 메일용)  02 : 비승인(위즈 메일용)  03 : 승인(위즈 몰용)  04 : 비승인(위즈 메일용)
		*/
			$rtn["result"] = 1;
			$rtn["msg"] = "이미 탈퇴한 회원입니다. \\n 자세한 사항은 관리자에게 문의하세요.";
		}else if($list["mgrantsta"] !='01' && $list["mgrantsta"] !='03'){//승인이 이루어 지지 않았으면
			$rtn["result"] = 1;
			$rtn["msg"] = "승인이 이루어 지지 않았습니다.. \\n 자세한 사항은 관리자에게 문의하세요.";
		}else{
		 	$rtn["result"] = 0;
			$rtn["list"]	= $list;
            
		 }
        $this->setloginlog($userid, $rtn["result"]);
        return $rtn;
	}
    
    /**
     * $result : 0 성공 , 1:실패
     */
    function setloginlog($user_id, $result){
        $ins["mid"] = $user_id;
        $ins["mlogindate"] = time();
        $ins["mloginip"] = $_SERVER['REMOTE_ADDR'];
        $ins["mloginresult"] = $result; 
        $this->dbcon->insertData("wizMembers_login_log", $ins);
    }
    
    /**
     * ip 당 로그인회수 제한
     * 1분에 5회이상 실패시  로그인 실패 메시지 출력
     * $this->loginattemptIp($_SERVER['REMOTE_ADDR']);
     */
    function loginattemptIp($ip){
        $attemptTime = time() - 60;
        $sql = "select count(mid) from wizMembers_login_log where mloginresult = 1 and mloginip = '".$_SERVER['REMOTE_ADDR']."' and mlogindate > ".$attemptTime;
        $count = $this->dbcon->get_one($sql);
        if($count >= 5 ) return false;
        else return true; 
    }
	
    
	function makelogin($list){
		/* 성인 인증쿠키 생성 */
		$AdultAge = "19";
		$MEMBER_AGE = substr($list["jumin1"], 0, 2);
		$MEMBER_BIRTH = substr($list["jumin2"],2,4);
		if (date("Y") - (1900+$MEMBER_AGE) > $AdultAge || (date("Y") - (1900+$MEMBER_AGE) == $AdultAge && $MEMBER_BIRTH <= date("md")) ) {
			$adult = 1;
		}else $adult = 0;
		
		$this->username				= $list["mname"];
		$login["mid"]				= $this->meminfo["mid"];
		//$login["mpasswd"]			= $this->meminfo["mpasswd"];
		$login["mname"]				= $this->meminfo["mname"];
		$login["mgrade"]			= $this->meminfo["mgrade"];
		$login["mgrantsta"]			= $this->meminfo["mgrantsta"];
		$login["mlogindate"]		= $this->meminfo["mlogindate"];
		$login["mpoint"]			= $this->meminfo["mpoint"];
		$login["mpointlogindate"]	= $this->meminfo["mpointlogindate"];
		$login["mmail"]				= $this->meminfo["email"];
		$login["mgender"]			= $this->meminfo["gender"];
		$login["mexp"]				= $this->meminfo["mexp"];
		$login["adult"]				= $adult;
		$login["nickname"]			= $this->meminfo["nickname"];
		$login["mlevel"]			= $this->getLevel($mexp);//(회원의 레벨정보를 가져온다)
		//if($nickname) $mname		= $nickname;//회원이름을 닉네임으로 변경
		
		//기타 필수 config 관련하여 저장(이부분은 프로젝트에 따라 유연하게 변동)
		
		//$MEMBER_INFO = $mid."|".$mpasswd."|".$mname."|".$mgrade."|".$mgrantsta."|".$mlogindate."|".$mpoint."|".$mpointlogindate."|".$adult."|".$mmail."|".$mgender."|".$mexp."|".$mlevel."|||".$p_per."|".$percount."|".$rccomper."|".$recount;
		//$MEMBER_INFO = ".."|".."|".."|".."|".."|".."|".."|".."|".."|".."|".."|||".$p_per."|".$percount."|".$rccomper."|".$recount;
		$MEMBER_INFO = serialize($login);
		
		//session_start();
        session_regenerate_id();
		$session_id = session_id();
		setcookie("usersession", $session_id, 0, "/");
		

		/*******************************************************************************
		회원로그파일의 생성시간을 구해서 2시간(mktime()기준 - 7200)이 경과된 경우 자동삭제..
		*******************************************************************************/
		$LOG_DIR = opendir($this->savepath);
		while($LOG_FILE = readdir($LOG_DIR)) {
			if(is_file($this->savepath."/".$LOG_FILE) && mktime() - filemtime($this->savepath."/".$LOG_FILE) > 7200) {
				unlink($this->savepath."/".$LOG_FILE);
			}
		}
		closedir($LOG_DIR);
		
		$fp = fopen($this->savepath."/".$session_id, "w");
		$LoginTime = time(); 
		fwrite($fp, $MEMBER_INFO);
		fclose($fp);

	}
	

	function updatelogindate($userid){//로그인 데이타를 업데이트 한다.
		$sqlstr = "UPDATE wizMembers SET mloginnum=mloginnum+1, mlogindate = '".time()."', mloginip = '".$_SERVER['REMOTE_ADDR']."' WHERE mid='".$userid."'";
		$this->dbcon->_query($sqlstr);
	}
	
	function updateloginpoint($userid, $mpointlogindate){//
		#최종로그인 시간을 구해 1일이 지났으면 로그인 포인트를 지급한다.
		if($mpointlogindate <= time()-60*60*24*1 || is_null($mpointlogindate)){
			$this->point_fnc($userid, $this->loginpoint, "2");
			$sqlstr = "UPDATE wizMembers SET mloginnum=mloginnum+1, mpointlogindate = '".time()."' WHERE mid='".$userid."'";
			$this->dbcon->_query($sqlstr);
		}
	}
	
	function isjumin($jumin1, $jumin2)//주민번호 책크
	{
		$sqlstr		= "select m.mid, m.mname, mgrantsta from wizMembers m left join wizMembers_ind i on m.mid = i.id where i.jumin1 = '".$jumin1."' and i.jumin2 = '".$jumin2."'";
		$list		= $this->dbcon->get_row($sqlstr);
		$mid		= $list["mid"];
		$mname		= $list["mname"];
		$mgrantsta	= $list["mgrantsta"];
		if($mid)
		{
			return $mid."|".$mname."|".$mgrantsta;
		}
		else
		{
			return false;
		}
	}
		
	function getLevel($point, $flag="L") {## 포인트(경험치)별 레벨 표시
		##flag : L: 레벨리턴, P:경험치리턴
		## 기존 case 문에서 arr 로 바꿈(다음 레벨 도달치를 구하기 위해)
		$level = array("1"=>"372", "2"=>"560", "3"=>"840", "4"=>"1242", "5"=>"1716", "6"=>"2360", "7"=>"3216", "8"=>"4200", "9"=>"5460" 
		,"10"=>"7050", "11"=>"8040", "12"=>"11040", "13"=>"13716", "14"=>"16680", "15"=>"20216", "16"=>"24402", "17"=>"28980", "18"=>"34320","19"=>"40512"
		,"20"=>"48614","21"=>"58337","22"=>"70004","23"=>"84005","24"=>"100806","25"=>"120968","26"=>"145161","27"=>"174194","28"=>"209033","29"=>"250839"
		,"30"=>"301007","31"=>"361209","32"=>"433450","33"=>"520141","34"=>"624169","35"=>"749003","36"=>"898803","37"=>"1078564","38"=>"1294277","39"=>"1553132");		
		if($flag == "P"){
			//echo "여기:".$point;
			return $level[$point];
		}else{
			for($i=1; $i<40; $i++){
				if($level[$i]>=$point) {
					return $i;
					break;
				}
			}
			## for문이 끝까지 돌았으면 40레벨을 리턴한다.
			return "40";
		}
/*
		switch(true){
			case $point < 372 :			$rtn = 1;	break;
			case $point < 560 :			$rtn = 2;	break;
			case $point < 840 :			$rtn = 3;	break;
			case $point < 1242 :		$rtn = 4;	break;
			case $point < 1716 :		$rtn = 5;	break;
			case $point < 2360 :		$rtn = 6;	break;
			case $point < 3216 :		$rtn = 7;	break;
			case $point < 4200 :		$rtn = 8;	break;
			case $point < 5460 :		$rtn = 9;	break;
			case $point < 7050 :		$rtn = 10;	break;
			case $point < 8040 :		$rtn = 11;	break;
			case $point < 11040 :		$rtn = 12;	break;
			case $point < 13716 :		$rtn = 13;	break;
			case $point < 16680 :		$rtn = 14;	break;
			case $point < 20216 :		$rtn = 15;	break;
			case $point < 24402 :		$rtn = 16;	break;
			case $point < 28980 :		$rtn = 17;	break;
			case $point < 34320 :		$rtn = 18;	break;
			case $point < 40512 :		$rtn = 19;	break;
			case $point < 48614 :		$rtn = 20;	break;
			case $point < 58337 :		$rtn = 21;	break;
			case $point < 70004 :		$rtn = 22;	break;
			case $point < 84005 :		$rtn = 23;	break;
			case $point < 100806 :		$rtn = 24;	break;
			case $point < 120968 :		$rtn = 25;	break;
			case $point < 145161 :		$rtn = 26;	break;
			case $point < 174194 :		$rtn = 27;	break;
			case $point < 209033 :		$rtn = 28;	break;
			case $point < 250839 :		$rtn = 29;	break;
			case $point < 301007 :		$rtn = 30;	break;
			case $point < 361209 :		$rtn = 31;	break;
			case $point < 433450 :		$rtn = 32;	break;
			case $point < 520141 :		$rtn = 33;	break;
			case $point < 624169 :		$rtn = 34;	break;
			case $point < 749003 :		$rtn = 35;	break;
			case $point < 898803 :		$rtn = 36;	break;
			case $point < 1078564 :		$rtn = 37;	break;
			case $point < 1294277 :		$rtn = 38; break;
			case $point < 1553132 :		$rtn = 39;	break;
			case $point >= 1553132 :	$rtn = 40;	break;
		}
		*/
		
	}
	
	function getidLevel($id){//아이디 값을 입력 받았을 경우 처리
		$sqlstr = "select mexp from wizMembers where mid = '".$mid."'";
		$exp = $this->dbcon->get_one($sqlstr);
		return $this->getLevel($exp);
	}
	
	## 금번 프로젝트용(이후 삭제) class.board.php getpointcnt 와 동일 내용 수정시 같이 수정
	function getpointcnt($id, $ptype)
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
	}
	
	## 금번 프로젝트용(이후 삭제) class.gamech.php getpointcnt 와 동일 내용 수정시 같이 수정
	function getpointcnt1($id, $ptype)
	{
		## 금일 허락된 갯수를 책크
		$sdate = mktime(0,0,0,date("m"), date("d"), date("Y"));
		$edate = mktime(0,0,-1,date("m"), date("d")+1, date("Y"));
		## 경험치에 대한 정보 가져오기
		$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='6' and wdate between ".$sdate." and ".$edate;
		$count1 = $this->dbcon->get_one($sqlstr);
		## 포인트에 대한 정보 가져오기
		$sqlstr = "select count(*) from wizPoint where id = '".$id."' and ptype='".$ptype."' and flag='0' and wdate between ".$sdate." and ".$edate;
		$count2 = $this->dbcon->get_one($sqlstr);
		
		$count = $count1 > $count2 ? $count1:$count2;
		return $count;
	}

	function getGender($jumin2){
		switch($jumin2){
			case "2":
			case "4":
				$rtn = 2;
			break;
			default:
				$rtn = 1;
			break;
		}
		return $rtn;
	}

    function isChild($jumin, $age) {
            $year = substr($jumin,0,2);
            $sex = substr($jumin,6,1);
            if($sex >=3) // 2000년대 애덜
                    $year = $year + 2000;
            else
                    $year = $year + 1900;
            
            $this_year = date("Y",time());
            
            if($year >= $this_year - $age + 1) // 만 $age세 이하이면
                    return 1;
            else
                    return 0;
    }
/*	
	//다양한 비밀 번호 포맷에 맞추어 현재 이 부분을 클라스화 하여 일괄적으로 관리
	function ini_pwd($id, $passwd){
		if($this->$cfg["common"]["mempwd"] = "PASSWORD"){
			$sqlstr = "UPDATE wizMembers SET  mpasswd = PASSWORD('$passwd'), WHERE mid='".$id."' ";	
		}else{
			$sqlstr = "UPDATE wizMembers SET  mpasswd = PASSWORD('$passwd'), WHERE mid='".$id."' ";	
		}
		$dbcon->_query($sqlstr);
	}
*/
}