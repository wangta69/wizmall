<?php
class calendar{
	var $dbcon;//db connect 관련 외부 클라스 받기
	var $month;//현재카렌다에 디스플레이 할 month;
	var $setDate;//설정된 년월일
	var $setData;//일정등록된 데이타 
	var $category;
	var $cfg;

	
	/*
	if(!strcmp($query,"diarysave")){
	
	$Schedule_Date = mktime("$ScheduleHour", "$ScheduleMinute", "$ScheduleSecond", "$ScheduleMonth", "$ScheduleDay", "$ScheduleYear");
	$sqlstr = "insert into wizDiary(Writer,PWD,Schedule_Date,ScheduleSubject,Schedule,Status,Spare1,Spare2)
	values('$Writer','$PWD','$Schedule_Date','$ScheduleSubject','$Schedule','$Status','$Spare1','$Spare2')";
	$dbcon->_query($sqlstr);
}
else if(!strcmp($query,"diarymodify")){
	$Schedule_Date = mktime("$ScheduleHour", "$ScheduleMinute", "$ScheduleSecond", "$ScheduleMonth", "$ScheduleDay", "$ScheduleYear");
	$sqlstr = "UPDATE wizDiary SET Writer='$Writer',Schedule_Date='$Schedule_Date',ScheduleSubject='$ScheduleSubject',Schedule='$Schedule',Status='$Status',Spare1='$Spare1',Spare2='$Spare2' WHERE UID='$UID'";
	$dbcon->_query($sqlstr);
}else if(!strcmp($query,"diarydelete")){
	$sqlstr = "delete from wizDiary where UID = '$UID'";
	$dbcon->_query($sqlstr);
	echo "<script >alert('일정을 삭제하였습니다.');
	location.replace('$PHP_SELF?menushow=$menushow&theme=util/util2&pmode=view&Month=$Month&ThedayThetime_value=$ThedayThetime') ;
	</script>";
	exit();
}
	*/
	/*
	 * CREATE TABLE IF NOT EXISTS `wizDiary` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL DEFAULT '',
  `schedule_date` int(11) NOT NULL DEFAULT '0',
  `schedule_title` varchar(50) NOT NULL DEFAULT '',
  `schedule_comment` text NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `category` varchar(10) NOT NULL DEFAULT '',
   PRIMARY KEY (`uid`)
) ENGI
	 */
	/**
	 * 스케쥴 저장
	 */
	 function save_schedule(){
		if($_POST["uid"]){
			unset($ins);
			//$ins["user_id"]				= $this->cfg["member"]["mid"];
			$ins["schedule_date"]		= mktime($_POST["ScheduleHour"], $_POST["ScheduleMinute"], $_POST["ScheduleSecond"], $_POST["sel_month"], $_POST["sel_day"], $_POST["sel_year"]);;
			$ins["schedule_title"]		= $_POST["schedule_title"];
			$ins["schedule_comment"]	= $_POST["schedule_comment"];
			$ins["status"]				= $_POST["status"];
			$ins["category"]			= $_POST["category"];
			$this->dbcon->updateData("wizDiary", $ins, "uid=".$_POST["uid"]." and user_id='".$this->cfg["member"]["mid"]."'");
		}else{
			unset($ins);
			$ins["user_id"]				= $this->cfg["member"]["mid"];
			$ins["schedule_date"]		= mktime($_POST["ScheduleHour"], $_POST["ScheduleMinute"], $_POST["ScheduleSecond"], $_POST["sel_month"], $_POST["sel_day"], $_POST["sel_year"]);;
			$ins["schedule_title"]		= $_POST["schedule_title"];
			$ins["schedule_comment"]	= $_POST["schedule_comment"];
			$ins["status"]				= $_POST["status"];
			$ins["category"]			= $_POST["category"];
			$this->dbcon->insertData("wizDiary", $ins);
		}
	 }
	 
  
	  /**
	   * 스케쥴 삭제
	   */
	function delete_schedule(){
		//print_r($_POST);
		//print_r($this->cfg);
		$this->dbcon->deleteData("wizDiary", "uid=".$_POST["uid"]." and user_id='".$this->cfg["member"]["mid"]."'");
	}
	  
	
	
	
		/* 특정 년 월을 구하는 함수 */
	function get_workcalendar($mode=null, $month=null){
		switch($mode){
			case "minus": $month--;break;
			case "plus": $month++;break;
			case "minusyear": $month=$month-12;break;
			case "plusyear": $month=$month+12;break;
			default:unset($month);break;
		}
		
		$rtn["month"]	= $month;
		$rtn["time"] 	= mktime(0,0,0,date("m")+$month,1,date("Y"));
		return $rtn;
	}

