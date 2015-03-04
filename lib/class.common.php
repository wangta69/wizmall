<?php
#update
# 09.06.04 일 paging 관련 추가 및 수정
class Common{
	
	var $dbcon;//db connect 관련 외부 클라스 받기
	var $dbcons;//db connect 관련 외부 클라스 받기(slave);
	var $cfg;//외부 $cfg 관련 배열

## 다중 클라스 함수 호출용(상기 대신 앞으로 이거 사용)
	function get_object(&$dbcon=null, &$Image=null, &$Xml=null){//정의클라스 불러오기
		if($dbcon) $this->dbcon	= $dbcon;
		if($Image) $this->Image	= $Image;
		if($Xml) $this->Xml	= $Xml;
	}
	
## db 클라스 함수 호출용
	function db_connect(&$dbcon){//db_connection 클라스 불러오기
		$this->dbcon = $dbcon;
	}
		


## Image 클라스 함수 호출용
	function Image(&$Image){//Image 클라스 불러오기
		$this->Image = &$Image;
	}

	function js_alert($str, $goto="back", $flag="exit"){
		switch($flag){
			case "alert"://단순하게 alert메시지만 보여줌
				echo "<script>alert('".$str."');</script>";
			break;
			default:
				switch($goto){
					case "alert"://단순하게 alert메시지만 보여줌(상기거 대처)
						echo "<script>alert('".$str."');</script>";
					break;
					case "cur"://현재 페이지에서 alert메시지만 제공
						echo "<script>alert('".$str."');</script>";
						exit;
					break;
					case "close"://현재 페이지 닫기
						echo "<script>alert('".$str."');self.close();</script>";
						exit;
					break;
					case "back"://현재 페이지 닫기
						echo "<script>alert('".$str."');history.go(-1);</script>";
						exit;
					break;
					default:
						echo "<script>alert('".$str."');location.href='".$goto."'</script>";
						exit;
					break;						
				}
				return false;
			break;
		}
	}
	
	function js_location($goto, $flag=null){
		switch($flag){
			default:
				echo "<script>location.href='".$goto."'</script>";
			break;						
		}
		exit;
		return false;
		
	}


	function js_confirm($str, $goto, $act="history.go(-1)"){
		if($goto == "history.go(-1)") echo "<script>if(confirm('".$str."')){".$goto."}else{'".$act."'}</script>";
		else echo "<script>if(confirm('".$str."')){location.href='".$goto."'}else{".$act."}</script>";
		exit;
	}
/*
	function js_confirm($str, $goto, $act="history.go(-1)"){
		if($goto == "history.go(-1)") echo "<script>if(confirm('".$str."')){".$goto."}else{".$act."}</script>";
		else echo "<script>if(confirm('".$str."')){location.href='".$goto."'}else{".$act."}</script>";
		exit;
	}
	*/

	function js_windowclose($str=null, $goto=null){
		$rtnmsg = "<script>";
		if($str) $rtnmsg .= "alert('".$str."');";
		if($goto)
		{
			if($goto == "reload") $rtnmsg .= "opener.location.reload();";
			else $rtnmsg .= "opener.location.replace('".$goto."');";
		}
		$rtnmsg .= "window.close();";
		$rtnmsg .= "</script>";
		echo $rtnmsg;
		exit;
	}
	
	function form_submit($action, $arr=null, $method="POST")
	{
		echo "<html><body>";
		echo "<form name=\"cls_submit\" action=\"".$action."\" method=\"".$method."\">\n";
		if(is_array($arr)) foreach($arr as $key=>$value)
		{
			echo "<input type='hidden' name='".$key."' value='".$value."'>\n";	
		}
		echo "</form>";
		echo "<script>document.cls_submit.submit();</script>\n";
		echo "</body></html>";
		exit;
	
	}
#######################################
########   [ 폴더 및 파일 관련] 
#######################################
	
	function mkfolder($path){## 폴더 생성
		//if(!file_exists($path)){
		if(!is_dir($path)){
			$result = @mkdir($path, 0777);
			if(!$result){ 
				$this->js_alert($path." 생성실패");
				return false;
			}else return true;
		}
	}

	/**
	 * 모든 경로 생성하기
	 */
	function mkfolders($path){
		$exFolder = explode("/", $path);
		$curpath = "";
		if(is_array($exFolder)) foreach ($exFolder as $key => $value) {
			if($value && $value != "." && $value != ".."){
				$curpath = $curpath."/".$value;
				$this->mkfolder($curpath);
			}else if($value == "." || $value == ".."){
				$curpath = $value;
			}
		} 
	}
	
	function cpfile($file, $source_path, $target_path){## 폴더 생성
		copy($source_path."/".$file, $target_path."/".$file);
	}


	function CopyFile($source_path, $target_path, $arr=null){## 폴더 생성
		//$filename = null;
		//echo $target_path;
		$filename	= substr(strrchr($target_path, "/"), 1);
		$filepath	= substr($target_path, 0, -strlen($filename));
		if(is_array($arr)){
			if($arr["overwrite"] == true && is_file($target_path) ){
				$filename	= "_".$filename;
				copy($source_path, $filepath.$filename);
				//$this->CopyFile($source_path, $filepath.$filename, $arr);
			}else{
				copy($source_path, $target_path);
			}

		}else{
			copy($source_path, $target_path);
		}

		return $filename;
	}
	
	# 특정폴더이하 모든 파일 copy
	function CopyFiles($source,$dest){   
		//$this->mkfolder($dest);
		$this->mkfolders($dest);
		$folder = opendir($source);
		while($file = readdir($folder)){
			if ($file == '.' || $file == '..') continue;
	
			if(is_dir($source.'/'.$file)){
				mkdir($dest.'/'.$file,0777);
				$this->CopyFiles($source.'/'.$file,$dest.'/'.$file);
			}else copy($source.'/'.$file,$dest.'/'.$file);
		}
		closedir($folder);
		return 1;
	}

	# 현재 폴더의 파일을 모두 읽어옮
	function readFileList($targetdir){
		$open_file = opendir($targetdir);
	
		while($opendir = readdir($open_file)) {
			if(($opendir != ".") && ($opendir != "..") && is_file($targetdir."/".$opendir)) {
				$createTime	= filemtime($targetdir.$opendir); 
				//$fileArr[$createTime] = $opendir;//createTime 은 중복됨 
				$fileArr[] = $opendir;//createTime 은 중복됨 
			}
		}
		closedir($open_file);
		return $fileArr;
	
	}



	//remove file, directories, subdirectories
	public function RemoveFiles($source){
		if (is_dir($source)){
			$folder = opendir($source);
			while($file = readdir($folder)){
				if ($file == '.' || $file == '..')continue;
				if(is_dir($source.'/'.$file)) $this->RemoveFiles($source.'/'.$file);
				else unlink($source.'/'.$file);
			}
			closedir($folder);
			rmdir($source);
		}
		return 1;
	}


	public function RemoveFile($source){
		if (is_file($source)) unlink($source);
		return 1;
	}
	
	/**
	 * $src, $desc : 파일이 포함된 디렉토리
	 */
	public function moveFiles($src, $desc){
		$this->CopyFiles($src, $desc);
		$this->RemoveFiles($src);
	}
#######################################
########   [ 파일업로드] 
#######################################


	function file_uploade($file_field_name){
		//reset($_FILES[$file_field_name]);
		$this->file_name=$_FILES[$file_field_name]['name'];
		$this->file_type=$_FILES[$file_field_name]['type'];
		$this->file_error=$_FILES[$file_field_name]['error'];
		$this->file_size=$_FILES[$file_field_name]['size'];
		$this->file_tmp_name=$_FILES[$file_field_name]['tmp_name'];
		
		//print_r($_FILES);
		//exit;
		//print_r($this->file_name);
	}

	

	function uploadfile($file_field_name){
	
	//echo $file_field_name;
	
## 사용예제
## include "./lib/class.common.php";
## $common = new common();
## $common->upload_path = "./config/uploadfolder";
## $common->ProhibitExtention = "cgi, php, asp, jsp, exe, php3, php4, html, htm, shtml";
## $common->uploadmode = "insert" / update
## $common->uploadfile("attached");	//attached 등은 반드시 배열이여야 한다.
## $common->oldfilename upload된 파일명을 받는다(다중일경우 "|" 로 된 파일을 넘겨준다)
## $common->delfile = $delflag//파일삭제 책크시(delflag 는 반드시 배열)(수정시)


## 리턴파일처리예제
## foreach($common->returnfile as $key=>$value){
## echo base64_decode($value)."<br>";
## echo "<img src='".$common->upload_path."/".$value."'>";
## }

##주의 $file_field_name 은 반드시 배열(Array)속성을 띄어야 한다. 예)attach_file[] 혹은  attach_file[0], attach_file[1]... 
## 실예 <input type="file" name="attached[]" id="attached">

## [간략사용예제] - insert시
##	$common->upload_path = "../config/banner";
##	$common->uploadmode = "insert";
##	$common->uploadfile("file");
##	$linkimg = $common->returnfile[0];

## [간략사용예제] - update시
##	$common->upload_path = "../config/banner";
##	$common->uploadmode = "update";
##	$common->oldfilename = $oldfile;
##	$common->uploadfile("file");
##	$linkimg = $common->returnfile[0];

		if(!$this->uploadmode) $this->uploadmode = "insert";
//echo $this->uploadmode;
		if($this->uploadmode == "insert"){
//echo "여기:".$file_field_name." <br>";
			$this->file_uploade($file_field_name);//register global on에서 작동되게 설계

			$cnt=0;
			//if (is_array($this->file_name) == FALSE) $this->js_alert("파일타입의 이름을 name='file[0]' 처럼 배열로 정의해 주세요");

			while(is_array($this->file_name) && list($att_key, $att_value) = each($this->file_name)):
			
			//echo $att_key.", ".$att_value;
				$MicroTsmp = explode(" ",microtime());
				$newFileName = str_replace(".", "", $MicroTsmp[0]);
				if($this->file_tmp_name[$att_key]!="none" && $this->file_tmp_name[$att_key]){
					
					##허용 확장자 처리
					if($this->AllowExtention) $this->is_allow($this->file_name[$att_key]);
					
					##금지 확장자 처리
					if($this->ProhibitExtention) $this->is_prohibit($this->file_name[$att_key]);

					$upfilename = $this->base64_url_encode($this->file_name[$att_key]);
					
					if (file_exists($this->upload_path."/".$upfilename)) {
							$upfilename = $this->base64_url_encode($newFileName."_".$this->file_name[$att_key]);
					}    
					
					if(!move_uploaded_file($this->file_tmp_name[$att_key], $this->upload_path."/".$upfilename)) {
						echo "<script>window.alert('파일 업로딩에 실패하였습니다.\\n에러:\\ntmp_file = ".$this->file_tmp_name[$att_key]."\\nuploadpath=".$this->upload_path."/".$this->file_name[$att_key]."');history.go(-1);</script>";
						return false;
						exit;
					}
					$this->returnfile[$cnt]=$upfilename;			
				}
				$cnt++;	
			endwhile;//while(list($att_key, $att_value) = each($file_name)):
		}else if($this->uploadmode == "update"){//if($mode == "insert"){
			$this->file_uploade($file_field_name);
			$oldfile = explode("|", $this->oldfilename);
			
			
			$cnt=0;
			reset($oldfile);
			if(is_array($this->file_name)) ksort($this->file_name);
			while(is_array($this->file_name) && list($att_key, $att_value) = each($this->file_name)):
				$MicroTsmp = explode(" ",microtime());

				$newFileName = str_replace(".", "", $MicroTsmp[0]);
				
				if($this->file_tmp_name[$att_key]!="none" && $this->file_tmp_name[$att_key]){
				
					##허용 확장자 처리
					if($this->AllowExtention) $this->is_allow($this->file_name[$att_key]);

					##금지 확장자 처리
					if($this->ProhibitExtention) $this->is_prohibit($this->file_name[$att_key]);

					$Tmp1[$att_key]=$this->file_name[$att_key];	
					$upfilename = $this->base64_url_encode($this->file_name[$att_key]);
					if($oldfile[$att_key]) @unlink($this->upload_path."/".$oldfile[$att_key]);
	
					if (file_exists($this->upload_path."/".$upfilename)) {
						$upfilename = $this->base64_url_encode($newFileName."_".$this->file_name[$att_key]);
					} 

					if(!move_uploaded_file($this->file_tmp_name[$att_key], $this->upload_path."/".$upfilename)) {
						echo "<script>window.alert('파일 업로딩에 실패하였습니다.\\n에러:\\ntmp_file = ".$this->file_tmp_name[$att_key]."\\nuploadpath=".$this->upload_path."/".$this->file_name[$att_key]."');history.go(-1);</script>";
						return false;
						exit;
					}
					$this->returnfile[$cnt]=$upfilename;
				}else if($this->delfile[$att_key] && $oldfile[$att_key]){ //파일 삭제 옵션이 책크 되어 있으면
					unlink($upload_path."/".$oldfile[$att_key]);
					
				}else {
					$this->returnfile[$cnt]=$oldfile[$att_key];
				}
				$cnt++;
			endwhile;
		}//}else if($mode == "update"){//if($mode == "insert"){
	}
	
	function is_allow($filename){
		$AllowArrList = preg_split("/[, |]+/",$this->AllowExtention);
		$ext = substr(strrchr($filename, "."), 1);
		$this->allowExt($ext, $AllowArrList);
	}

	function is_prohibit($filename){
		$prohibitArrList = preg_split("/[, |]+/",$this->ProhibitExtention);
		$ext = substr(strrchr($filename, "."), 1);
		$this->prohibitExt($ext, $prohibitArrList);
	}

	function allowExt($ext, $prohibitArrList){
		if(in_array($ext, $prohibitArrList) == FALSE) $this->js_alert("허용되지 않은 확장자 입니다.");
	}

	function prohibitExt($ext, $prohibitArrList){
		if(in_array(strtolower($ext), $prohibitArrList)) $this->js_alert("금지된 파일이 첨부 되었습니다.");
	}

	function getImgName($str){//base64_encode로 저장된 파일명을 원래 파일명으로 돌리기
		return $this->base64_url_decode($str);
	}
## 현재 이미지 테이블당 이미지 정보 가져오기  시작
	function getProductImgList($uid, $opflag="m"){//img 테이블에 속한 각각의 이미지를 불러오기
		$tmp = array();
		$sqlstr = "select filename, orderid from wizMall_img where pid = '".$uid."' and opflag = '".$opflag."' order by orderid asc";
		$result = $this->dbcon->_query($sqlstr);
		$this->oldfilename = "";
		while($list = $this->dbcon->_fetch_array()):
			extract($list);
			$tmp[$orderid] = $filename;
		endwhile;
		$max = $this->getkeyinArray($tmp);
		reset($tmp);
		for($i=0; $i<=$max; $i++){
			//echo $i.":".$tmp[$i]."<br>";
			$this->oldfilename .= $tmp[$i]."|";		
		}
		//echo $this->oldfilename;
		//exit;
	}

	function getImgList($uid, $tbname){//img 테이블에 속한 각각의 이미지를 불러오기
		$tmp = array();
		$sqlstr = "select filename, orderid from wizImg where pid = '".$uid."' and tbname = '".$tbname."' order by orderid asc";
		$result = $this->dbcon->_query($sqlstr);
		$this->oldfilename = "";
		while($list = $this->dbcon->_fetch_array()):
			extract($list);
			$tmp[$orderid] = $filename;
		endwhile;
		$max = $this->getkeyinArray($tmp);
		reset($tmp);
		for($i=0; $i<=$max; $i++){## 추후 시스템 변경시는 모든 부분을 배열로 처리
			$this->oldfilename .= $tmp[$i]."|";		
		}
	}

## 현재 이미지 테이블당 이미지 정보 가져오기  끝