	## 금월로 등록된 모든 정보가져오기
	function get_schedule($time){

		$sql = "select uid, schedule_date, schedule_title, schedule_comment from wizDiary where FROM_UNIXTIME(schedule_date, '%Y%m') = '".date("Ym", $time)."' order by schedule_date asc";
		$rows	= $this->dbcon->get_rows($sql);
		
		//각각을 일별로 매칭 시켜준다.
		//$cnt = 0;
		if(is_array($rows)) foreach($rows as $key => $val){
			$date						= date("Ymd", $val["schedule_date"]);
			$rtn[$date]["subject"][]	= $val["schedule_title"];
			$rtn[$date]["schedule"][]	= $val["schedule_comment"];
		}

		return $rtn;

	}
	
	//날짜에 등록된 데이타 가져오기
	function getData() {
		$where = "where FROM_UNIXTIME(Schedule_Date, '%Y%m') = " . date("Ym", $this->setDate);
		if($this->category) $where .=" and category = '".$this->category."'";
		$sqlstr = "select * from wizDiary ".$where;
		$rows = $this->dbcon -> get_rows($sqlstr);
		//print_r($rows);
		if (is_array($rows)) {
			foreach ($rows as $key => $val) {
				$day = (int)date("d", $rows[$key]["schedule_date"]);
				//$data[$day]["schedule_title"] = $val["schedule_title"];
				//$data[$day]["schedule_comment"] = $val["schedule_comment"];
				//$data[$day]["uid"] = $val["uid"];
				$data[$day][]	= $val;
			}
		}
		$this->setData = $data;
	}

	//일자별 색상 변경
	function mkcode($day, $count) {
		$tag = "";
		if (date("Ymd") == date("Ym", $this->setDate). $day)
			$tag = "today";
		else if ($this->setData[$day])
			$tag = "event";
		elseif (!($count % 7))
			$tag = "sunday";
		elseif (($count % 7)==6)
			$tag = "saturday";
		switch($tag) {
			case "today" :$link = "<span class='today'>" . $day . "</span>";break;
			case "event" :$link = "<span class='event'>" . $day . "</span>";break;
			case "sunday" :$link = "<span class='sunday'>" . $day . "</span>";break;
			case "saturday" :$link = "<span class='saturday'>" . $day . "</span>";break;
			default :$link = $day;break;
		}
		return $link;
	}


	//일자별 등록된 리스트 보여주기
	function displaytitle($day, $type=null) {
		$link	= "";
		switch($type){
			case "admin"://관리자동 
				if(is_array($this->setData[$day])) foreach($this->setData[$day] as $key => $val){
					$link .= '<div uid="'.$val["uid"].'" day="'.$day.'" class="btn_go_modify">'.$val["schedule_title"].'</div>';
				}
			break;
			default:
				if(is_array($this->setData[$day])) foreach($this->setData[$day] as $key => $val){
					$link .= '<div uid="'.$val["uid"].'" class="btn_go_cal">'.$val["schedule_title"].'</div>';
				}
			break;
		}
		
		return $link;
		
	}

	
	/*
	function getTitle($fyear, $fmonth, $fday, $menushow) {
		$cc_Date = $fyear . "-" . $fmonth . "-" . $fday;
		$whereis = " where schedule_date = '" . $cc_Date . "'";
		if ($m_id != "")
			$whereis = $whereis . " and cc_m_id = '" . $m_id . "'";
		$sqlstr = "select schedule_title, schedule_comment from wizDiary" . $whereis;
		$row = $dbcon -> get_rows($sqlstr);
	}
	
	function isData($fyear, $fmonth, $fday, $menushow) {
		$isData = false;
		$cc_Date = $fyear . "-" . $fmonth . "-" . $fday;
		$whereis = " where schedule_date = '" . $cc_Date . "'";
		if ($m_id != "")
			$whereis = $whereis . " and user_id = '" . $m_id . "'";
		$sqlstr = "select schedule_title, schedule_comment from wizDiary" . $whereis;
		$row = $dbcon -> get_rows($sqlstr);
		if (!count($row)) {
			$isData = false;
		} else {
			$uid		= $row[0]["schedule_title"];
			$cc_Title	= $row[0]["schedule_comment"];
			$isData = true;
		}
	}
	
	 */

	
	/**
	 * 설정정보를 기본으로 Month 처리
	 * $args = array("mode"=>,"month"=>"" );
	 */
	 function setMonth($args){
	 	$this->month = $args["month"];
	 	switch($args["mode"]){
			case "minus":$this->month--;break;
			case "plus":$this->month++;break;
			case "minusyear":$this->month = $this->month - 12;break;
			case "plusyear":$this->month = $this->month + 12;break;
			case "directMonth"://month 직접입력
			case "view"://보기
			case "write"://쓰기
			break;
			default:unset($this->month);break;	
		}
	 }
	/**
	 * 설정데이타를 가져온다.
	 */
	function getsetDate(){
		$this->day = $this->day ? $this->day : 1;
		$this->setDate = mktime(0, 0, 0, date("m") + $this->month, $this->day, date("Y"));
	}
	

	
	
	function getDays() {

		$days = 1;
		while (checkdate(date("m", $this->setDate), $days, date("Y", $this->setDate))) {
			$days++;
		}
		return $days;
	}

}	