	function image_up($mode="insert", $path, $file, $tbname, $uid=null){
		## $mode : update or insert, $path : 업로드 경로, $file: upload파일명- 파일필드명(array 속성)
		## 저장될 카테고리 생성
		if(!$path) $this->js_alert("업로드 경로를 설정해 주시기 바랍니다.");
		$this->mkfolder($path);
		$this->upload_path = $path;
		$this->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->uploadfile($file);

		}else if($mode == "update"){
			$this->getImgList($uid, $tbname);//기존 상품을 가져온다.$this->oldfilename 로 저장됨
			$this->uploadfile($file);//배열로서 전달됨
		}
		$rtnfile = $this->returnfile;
		#워터마크 시작
		//if($rtnfile[0]) $this->mkwatermark($rtnfile[0]);
		return $rtnfile;
	}
	
	
	function input_imgtable($uid, $rtnfile, $tbname){##
		if(is_array($rtnfile))
		{
			$sqlstr = "delete from wizImg where pid = '".$uid."' and tbname='".$tbname."'";
			$this->dbcon->_query($sqlstr);
			
			foreach($rtnfile as $key=>$value){
				if(trim($value)){
					unset($ins);
					$ins["pid"]			= $uid;
					$ins["orderid"]		= $key;
					$ins["filename"]	= $value;
					$ins["tbname"]		= $tbname;
					$this->dbcon->insertData("wizImg", $ins);
				}
			}
		}
	}
		
	function mkwatermark($sourceimg, $logoimg=NULL){//class admin에 동일 함수 존재
		$dstpath = $srcpath	= $this->common->upload_path."".$sourceimg;//저장 파일명
		if($this->watermark == "text"){
			$info = getimagesize($srcpath);
			$mime = explode("/", $info["mime"]);##image/jpeg
			$this->Image->font_path = "./basicconfig/font/arial.ttf";
			$this->Image->dst_x=$info[0]; //출력이미지 width 크기값
			$this->Image->dst_y=$info[1];
			$this->Image->savefile = $dstpath;
			$this->Image->impressWaterMark($mime[1],$srcpath,$this->watermark_text);
		}else if($this->watermark == "img"){
			$logo_path = $_SERVER["DOCUMENT_ROOT"].$this->watermark_img;
			$this->common->Image->imageWaterMaking($srcpath, $logo_path, 90);
		}
	}
	
	function getpdimgpath($category, $filename, $path="./"){//추후 class.wizmall.php에서 담당
		$fullpath = $path."config/uploadfolder/productimg/".substr($category, -3)."/".$filename;
		return $fullpath;
	}

	## $c_cat : 현재 카테고리, $n_cat : 신규 카테고리
	function moveProductImg($c_cat, $n_cat){//현재 카테고리 이미지를 변경된 카테고리로 이동
		//이것을 실행하기 위해서는 상기 getProductImgList가 실행되어야 한다.
		//$this->upload_root_path = "../config/uploadfolder/productimg/"
		$c_folder = substr($c_cat, -3);
		$n_folder = substr($n_cat, -3);
		
		if($c_folder != $n_folder){
			$eachProduct = explode("|",$this->oldfilename);
			foreach($eachProduct as $key => $value){
				if($value){
					//echo $this->upload_root_path.$c_folder."/".$value.", ".$this->upload_root_path.$n_folder."/".$value;
					$result = copy($this->upload_root_path.$c_folder."/".$value, $this->upload_root_path.$n_folder."/".$value);			//if(!$result) exit;
					unlink ($this->upload_root_path.$c_folder."/".$value);
				}
				
			}
		}
		//exit;	
	}
	
	/**
	 * 분기별 날짜 구하기
	 * $rtn = getQuater("1", 2014);
	 * echo date("Y.m.d", $rtn["start"]), "~", date("Y.m.d", $rtn["end"]), "</br>";
	 */
	function getQuater($quarter, $year){
		switch($quarter){
			case "1":
				$rtn	=  array(
							    'start' => mktime(0, 0, 0, 1, 1, $year),
							    'end' => mktime(0, 0, 0, 3, date('t', mktime(0, 0, 0, 3, 1, $year)), $year)
							);
				break;
			case "2":
				$rtn	=  array(
							    'start' => mktime(0, 0, 0, 4, 1, $year),
							    'end' => mktime(0, 0, 0, 6, date('t', mktime(0, 0, 0, 6, 1, $year)), $year)
							);			
				break;
			case "3":
				$rtn	=  array(
							    'start' => mktime(0, 0, 0, 7, 1, $year),
							    'end' => mktime(0, 0, 0, 9, date('t', mktime(0, 0, 0, 9, 1, $year)), $year)
							);			
				break;
			case "4":
				$rtn	=  array(
							    'start' => mktime(0, 0, 0, 10, 1, $year),
							    'end' => mktime(0, 0, 0, 12, date('t', mktime(0, 0, 0, 12, 1, $year)), $year)
							);			
				break;
	
		}
		
		return $rtn;
	}
## 두 date 간의 시간 구하기
	function timeDiff($ts1, $ts2) {
		if ($ts1 < $ts2) {
			$temp = $ts1;
			$ts1 = $ts2;
			$ts2 = $temp;
		}
		$format = 'Y-m-d H:i:s';
		$ts1 = date_parse(date($format, $ts1));
		$ts2 = date_parse(date($format, $ts2));
		$arrBits = explode('|', 'year|month|day|hour|minute|second');
		$arrTimes = array(0, 12, date("t", $temp), 24, 60, 60);
		foreach ($arrBits as $key => $bit) {
			$diff[$bit] = $ts1[$bit] - $ts2[$bit];
			if ($diff[$bit] < 0) {
				$diff[$arrBits[$key - 1]]--;
				$diff[$bit] = $arrTimes[$key] - $ts2[$bit] + $ts1[$bit];
			}
		}
		return $diff;
		## 사용 예제
		## $start_date = mktime(0, 0, 0, 10, 1, 2007);
		## $end_date = mktime(0,0,0,date("m")-1, 1, date("Y")); 
		## $date_diff_array = timeDiff($start_date, time());
		## print_r($date_diff_array);

		### 추가로 아래처럼 처리하면 특정년월부터 증감을 표시할 수 있다.
		## $init_i = $date_diff_array['year']*12 + $date_diff_array['month'];
		## $thismonth = date("m");
		## $thisyear = date("Y");
		## for($i=0; $i<=$init_i; $i++) echo date("Ym", mktime(0,0,0,$thismonth-$i, 1, $thisyear))."<br>";
	}

	## 날짜관련 실렉트 출력
	## $reddate : 기존 입력된 날짜
	function getSelectDate($regdate=null){
		//echo "<br>regdate:".date("Y.m.d,h,i,s", $regdate)."<br>";
		//$regdate 는 unixStamp
		
		$ThisYear = date("Y");
		$ThisMonth = date("m");
		$ThisDay = date("d");
		$ThisHour = date("H");
		$ThisMin = date("i");
		$ThisSec = date("s");
		
		$this->rtn_year = "";
		$this->rtn_month = "";
		$this->rtn_day = "";
		$this->rtn_hour = "";
		$this->rtn_min = "";
		$this->rtn_sec = "";
	
		//년도는 시작연도와 끝 연도를 가져온다 없을 경우 초기화
		$startyear = $this->startyear ? $this->startyear:($ThisYear-1);
		$endyear = $this->endyear ? $this->endyear:($ThisYear+1);
		
		if(!$regdate){
			$regyear		= $ThisYear;
			$regmonth	= $ThisMonth;
			$regday		= $ThisDay;
			$reghour		= $ThisHour;
			$regmin		= $ThisMin;
			$regsec		= $ThisSec;
		}else{
			$regyear		= date("Y", $regdate);
			$regmonth	= date("m", $regdate);
			$regday		= date("d", $regdate);
			$reghour		= date("H", $regdate);
			$regmin		= date("i", $regdate);
			$regsec		= date("s", $regdate);	
		}


		###   display select box for year 
		//echo "startyear = $startyear , endyear = $endyear ";
		for($i=$startyear; $i <= $endyear; $i++){
			if($regyear == $i) $selected = 'selected';
			else unset($selected);
			$this->rtn_year .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}

		###   display select box for month 
		for($i=01; $i < 13; $i++){
			$k = substr('0'.$i, -2);
			if($regmonth == $k) $selected = 'selected';
			else unset($selected);
			$this->rtn_month .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}

	
		###   display select box for day 
		for($i=01; $i <= 31; $i++){
			$k = substr('0'.$i, -2);
			if($regday == $k) $selected = 'selected';
			else unset($selected);
			$this->rtn_day .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}
		
		###   display select box for hour 
		for($i=0; $i < 24; $i++){
			//$k = substr('0'.$i, -2);
			if((int)$reghour == $i) $selected = 'selected';
			else unset($selected);
			$k = sprintf("%02d", $i);
			$this->rtn_hour .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}

		###   display select box for minute 
		for($i=0; $i < 60; $i++){
			
			if((int)$regmin == $i) $selected = 'selected';
			else unset($selected);
			$k = sprintf("%02d", $i);
			$this->rtn_min .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}

		###   display select box for second
		for($i=0; $i < 60; $i++){
			
			if((int)$regsec == $k) $selected = 'selected';
			else unset($selected);
			$k = sprintf("%02d", $i);
			$this->rtn_sec .= "<option value='".$k."' ".$selected.">".$k."</option>\n";
		}	
	}
	
	## 배열을 받아서 select 로 변경
	## $array : 배열정보
	## $curr : 기존 정보
	function getSelectfromArray($array, $curr){
		if (is_array($array)){
			reset($array);
			$rtn_str = "";
			foreach($array as $key => $value){
				
				$selected = $key==$curr?" selected":"";
				$rtn_str .= "<option value='".$key."'".$selected.">".$value."</option>\n";
			}
			return $rtn_str;
		}
	}

	function getSelectfromFielArray($array, $curr){
		//echo "array=".sizeof($array);
		if (is_array($array)){
			ksort($array);
			foreach($array as $key=>$value){
				$selected = $key==$curr?" selected":"";
				echo "<option value='".$key."' ".$selected.">".$value."</option>";
			}
		}
	}

	function mkselectmenu($name, $array, $select="", $arg=null){
		##$list : Array
		##$arg: array : 0: 각종 argument "style='WIDTH: 140px' onChange=this.form.submit()
		echo "<select name='".$name."' ".$arg[0].">\n";
		if (is_array($array)){
			foreach($array as $key => $value){
				$key = (string)$key;
				$selected = $key == $select ? " selected":"";
				echo "<option value='".$key."'".$selected.">".$value."</option>\n";
			}
		}
		echo "</select>\n";
	}

## 배열과 관련된 클래스
	## 배열에 특정값이 있는지 책크
	function checkStatus($value,$arr){
		if(is_array($arr)){
			if(in_array($value, $arr)){
				return true;
			}else return false;
		}else return false;
	}
	
	## 배열의 최대/최소 키값 가져오기
	
	function getkeyinArray($array, $flag="max"){
		if(is_array($array)){
			switch($flag){
				case "max":krsort($array);break;
				case "min":ksort($array);break;
			}
			return key($array);
		}
	}
	
	## 로그인 된 회원인지 책크
	## 로그인은 두단계로 크한다.
	## 현재 쿠키의 존재여부 및 파일의 존재 여부
	/*
	function is_login(){//-->getLogininfo 로 변경	
	
		if ($_COOKIE["MEMBER_INFO"]){
			$INFO = explode("|", $_COOKIE["MEMBER_INFO"]);
			if(file_exists("./config/wizmember_tmp/login_user/".$INFO[0])){
				return true;
			}else return false;
		}return false;
	}
	*/
	##문자열을 자동으로 링크걸리게 처리
	function auto_link($str){
		$str=preg_replace("~<a .*?href=[\'|\"]mailto:(.*?)[\'|\"].*?>.*?</a>~", "$1", $str);
		$str=preg_replace('/((http|mms|ftp|telnet\/\/)[^ ]+)/', '<a href="\1" target=_blank>\1</a>', $str);
		//$str=eregi_replace("[-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)+", "<a href='mailto:\\0' target=_blank>\\0</a>",$str);
		//$str=eregi_replace ("(http|mms|ftp|telnet)://[-a-z0-9]+(\.[-a-z0-9]+)*(/[^\\\*\"\<\>\| &]+(\.[^\\\*\"\<\>\| &]+)?)*/?", "<a href='\\0' target=_blank>\\0</a>",$str);
		//$str=eregi_replace ("(http|mms|ftp|telnet)://[-a-z0-9]+(\.[-a-z0-9]+)*(/([^ >]+)*)*/?", "<a href='\\0' target=_blank>\\0</a>",$str);
		return $str;
	}	

	## 문자열을 html 혹은 text type으로 출력
	## $type : 0 -> text, 1->html, 2->br테그만 입력
	function switchHtmlText($str, $type=0){//문자열출력시
		$str = stripslashes($str);
		if(trim($str)){
			switch ($type){
				case "0":
				case "txt":
				
					$str = str_replace("<", "&lt;", $str);
					$str = str_replace(">", "&gt;", $str);
					$str = str_replace("\"", "&quot;", $str);
					$str = str_replace("|", "&#124;", $str);
						
					//$str = str_replace("<", "&lt;", $str);
					//$str = str_replace(">", "&gt;", $str);
					//$str = str_replace("\"", "&quot;", $str);
					//$str = str_replace("|", "&#124;", $str);
					
					//$str = str_replace("&nbsp;", "&amp;nbsp;", $str);
					//$str = str_replace(" ", "&nbsp;", $str);//공백일경우
					//$str = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $str);//텝일경우		
					
					//$str = nl2br($str);
					##autolink관련
					if($this->autolink == 1){
						$str = $this->auto_link($str);
						$this->autolink = 0; //초기화
					}
				break;
				case "1":
				case "html":
					//$str = str_replace("&lt;", "<", $str);
					//$str = str_replace("&gt;", ">", $str);
					//$str = str_replace("&quot;", "\"", $str);
					//$str = str_replace("&#124;", "\|", $str);			
					//$str = str_replace("\r\n\r\n", "<P>", $str);
					//$str = str_replace("&#124;", "\|", $str);
					//$str = str_replace("&amp;nbsp;", "&nbsp;", $str);
				break;
				case "2":
				case "br":
					//$str = nl2br($str);	
					$str = str_replace("\r\n\r\n", "<P>", $str);
					$str = str_replace("|", "&#124;", $str);
				
				break;
			}
		}
		return $str;
	}
	
	function puttrimstr($str, $type=0){//문자열 입력
		$str = stripslashes($str);
		if(trim($str)){
			switch ($type){
				case "0":
				case "txt":
					$str = str_replace("<", "&lt;", $str);
					$str = str_replace(">", "&gt;", $str);
					$str = str_replace("\"", "&quot;", $str);
					$str = str_replace("|", "&#124;", $str);
				break;
				case "1":
				case "html":

				break;
				case "2":
				case "br":
					//$str = nl2br($str);	
					$str = str_replace("\r\n\r\n", "<P>", $str);
					$str = str_replace("|", "&#124;", $str);
				
				break;
			}
		}
		$str = addslashes($str);
		return $str;
	}
	
	function gettrimstr($str, $type=0){//문자열 출력(view페이지에 출력시 처리);
	//db에 입력시는 되도록 이함수 호출 없이 에러 처리부분만 실행한다.
		if(trim($str)){
			switch ($type){
				case "0":
				case "txt":
						
					$str = str_replace("<", "&lt;", $str);
					$str = str_replace(">", "&gt;", $str);
					$str = str_replace("\"", "&quot;", $str);
					$str = str_replace("|", "&#124;", $str);
					//$str = str_replace("\-", "&#8211;", $str);
					
					$str = str_replace("&nbsp;", "&amp;nbsp;", $str);
					$str = str_replace(" ", "&nbsp;", $str);//공백일경우
					$str = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $str);//텝일경우		
					
					$str = nl2br($str);
					##autolink관련
					if($this->autolink == 1){
						$str = $this->auto_link($str);
						$this->autolink = 0; //초기화
					}
				break;
				case "1":
				case "html":
					//$str = str_replace("&lt;", "<", $str);
					//$str = str_replace("&gt;", ">", $str);
					$str = str_replace("&quot;", "\"", $str);
					$str = str_replace("&#124;", "\|", $str);		
					$str = str_replace("&#8211;", "\-", $str);	
					$str = str_replace("\r\n\r\n", "<P>", $str);
					$str = str_replace("&#124;", "\|", $str);
					//$str = str_replace("-", "&#8211;", $str);
					$str = str_replace("&amp;nbsp;", "&nbsp;", $str);
				break;
				case "2":
				case "br":
					$str = nl2br($str);	
					//$str = str_replace("\r\n\r\n", "<P>", $str);
					//$str = str_replace("\|", "&#124;", $str);
				
				break;
			}
		}
		return $str;
	}	
	

	function gettrimstr_modify($str, $type=0){//문자열 출력(modify (텍스트 박스)시 출력
	//db에 입력시는 되도록 이함수 호출 없이 에러 처리부분만 실행한다.
		if(trim($str)){
			switch ($type){
				case "0":
				case "txt":
						
					$str = str_replace("<", "&lt;", $str);
					$str = str_replace(">", "&gt;", $str);
					$str = str_replace("\"", "&quot;", $str);
					$str = str_replace("|", "&#124;", $str);
					//$str = str_replace("\-", "&#8211;", $str);
					
					$str = str_replace("&nbsp;", "&amp;nbsp;", $str);
					$str = str_replace(" ", "&nbsp;", $str);//공백일경우
					$str = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $str);//텝일경우		
					
					//$str = nl2br($str);
					##autolink관련
					if($this->autolink == 1){
						$str = $this->auto_link($str);
						$this->autolink = 0; //초기화
					}
				break;
				case "1":
				case "html":
					//$str = str_replace("&lt;", "<", $str);
					//$str = str_replace("&gt;", ">", $str);
					$str = str_replace("&quot;", "\"", $str);
					$str = str_replace("&#124;", "\|", $str);		
					$str = str_replace("&#8211;", "\-", $str);	
					$str = str_replace("\r\n\r\n", "<P>", $str);
					$str = str_replace("&#124;", "\|", $str);
					//$str = str_replace("-", "&#8211;", $str);
					$str = str_replace("&amp;nbsp;", "&nbsp;", $str);
				break;
				case "2":
				case "br":
					$str = nl2br($str);	
					//$str = str_replace("\r\n\r\n", "<P>", $str);
					//$str = str_replace("\|", "&#124;", $str);
				
				break;
			}
		}
		return $str;
	}	
	
	
	## 문자열 속의 불량 단어 삭제(보드용)
	function searchProhibitWord($filename){
		

	}

	##본문속에 포함된 이미지를 리사이징 한다.
	function cImgResize($str, $max=600){
		$str = preg_replace("/<img(.*?)\>/","<img $1 onload=\"sizeX=".$max.";if(this.width>sizeX) {Rate=this.width/sizeX;if(Rate>0) {this.width=sizeX;this.height=this.height/Rate;}}\">",$str); 
		return $str;
	}
	
	##본문속에 포함된 이미지를 리사이징 및 원본이미지를 레이어로 띄운다.
	function cImgResizePop($str, $max=600){
		$str = preg_replace("/<img(.*?)\>/","<img $1 onload=\"sizeX=".$max.";if(this.width>sizeX) {Rate=this.width/sizeX;if(Rate>0) {this.width=sizeX;this.height=this.height/Rate;}}\" onClick=\"openImgLayer(this.src)\">",$str); 
		return $str;
	}
	
		
	## 특정시간 이전의 로그파일 삭제하기
	function delLogFile($logdir, $time=7200){
		$LOG_DIR = opendir($logdir);
		while($LOG_FILE = readdir($LOG_DIR)) {
			if($LOG_FILE !="." && $LOG_FILE !=".."){
				$logpath = $logdir."/".$LOG_FILE;
				if(is_file($logpath) && mktime() - filemtime($logpath) > $time) {
					unlink($logpath);
				}
			} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
		}

	}
	
	
	function point_fnc($id, $point, $ptype, $contents=null, $flag=0, $uid=null){
		## 포인트 내용(ptype)
		## member :1: 회원가입 ,2: 로그인포인트, 3: 회원추천->contents:추천인아이디
		## board : 11:글등록->contents(bid:gid:uid:(main/reple/ment) <!-- main:글, reple:리플, reply:댓글 , 
		## 12: 글삭제 등록양식과 동일하게처리
		## 13 : 추천(비추천) 참여시, 14 : reply, 15:reple
		## order : 21:물품구매->contents(wizCart.uid), 22:물품환불(취소)->contents(wizCart.uid), 23:포인트결제->contents:wizBuyers.OrderID, 24:포인트결제취소->contents:wizBuyers.OrderID
		## event : 기타코드-> 기타코드
		## admin : 41
		## gameinfo : 61, 
		## flag 0 : 즉시 실행, flag 1:보류(보류일경우 관리자 확인 필요, flag 6: 경험치(돈과 연관없이 커뮤니티용))
		
		$mode = $this->mode ? $this->mode : "insert";
		$wdate = time();

		if($mode == "delete"){
			## 현재 주어진 포인트의 flag를 구한다.
			$sqlstr = "select flag from wizPoint where uid = ".$uid;
			$flag = $this->dbcon->get_one($sqlstr);
			
			$sqlstr = "delete from wizPoint where uid = ".$uid;
			$this->dbcon->_query($sqlstr);
			
			## flag 의 종류에 따라 별도로 처리한다.
			switch($flag){
				case 0:
					$sqlstr = "update wizMembers SET mpoint=mpoint - ".$point." where mid = '".$id."'";
					$this->dbcon->_query($sqlstr);
				break;
				case 6:
					$sqlstr = "update wizMembers SET mexp=mexp - ".$point." where mid = '".$id."'";
					$this->dbcon->_query($sqlstr);
				break;
			}

		}else if($point){
			unset($ins);
			$ins["id"]	= $id;
			$ins["pid"]	= $uid;
			$ins["ptype"]	= $ptype;
			$ins["contents"]	= $contents;
			$ins["point"]	= $point;
			$ins["flag"]	= $flag;
			$ins["wdate"]	= $wdate;
			$this->dbcon->insertData("wizPoint", $ins);
			if($flag == 0){//포인트신청일경우: 기타 flag
				$sqlstr = "update wizMembers SET mpoint=mpoint + ".$point." where mid = '".$id."'";
				//echo $sqlstr."<br />";
				$this->dbcon->_query($sqlstr);
			}
			if($flag == 6){//경험치 인경우
				$sqlstr = "update wizMembers SET mexp=mexp + ".$point." where mid = '".$id."'";
				$this->dbcon->_query($sqlstr);
			}			
		}
	}
	
	function point_dsc($str){//포인트의 내용을 가져옮
		switch($str){
			case "1":
				$rtn_str = "회원가입";
			break;
			case "2":
				$rtn_str = "로그인";
			break;
			case "3":
				$rtn_str = "회원추천";
			break;
			case "11":
				$rtn_str = "글등록";
			break;
			case "21":
				$rtn_str = "물품구매";
			break;
			case "31":
				$rtn_str = "감사";
			break;										
		}
		return $rtn_str;
	}

	public function getLogininfo(){//회원정보분리하여 가져오기
		$pub_path = $this->pub_path ? $this->pub_path : "./";
		$savepath = $pub_path."config/wizmember_tmp/login_user";
		if($_COOKIE["usersession"]){//로그인 정보가 있으면
			$login_file = $savepath."/".$_COOKIE["usersession"];
			if(is_file($login_file)){
				touch($login_file);
				$info	= file($login_file);
				$cfg	= unserialize($info[0]);
				return $cfg;
			}else{
				return false;
			}			
		}else{
			return false;
		}
	}

	function log_out(){
		$pub_path = $this->pub_path ? $this->pub_path : "../";
		if(!$_COOKIE["usersession"]){
			$this->js_alert("\\n\\n손님께서는 로그인되어있지 않습니다.\\n\\n");
		}else{//로그인파일 삭제 및 각종 쿠키 세션삭제
			if (is_file($pub_path."config/wizmember_tmp/login_user/".$_COOKIE["usersession"])){
				unlink($pub_path."config/wizmember_tmp/login_user/".$_COOKIE["usersession"]);
			}
			if (is_file($pub_path."config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"])){
				unlink($pub_path."config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"]);
			}
			setcookie("usersession", "", 0, "/");
		}
	}

	##$str : 원본글자 $len : 자를 글자수, $abb : 줄임표시
	## 예)$subject = strCutting($subject, "25", "..");
	## type : euc-kr //기본적으로 lib/$cfg["common"]["lan"]불러옮
	/*function strCutting($str, $len, $suffix="", $type="UTF-8") { 
		$str = strip_tags($str);
		$s = substr($str, 0, $len); 
		$cnt = 0; 
		for ($i=0; $i<strlen($s); $i++) if (ord($s[$i]) > 127) $cnt++; 
		if (strtoupper($type) == 'UTF-8'){ 
			if ($this->CheckChar($s)==TRUE){ 
				$s = substr($s, 0, ($len/1.8) - ($cnt % 3)); 
			}else{ 
				$s = substr($s, 0, $len - ($cnt % 3)); 
			} 
		}else{ 
			$s = substr($s, 0, $len - ($cnt % 2)); 
		} 
		if (strlen($s) >= strlen($str)) $suffix = ""; 
		return $s . $suffix;
	} 
	*/

	
	function strCutting( $str, $len, $abb="..", $type=null){
		## type:utf-8 or euc-kr
		if($type==null) $type = $this->cfg["common"]["lan"];
		switch($type){
			case "euc-kr":
				$str  = trim( $str ); 
				$KOR = 0;
				$ENG = 0;
				for( $i=0 ; $i < $len ; $i++ ){ 
					if( ord( $str[$i] ) >= 128 ){
						$KOR++;
					}else{
						$ENG++;
					} 
				} 
				if( strlen( $str ) > $len ){ 
					if( $KOR % 2 == 1 ){ 
						$len = $len - 1; 
					} 
					$rtn_str = substr( $str , 0 , $len ); 
					return $rtn_str.$abb; 
				}else {
					$rtn_str = substr( $str , 0 , $len ); 
					return $rtn_str; 
				}
			break;
			default:
				$checkmb = false;
				//preg_match_all('/&#\d+;|./u',$str,$match);  //일본어 자를 때 사용
				preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
				$m    = $match[0];
				$slen	= strlen($str);  // length of source string
				$tlen = strlen($abb); // length of tail string
				$mlen = count($m);     // length of matched characters

				if ($slen <= $len) return $str;
				if (!$checkmb && $mlen <= $len) return $str;

				$ret   = array();
				$count = 0;

				for ($i=0; $i < $len; $i++) {
				$count += ($checkmb && strlen($m[$i]) > 1)?2:1;

				if ($count + $tlen > $len) break;
				$ret[] = $m[$i];
				}

				return join('', $ret).$abb;
			break;
		}
	}

	## 글자뒤부터 $cnt 갯수만큼 *(별표) 표시로 나타나게 하는 함수
	## changeToaster($str, 2);
	function changeToaster($str, $cnt){
		$str = strip_tags($str);
		$asterisk = "";
		for($i=0; $i<$cnt; $i++){
			$pos =  strlen($str)-1;
			if (ord($str[$pos]) > 127) {//2byte 짜르고 *
				$str = substr($str, 0, -2);
			}else{//1byte 짜르고 *
				$str = substr($str, 0, -1);
			}
			$asterisk .="*";
		}
		return $str.$asterisk; 
	}

	// 영문인지 아닌지 판단
	function CheckChar( $strChar ) { 
	//   글자를 바이너리 10000000 과 비트 AND 연산후 10000000이 되는지를 검사. 
	return ( ($strChar & chr(128)) == chr(128) ) ? FALSE : TRUE; 
	} 

	## 첨부화일의 이미지 불러오기
	## $common->filepath = "./config/wizboard/table/$UpdirPath/updir/";
	## $common->$width; 디스플레이 넓이
	## $common->$height; 디스플레이 높이
	## $common->filename = explode("|",$attached);//배열값
	function ViewMultiContents($filename){
		//$UpdirPath = $this->gid."/".$this->bid;
		//$attachedFile=explode("|",$attached);
	#"gif","GIF","jpg","JPG","jpeg","JPEG","png","PNG"
		//$viewExtention = ".jpg.jpeg.gif.bmp.png";

		$cnt=0;
		for($i=0; $i<count($filename); $i++){
			$filepath				= $this->filepath.$filename[$i];
			$View_Pic_Size	= $this->TrimImageSize($filepath,$this->width);
			$extention			= $this->getextention($filename[$i]);
			switch($extention){
				case "jpg":
				case "jpeg":
				case "gif":
				case "bmp":
				case "png":
					$viewAttachedImg[$cnt]			= "<img src='".$filepath."' ".$View_Pic_Size."> ";
					$viewAttachedfilepath[$cnt]	= $filepath;
					$cnt++;	
				break;
				case "swf":
					$viewAttachedImg[$cnt] = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0' >
					  <param name='movie' value='".$filepath."' />
					  <param name='quality' value='high' />
					  <embed src='".$filepath."' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash'></embed>
					</object>";
					$viewAttachedfilepath[$cnt]	= $filepath;
					$cnt++;	
				break;
				case "wav":
				case "mp3":
					$viewAttachedImg[$cnt] = "<bgsound src='".$filepath."'> ";
					$viewAttachedfilepath[$cnt]	= $filepath;
					$cnt++;	
				break;	
				case "asf":
				case "asx":
				case "avi":
				case "wmv":
				case "wma":
					$viewAttachedImg[$cnt] = "<OBJECT ID='MPlay2' CLASSID='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6' standby='Loading Windows Media Player components...' width='320' height='304'>
						<PARAM NAME='URL' VALUE='".$filepath."'>
						<PARAM NAME='AutoStart' VALUE='True'>
						<PARAM NAME='UIMode' VALUE='full'>
						</OBJECT>";
					$viewAttachedfilepath[$cnt]	= $filepath;
					$cnt++;	
				break;						
			}
		}
		$this->viewAttachedImg			= $viewAttachedImg;
		$this->viewAttachedfilepath		= $viewAttachedfilepath;
	}

	function showFolderList($targetdir, $sel){
		$open_dir = opendir($targetdir);
		while($opendir = readdir($open_dir)) {
			if(($opendir != ".") && ($opendir != "..") && is_dir($targetdir."/".$opendir)) {
				$selected = strcmp($sel,$opendir)?"":"selected";
				echo "<option value=\"".$opendir."\" ".$selected.">".$opendir." 스킨</option>\n";
			}
		}
		closedir($open_dir);
	}

	function showFileList($targetdir, $sel){
		$open_file = opendir($targetdir);
		$i=0;
		while($opendir = readdir($open_file)) {
			if(($opendir != ".") && ($opendir != "..") && is_file($targetdir."/".$opendir)) {
				$fileArr[$i] = $opendir;
				$i++;
			}
		}
		closedir($open_file);
		
		asort ($fileArr);
		reset ($fileArr);
		while (list ($key, $val) = each ($fileArr)) {
			$selected = strcmp($sel,$val)?"":"selected";
			echo "<option value=\"".$val."\" ".$selected.">".$val."</option>\n";
		}
	}
	function TrimImageSize($filepath, $size){
		if (is_file($filepath)){
			list($width, $height, $type, $attr) = getimagesize($filepath);
			if($width > $size ) $width = $size;
			if($height > $size ) $height = $size;
			if($width < $height) $View_Pic_Size = "height='".$height."'";
			else $View_Pic_Size = "width='".$width."'";
			return $View_Pic_Size;
		}	
	}

	function getencode($data, $err=0) {//get 방식으로 보내지는 인자값을 encode
		if($err == 1) echo $data;
		return $this->base64_url_encode($data);
	}

	function getdecode($data){//get 방식으로 전송된 인자값을 decode
		if($data){
			$exp=explode("&",$this->base64_url_decode($data));
			for($i=0;$i<count($exp);$i++) {
				$value=explode("=",$exp[$i]);
				$var[$value[0]]=$value[1];
			}
		}
		return $var;
	}

	function my_filesize($filepath) {
		//echo "filepath = $filepath <br>";
		// 파일 존재유무 책크
		if(is_file($filepath)){
			// 일반적인 파일 사이즈 단위를 설정한다.
			$kb = 1024;         // Kilobyte
			$mb = 1024 * $kb;   // Megabyte
			$gb = 1024 * $mb;   // Gigabyte
			$tb = 1024 * $gb;   // Terabyte
			// byte단위의 파일을 가져온다.
			$size = filesize($filepath);
			###   만약 파일이 kb(키로바이트)보다 적으면 그 값을 그대로 리턴하고 아니면 적당한 파일단위를 붙인다.
			if($size < $kb) {
				return $size." B";
			}else if($size < $mb) {
				return round($size/$kb,2)." KB";
			}else if($size < $gb) {
				return round($size/$mb,2)." MB";
			}else if($size < $tb) {
				return round($size/$gb,2)." GB";
			}else {
				return round($size/$tb,2)." TB";
			}
		}else{
			return " 0 B";
		}
	}

	function getextention($filename, $flag=1){##flag 0 : 바로 변경 flag 1 : decode후 변경
		if($flag == 0){
			$extention = strtolower(substr(strrchr($filename, "."), 1));
		}else{
			$decode_filename = $this->getImgName($filename);
			$extention = strtolower(substr(strrchr($decode_filename, "."), 1));
		}
		return $extention;
	}

	function gettotal($str){
		## 하기 페이징 관련 total 구하기
		$total = $this->dbcon->get_one($str);
		$this->pagingtotal = $total;//내부용
		return $total;
	}

	function paging($params){//일단 관리자 처리후 common에 페이징 관련 넣어 상속 받는 것으로 처리 예정

		$url		= $params["url"];//"menushow=$menushow&theme=$theme&category=$category&sorting=$sorting&OptionList=$OptionList";
		$pre		= $params["pre"];///img/pre.gif"
		$next		= $params["next"];///img/next.gif"
		$pre0		= $params["pre0"];///img/pre.gif"
		$next0		= $params["next0"];///img/next.gif"
		$pagetype	= $params["type"];
		
		##$head = 
		##$arg = array("listno","pageno","cp","total"); 
		##$img = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
		##$att 기타 각종 옵션 설정 : $att[0]: type 설정 , $att[0] = 1 :이전다음글이 없을 경우 아이콘 숨김:
		$listno			= $params["listno"] ? $params["listno"] : 20;
		$pageno			= $params["pageno"] ? $params["pageno"] : 20;
		$cp				= $params["cp"];
		$total			= $params["total"] ? $params["total"]:$this->pagingtotal;
		
		
		//$img["pre0"]	= $img["pre"] && $img["pre0"] ? $img["pre0"]:$img["pre"];
		//$img["next0"]	= $img["next"] && $img["next0"] ? $img["next0"]:$img["next"];
		
		//이전 다음 있을 경우
		//$img_pre	= $img["pre"] ? "<img src='".$img["pre"]."' hspace='3' border='0' class='first'>":"◀";
		//$img_next	= $img["next"] ? "<img src='".$img["next"]."' hspace='3' border='0' class='goToPrev'>":"▶";
		//매처음 혹은 맨 뒤쪽일경우
		//$img_pre0	= $img["pre0"] ? "<img src='".$img["pre0"]."' hspace='3' border='0' class='next'>":"◁";
		//$img_next0	= $img["next0"] ? "<img src='".$img["next0"]."' hspace='3' border='0' class='goToLast'>":"▷";
		
		$return = "";

		 //--페이지 나타내기--
		$TP = ceil($total / $listno) ; ###   페이지 하단의 총 페이지수 
		$CB = ceil($cp / $pageno);
		$SP = ($CB - 1) * $pageno + 1;
		$EP = ($CB * $pageno);
		$TB = ceil($TP / $pageno);
		
		switch($pagetype){	
			/*			
			case "gameinfo"://처음페이지와 맨나중 페이지로 이동 하는 것 추가
				
				# 1페이지로 이동
				$return .= "<a href='$url&cp=1' class='goToFirst'>".$img_pre0."</a>";
								
				if ( $CB > 1 ) {
				$PREV_PAGE = $SP - 1;
					$page = $SP - 1;
					$return .= "<a href='$url&cp=$page'  class='goToPrev'>".$img_pre."</a>";
				} else $return .= $img_pre;

				###   LISTING NUMBER PART
				for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
					$class = $cp == $i ? "class='menuActive'" : "";
					$return .= " <span><a href='$url&cp=$i' $class >$i</a></span> ";
				}
				###   NEXT or END PART 
				if ($CB < $TB) {
					$page = $EP + 1;
					$return .= "&nbsp;<a href='$url&cp=$page' class='goToNext'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next;
				}
				## 마지막 페이지로 이동
				$return .= "<a href='$url&cp=$TP' class='goToFirst'>".$img_next0."</a>";
			break;
			*/
			case "script"://본문에 gotoPage javascrpt 처리
				if ( $CB > 1 ) {
					$page = $SP - 1;
					$return .= "<a href='javascript:gotoPage(".$page.")'>".$img_pre."</a>";
				} else $return .= $img_pre0;
		
				###   LISTING NUMBER PART 
				for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
					if($cp == $i) $NUMBER_SHAPE= "<font color = 'gray'><B>".$i."</B></font>";
					else $NUMBER_SHAPE="<font color = 'gray'>".${i}."</font>";
					$return .= "&nbsp;<a href='javascript:gotoPage(".$i.")'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART 
				if ($CB < $TB) {
					$page = $EP + 1;
					$return .= "&nbsp;<a href='javascript:gotoPage(".$page.")'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next0;
				}
				break;
			case "mall":
				###   PREVIOUS or First 부분 
				if ( $CB > 1 ) {
				$PREV_PAGE = $SP - 1;
					$page = $SP - 1;
					$return .= "<a href='".$url."&cp=".$page."'>".$img_pre."</a>";
				} else $return .= $img_pre0;

				###   LISTING NUMBER PART
				for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
					if($cp == $i){$NUMBER_SHAPE= "<strong>[".$i."]</strong>";}
					else $NUMBER_SHAPE="[".$i."]";
					$return .= "&nbsp;<a href='".$url."&cp=".$i."'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART 
				if ($CB < $TB) {
					$page = $EP + 1;
					$return .= "&nbsp;<a href='".$url."&cp=".$page."'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next0;
				}
					$return .= "/ <font color='#FF0000'>Total</font> <font color='#000000'>[".$total."]</font> ";  
			
			break;
			case "bootstrappost":
				$return = '<ul class="pagination">';
				
				if ( $CB > 1 ) {
					$page = $SP - 1;
					$return .= "<li><a href='javascript:gotoPage(".$page.")'>&laquo;</a></li>";
				} else $return .= '<li class="disabled"><a href="#">&laquo;</a></li>';
		
				###   LISTING NUMBER PART 
				for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
					
					$activeclass = $cp == $i ?' class="active"':'';
					$return .= "<li".$activeclass."><a href='javascript:gotoPage(".$i.")'>".$i."</a></li>";
				}
				###   NEXT or END PART 
				if ($CB < $TB) {
					$page = $EP + 1;
					$return .= "<li><a href='javascript:gotoPage(".$page.")'>&raquo;</a></li>";
				} else {
					$return .= '<li class="disabled"><a href="#">&raquo;</a></li>';
				}
				
				$return .= "</ul>";
			break;	
				
			default:
				if ( $CB > 1 ) {
					$page = $SP - 1;
					$return .= "<a href='".$url."&cp=".$page."'>".$img_pre."</a>";
				} else $return .= $img_pre0;
		
				###   LISTING NUMBER PART 
				for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
					if($cp == $i) $NUMBER_SHAPE= "<font color = 'gray'><B>".$i."</B></font>";
					else $NUMBER_SHAPE="<font color = 'gray'>".${i}."</font>";
					$return .= "&nbsp;<a href='".$url."&cp=".$i."'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART 
				if ($CB < $TB) {
					$page = $EP + 1;
					$return .= "&nbsp;<a href='".$url."&cp=".$page."'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next0;
				}
			break;
		}
		return $return;
	}

	function getorderby($orderby){
		## $orderby: 필드명@asc or desc
		$tmp = explode("@", $orderby);
		$order = "order by ".$tmp[0]." ".$tmp[1];
		return $order;
	}


	function getbanner($flag, $width=null, $height=null, $path="./", $cnt=null){
		$sqlstr = "select uid, target, attached, url, subject from wizbanner where flag1='".$flag."' order by uid desc";
		if($cnt) $sqlstr .= " limit 0,".$cnt;
		$sqlqry = $this->dbcon->_query($sqlstr);
		$filepath = $path."config/banner/";
		if($width) $width = "width='".$width."'";
		if($height) $height = "height='".$height."'";
		$cnt=0;
		while($list = $this->dbcon->_fetch_array($sqlqry)):
			extract($list);
			$subject = $subject != "" ? str_replace("'", "", $subject):"베너이미지";
			$banner[$cnt] = "";
			if($url) $banner[$cnt] = "<a href='".$path."lib/out.banner.php?uid=".$uid."' target='".$target."'>";
			$banner[$cnt] .= "<img src='".$path."config/banner/".$attached."' ".$width." ".$height." border='0' alt='".$subject."' class=\"img-thumbnail\">";
			if($url) $banner[$cnt] .= "</a>";
			$cnt++;
		endwhile;
		return $banner;
	}

	//넘어온 두개의 배열을 key와 value로 나타낸다
	function arraycombine($arr1, $arr2) {//array_combine()은 php 5.0에서 지원하므로 대처할 수 있는 프로그램으로 변경
		$out = array();
		$arr1 = array_values($arr1);
		$arr2 = array_values($arr2);
		foreach($arr1 as $key1 => $value1) {
			$out[(string)$value1] = $arr2[$key1];
		}
		return $out;
	}

	function filedownload($url, $filename){
		//http://mall.shop-wiz.com/malladmin/download.php?filename=/../../../../../../../../../../etc/passwd
		$url = substr($url, -1) == "/" ? $url:$url."/";
		$downfilename = $this->base64_url_decode($filename);
		$filename = str_replace(" ", "+", $filename);
		$fullpath = $url.$filename;
		$filename = $this->base64_url_decode($filename);//파일명을 원래 파일로 변경
		$filename = basename($filename);
		$fullpath = str_replace("../../", "", $fullpath);

		$pattern = array("..../", ".../", "%2F", "..\"", "..%5C");
		foreach($pattern as $val){
			$is	= strpos($fullpath, $val);
			if($is){
				echo "잘못된 경로로 접근하였습니다.(1)";
				exit;
			}
		}

		$downpath = array("../config/wizboard/table/", "../config/uploadfolder/etc/");
		$pass	= false;
		foreach($downpath as $val){
			$pos	= strpos($fullpath, $val);
			if($pos === 0){
				$pass	= true;
				break;
			}
		}

		if($pass === false){
			echo "잘못된 경로로 접근하였습니다.";
			exit;
		}

	
		if(strrchr($filename, "/"))$filename = str_replace("/", "",strrchr($filename, "/"));//보안을 위해 상위경로는 삭제한다.
		//if(strrchr($fullpath, "/"))$fullpath = str_replace("/", "",strrchr($fullpath, "/"));//보안을 위해 상위경로는 삭제한다.
		$dn = 1; 							// 1 이면 다운, 0 이면 브라우져가 인식하면 화면에 출력 
		$dn_yn = ($dn) ? "attachment" : "inline"; 

		$bin_txt = 1; 						// 아스키면 r, 바이너리면 rb
		$bin_txt = ($bin_txt) ? "r" : "rb";	
		//echo "filename:"+$filename."<br>";
		$filename = urlencode($filename);

		$agent = preg_split("/[( ; )]+/", $_SERVER["HTTP_USER_AGENT"]);
		//익스계열에서 한글파일 깨짐 현상
		//if(eregi("(MSIE 5.5|MSIE 6.0|MSIE 7.0|MSIE 8.0)", $_SERVER["HTTP_USER_AGENT"])
        //                && !eregi("(Opera|Netscape)", $_SERVER["HTTP_USER_AGENT"])) {
        //        $filename = iconv("UTF-8", "EUC-KR", $filename);


		switch(true){
			case in_array("Mozilla/4.0", $agent):
			case in_array("MSIE", $agent):
			case in_array("Windows", $agent):
			case in_array("InfoPath.2", $agent):
			case in_array(".NET", $agent):
				header("Content-type: application/octet-stream"); 
			//header("Content-Type: doesn/matter"); 
				header('Cache-Control: private');//IE에서 첨부파일 다운로드후 캐시폴더에서 실행시 cache-control 문제
				header("Content-Length: ".filesize($fullpath));   		// 이 부분을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다. 
				//header("Content-Disposition: ".$dn_yn."; filename=".$downfilename);   
				//header("Content-Disposition: ".$dn_yn."; filename=".conv_CP949($downfilename));
				header("Content-Disposition: ".$dn_yn."; filename=".iconv("UTF-8","CP949",$downfilename));//나중에 이부분은 별도 처리
				header("Content-Transfer-Encoding: binary");   
				header("Pragma: no-cache");   
				header("Expires: 0");   
			break;
			default:
				header("Content-type: file/unknown");     
				//header('Cache-Control: private');//IE에서 첨부파일 다운로드후 캐시폴더에서 실행시 cache-control 문제
				header("Content-Length: ".filesize($fullpath)); 
				header("Content-Disposition: ".$dn_yn."; filename=".$downfilename); 
				header("Content-Description: PHP Generated Data"); 
				header("Pragma: no-cache"); 
				header("Expires: 0"); 
			break;
		}

		$fp = fopen($fullpath, $bin_txt); 
			//echo "fullpath =  $fullpath <br>";
		if (!fpassthru($fp))  						// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이... 
		fclose($fp); 
	}
	
	function insertMeberLog($userid, $pid, $tb_name){
		unset($ins);
		$ins["userid"]	= $userid;
		$ins["pid"]		= $pid;
		$ins["tb_name"]	= $tb_name;
		$ins["wdate"]	= time();
		$this->dbcon->insertData("wizMembers_log", $ins);		
	}
	
	/**
	 * 
	 * 
	 * 	정대경로 사용시 예제 $filepath = $_SERVER["DOCUMENT_ROOT"]."/config/";
	 * <?php echo $common->getthumbimg($filepath, $filename, 150, 113, null, true) ?>
	 */
	function getthumbimg($spath, $simg, $width, $height, $noimg=null, $abspath=false){
		ini_set("memory_limit" , -1);
		#$spath : 소스경로(/로 마무리), $simg(소스파일명), $width: thumb width, $height thumb height
		//$abspath가  true 일 경우 $spath에는 document_root를 이용하여 위치 지정
		$sourcefilepath = $spath.$simg;

		//echo "sourcefilepath:".$sourcefilepath."<br/>";
		if(is_file($sourcefilepath)){
			$thumpath = $spath."thumb/".$width."_".$height;
			$thumfullpath = $spath."thumb/".$width."_".$height."/".$simg.".thumb";
			if(is_file($thumfullpath)){//thumb 파일이 있으면 출력 없으면 생성
				return $abspath ? substr($thumfullpath, strlen($_SERVER["DOCUMENT_ROOT"])):$thumfullpath;	
			}else{
				$thumfilename = $simg.".thumb";
				$this->mkfolder($spath."thumb");
				$this->mkfolder($spath."thumb/".$width."_".$height);
				$this->Image->thumnail($sourcefilepath, $thumpath, $width, $height, $thumfilename);
				return $abspath ? substr($thumfullpath, strlen($_SERVER["DOCUMEMT_ROOT"])):$thumfullpath;	
			}
		}else{
			return $noimg;
			//노이미지 출력
		}
	}
	
	## lib/cfg.common.php의 설정에 따라 이곳 설정을 연동
	function mksqlpwd($str, $type="mempwd"){
		switch($type){
			case "mempwd":
				if($this->cfg["common"]["mempwd"] == "PASSWORD"){
					$sqlstr = "select PASSWORD('".$str."')";
					$rtn = $this->dbcon->get_one($sqlstr);
				}else $rtn = $str;
			break;
			case "memjumin":
				if($this->cfg["common"]["memjumin"] == "PASSWORD"){
					$sqlstr = "select PASSWORD('".$str."')";
					$rtn = $this->dbcon->get_one($sqlstr);
				}else $rtn = $str;
			break;
			
		}
		return $rtn;
	}
	
	function delallfile($path, $attached){//현재 경로이후의 thumb 파일들을 책크하여 모두 삭제한다.
		//$path는 "path/" 형태로 뒤에 "/"있는 형태로 넘어옮
		$path = substr($path, -1) == "/" ?  $path : $path."/";
		if($attached){
			@unlink($path.$attached);
			$folder = $path."thumb";
			if(is_dir($folder)){
				while($thumbfolder = readdir($folder)){
					if ($thumbfolder == '.' || $thumbfolder == '..') continue;
					@unlink($folder.$thumbfolder."/".$attached.".thumb");
				}
			}
		}
	}
	
	function viewdate($format, $time){
		if($time > 0) return date($format, $time);
	}
	
	function getWeekstr($w=null,$format="kor"){
		if($w == null) $w = date("w");
		switch($w){
			case "0":
				$str = "일";
			break;
			case "1":
				$str = "월";
			break;
			case "2":
				$str = "화";
			break;
			case "3":
				$str = "수";
			break;
			case "4":
				$str = "목";
			break;
			case "5":
				$str = "금";
			break;
			case "6":
				$str = "토";
			break;																		
		}
		return $str;
	}
	
	function getmod($arg1, $arg2){## 나누기
		$rtn = 0;
		if($arg1 && $arg2){
			$rtn = $arg1 / $arg2;
		}
		return $rtn;
	}
	
	function linkurl($url){//현재 링크를 받아와서 실질적인 url 링크로 변경
		if(substr($url, 0, 4) != "http") $url = "http://".$url;
		return $url;
	}

	function convi($str){
		return iconv("UTF-8", "EUC-KR", $str);
	}

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
	
	function conv_CP949($str){//익스플로러에서 한글 다운로드시 깨짐 현상 방지를 위해
		if(iconv("UTF-8","UTF-8",$str) == $str){
			return iconv("UTF-8","CP949",$str);
		}else if(iconv("EUC-KR","EUC-KR",$str) == $str){
			return iconv("EUC-KR","CP949",$str);
		}
	}

	function stringToEntity($string) 
	{ 
		$string = str_replace("'", "&#39;", $string); 
		$string = str_replace("\"", "&#34;", $string); 
		return $string; 
	} 	

	function securityguard($str, $type="1"){
		$rtn = false;
		switch($type){//인클루드경로에 변수 사용시 보안처리
			case "1":
				if(preg_match("/(http|ftp|\.\.|\/)/i", $str)){
					$rtn = true;
				}
			break;

		}
	return $rtn;
	}

	function RemoveXSS($val) { 
		// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
		// this prevents some character re-spacing such as <javascript> 
		// note that you have to handle splits with n, r, and t later since they *are* allowed in some inputs 
		$val = preg_replace('/([x00-x08][x0b-x0c][x0e-x20])/', '', $val); 

		// straight replacements, the user should never need these since they're normal characters 
		// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
		$search = "abcdefghijklmnopqrstuvwxyz"; 
		$search .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		$search .= "1234567890!@#$%^&*()"; 
		//$search .= '~`";:?+/={}[]-_|'\'; 
		for ($i = 0; $i < strlen($search); $i++) { 
			// ;? matches the ;, which is optional 
			// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 

			// &#x0040 @ search for the hex values 
			$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
			// @ @ 0{0,7} matches '0' zero to seven times 
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
		} 

		// now the only remaining whitespace attacks are t, n, and r 
		$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
		$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
		$ra = array_merge($ra1, $ra2); 

		$found = true; // keep replacing as long as the previous round replaced something 
		while ($found == true) { 
			$val_before = $val; 
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
				$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
				if ($val_before == $val) { 
					// no replacements were made, so exit the loop 
					$found = false; 
				} 
			} 
		} 
		return $val; 
	}

	function base64_url_encode($str){
		return strtr(base64_encode($str), '+/=', '-_,');
	}

	function base64_url_decode($str){
		return base64_decode(strtr($str, '-_,', '+/=')); 
	}


	/**
	 *  기호화된 성별을 받아서 남/녀 문자로 변경
	 */
	public function gendertoString($gender, $arr){//$arr 에 jumin2 혹은 ci, di결과 생년월일등이 올 수 있슴
		
		$jumin2 = $arr["jumin2"];
		if(!$gender && $jumin2){
			$genderno = substr($jumin2,0,1);
			if($genderno == 1 || $genderno == 3) $gender = "1";
			else if($genderno == 2 || $genderno == 4) $gender = "2";
		}	


		switch($gender){
			case "1":$rtn = "남";break;
			case "2":$rtn = "여";break;
			default:$rtn = "";break;
		}
		return $rtn;
	}
	
	
	/**
	* 로그파일생성
	*/
	function saveLog( $str, $file="./config/log"){
		$fp = fopen($file, "w+"); 
		fwrite($fp,$str); 
		fclose($fp); 
	}
	
	/**
	 * CSRF 공격 대비 
	 */
	 public function getcsrfkey($value='')
	 {
	 	
		if($_SESSION["csrf"]){
			$key	= $_SESSION["csrf"];
		}else{
			$key = sha1(microtime());
			$_SESSION['csrf'] = $key;
		}
		
		return $key;
	 }
	 
	 public function checsrfkey($csrf){
	 	if($csrf != $_SESSION['csrf']){
	 		$this->js_alert("csrf attack detected..");
	 		return false;
	 	}else{
	 		return true;
		}
	 }
	 
	 /**
	  * hidden 값 생성
	  */
	  public function addhiddenfield($str, $arr){
	  	$hidden = explode(",",$str);
		if(is_array($hidden)) foreach($hidden as $key=>$val){
			echo "<input type=\"hidden\" name=\"".$val."\" value=\"".$arr[$val]."\" />\n";
		}
	  	
	  }
	  
	  /**
	   * get값 붙이기
	   */
		public function addgetfield($str, $arr){
			$get = explode(",",$str);
			$string = "";
			if(is_array($get)) foreach($get as $key=>$val){
				$string .=  "&".$val."=".$arr[$val];
			}
			echo $string;
		}

	  /**
	   * 변수명을 리턴해주는 프로그램
	   */
		private function varName( $v ) {
			$trace = debug_backtrace();
			$vLine = file( __FILE__ );
			$fLine = $vLine[ $trace[0]['line'] - 1 ];
			preg_match( "#\\$(\w+)#", $fLine, $match );
			    print_r( $match );
		}
        
        
        /**
         * 생년월일을  yyyy mm dd로 나누어 처리
         */
         public function splitDate($yyyymmdd){
            $rtn[0] = substr($yyyymmdd, 0, 4);
            $rtn[1] = substr($yyyymmdd, 4, 2);
            $rtn[2] = substr($yyyymmdd, 6, 2);
            return $rtn;
         } 

        /** json  인지 아닌지 체크 **/
        public function isJson($string) {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }
        
        /**
         * 위즈몰의 레이아웃 스킨을 가져온다.(기존 여러단계로 분할하여 사용하던것을 top, bottom으로 통일하여 사용)
         * 
         * @param $pos : top : 상단레이아웃, bottom : 하단레이아웃, null : 레이아웃 없음, 
         * @param $path : 레이아웃 위치, $path가 별도로 존재하지 않으면 관리자에서 세팅된 레이아웃을 가져온다.
         */
       public function layoutskin($pos=null, $path=null){
            if($pos != null && $path == null){//관리자에서 세팅한 레이아웃 정보를 가져온다.
                
            }
            
        }

        
                
			
    }//end of Class

    
    
    
    
/** 과거버젼에 없는 함수들 재 정의  **/
if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}