<?php
## update : 09.05.25 gamech 용으로 별도 함수 생성
class admin{
	
	var $dbcon;//db connect 관련 외부 클라스 받기
	var $dbcons;//db connect 관련 외부 클라스 받기(slave);
	var $common;//db connect 관련 외부 클라스 받기
	var $mall;//db connect 관련 외부 클라스 받기
	var $cfg;//외부 $cfg 관련 배열

## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null, &$mall=null){//db_connection 함수 불러오기
		$this->dbcon	= &$dbcon;
		$this->common	= &$common;
		$this->mall		= &$mall;
	}
	
##################################################################################
##################################################################################

	function dirSelect($path){
		$CurrentPath = $this->select;
		$dirPath = opendir($path);
			while($dir = readdir($dirPath)) {
				if(($dir != ".") && ($dir != "..")) {
					$selected = $CurrentPath == $dir ? "selected":"";
					echo "<option value=\"".$dir."\" ".$selected.">".$dir."</option>\n";
				}
			}
		closedir($path);
	}
	
	function MultiInsert($uid, $category){
		## 멀티로 등록된 카테고리 정보가져와서 카운트 삭제하기
		$sqlstr = "SELECT Category FROM wizMall WHERE PID='".$uid."' and PID <> UID";
		$qry = $this->dbcon->_query($sqlstr);
		while($list = $this->dbcon->_fetch_array($qry)){
			$Category = $list["Category"];
			$this->mall->insertPdCnt($Category, "delete");
		}	

		$sqlstr = "delete from wizMall where PID <> '' and PID = '".$uid."' and PID <> UID";
		$this->dbcon->_query($sqlstr);
		
		$categoryArr = explode("|", $category);
		for($i=0; $i < sizeof($categoryArr); $i++){
			if($categoryArr[$i]){
			    unset($ins);
                $ins["PID"]         = $uid;
                $ins["Category"]    = $categoryArr[$i];
				$this->dbcon->insertData("wizMall", $ins);
                
				$this->mall->insertPdCnt($categoryArr[$i]);
			}
		}
	}
	

	function pd_img_up($mode="insert", $file, $category, $copyimg, $c_category=null, $uid=null){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## $copyimg: 카피파일 Array. 1: 작은이미지 만들기, 2, 중간이미지 만들기
		## c_category : 수정일 경우 기존 카테고리 $uid : 기존 상품 uid

		## 저장될 카테고리 생성
		$this->common->mkfolder("../config/uploadfolder");
		$this->common->mkfolder("../config/uploadfolder/productimg");
		$this->common->mkfolder("../config/uploadfolder/productimg/".substr($category, -3));
		$this->common->upload_path = "../config/uploadfolder/productimg/".substr($category, -3);
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			//echo "file = ".$file." <br>";
			//print_r($file);
			$this->common->uploadfile($file);
		}else if($mode == "update"){
			$this->common->getProductImgList($uid);//기존 상품을 가져온다.($this->oldfilename .= $tmp[$i]."|";)
			$this->common->moveProductImg($c_category, $category);//카테고리가 변경될 경우 파일 이미지도 위치 변경
			$this->common->uploadmode = "update";
			$this->common->uploadfile($file);//배열로서 전달됨
		}
		$rtnfile = $this->common->returnfile;
		//print_r($rtnfile);
		//exit;
				#워터마크 시작
		if($rtnfile[3]) $this->mkwatermark($rtnfile[3]);
		if($rtnfile[4]) $this->mkwatermark($rtnfile[4]);
		if($rtnfile[5]) $this->mkwatermark($rtnfile[5]);
		if($rtnfile[6]) $this->mkwatermark($rtnfile[6]);
		if($rtnfile[7]) $this->mkwatermark($rtnfile[7]);
		if($rtnfile[8]) $this->mkwatermark($rtnfile[8]);
		if($rtnfile[9]) $this->mkwatermark($rtnfile[9]);
		if($rtnfile[10]) $this->mkwatermark($rtnfile[10]);
		if($rtnfile[11]) $this->mkwatermark($rtnfile[11]);
		if($rtnfile[12]) $this->mkwatermark($rtnfile[12]);
		
		if($copyimg[1] == "1" )$rtnfile[1] = $this->mkthumnail($rtnfile[0],100,100);
		if($copyimg[2] == "1" )$rtnfile[2] = $this->mkthumnail($rtnfile[0],300,300);
		
		## rtnfile 0 : 큰이미지, 1:작은이미지, 2:중간이미지
		return $rtnfile;
	}

// 아래부터는 금번 프로젝트 용 시작
	function game_img_up($mode="insert", $file, $category, $copyimg, $c_category=null, $uid=null){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## $copyimg: 카피파일 Array. 1: 작은이미지 만들기, 2, 중간이미지 만들기
		## c_category : 수정일 경우 기존 카테고리 $uid : 기존 상품 uid

		## 저장될 카테고리 생성
		$this->common->mkfolder("../config/uploadfolder");
		$this->common->mkfolder("../config/uploadfolder/game");
		$this->common->upload_path = "../config/uploadfolder/game";
		
		//echo $this->common->upload_path;
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->common->uploadfile($file);
		}else if($mode == "update"){
			$this->common->getProductImgList($uid, "g");//기존 상품을 가져온다.
			$this->common->uploadfile($file);//배열로서 전달됨
		}
		$rtnfile = $this->common->returnfile;
		//print_r($rtnfile);
		//exit;
				#워터마크 시작
		if($rtnfile[3]){
		//echo "rtnfile[3]:".$rtnfile[3];
		 $this->mkwatermark($rtnfile[3]);
		}
		if($rtnfile[4]) $this->mkwatermark($rtnfile[4]);
		if($rtnfile[5]) $this->mkwatermark($rtnfile[5]);
		if($rtnfile[6]) $this->mkwatermark($rtnfile[6]);
		if($rtnfile[7]) $this->mkwatermark($rtnfile[7]);
		if($rtnfile[8]) $this->mkwatermark($rtnfile[8]);
		if($rtnfile[9]) $this->mkwatermark($rtnfile[9]);
		if($rtnfile[10]) $this->mkwatermark($rtnfile[10]);
		if($rtnfile[11]) $this->mkwatermark($rtnfile[11]);
		if($rtnfile[12]) $this->mkwatermark($rtnfile[12]);
		
		if($copyimg[1] == "1" )$rtnfile[1] = $this->mkthumnail($rtnfile[0],100,100);
		if($copyimg[2] == "1" )$rtnfile[2] = $this->mkthumnail($rtnfile[0],300,300);
		
		## rtnfile 0 : 큰이미지, 1:작은이미지, 2:중간이미지
		return $rtnfile;
	}
	
	function screenshot_up($mode="insert", $file){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## 저장될 카테고리 생성
		$this->common->mkfolder("../../config/uploadfolder");
		$this->common->mkfolder("../../config/uploadfolder/game");
		$this->common->mkfolder("../../config/uploadfolder/game/screenshot");
		$this->common->upload_path = "../../config/uploadfolder/game/screenshot/";
		
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->common->uploadfile($file);
		}
		
		$rtnfile = $this->common->returnfile;


		#워터마크 시작
		if($rtnfile[0]) $this->mkwatermark($rtnfile[0]);
		return $rtnfile;
	}
		
	function news_img_up($mode="insert", $file, $category, $copyimg, $c_category=null, $uid=null){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## $copyimg: 카피파일 Array. 1: 작은이미지 만들기, 2, 중간이미지 만들기
		## c_category : 수정일 경우 기존 카테고리 $uid : 기존 상품 uid

		## 저장될 카테고리 생성
		$this->common->mkfolder("../config/uploadfolder");
		$this->common->mkfolder("../config/uploadfolder/news");
		$this->common->upload_path = "../config/uploadfolder/news";
		
		//echo $this->common->upload_path;
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->common->uploadfile($file);
		}else if($mode == "update"){
			$this->common->getProductImgList($uid, "n");//기존 상품을 가져온다.
			//echo $this->common->oldfilename;
			//exit;
			$this->common->uploadfile($file);//배열로서 전달됨
		}
		$rtnfile = $this->common->returnfile;
		
		//if($copyimg[1] == "1" ) $rtnfile[1] = $this->mkthumnail($rtnfile[0],100,100);
		//if($copyimg[2] == "1" ) $rtnfile[2] = $this->mkthumnail($rtnfile[0],300,300);
		
		## rtnfile 0 : 큰이미지, 1:작은이미지, 2:중간이미지
		return $rtnfile;
	}


	function journal_img_up($mode="insert", $file, $category, $copyimg, $c_category=null, $uid=null){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## $copyimg: 카피파일 Array. 1: 작은이미지 만들기, 2, 중간이미지 만들기
		## c_category : 수정일 경우 기존 카테고리 $uid : 기존 상품 uid

		## 저장될 카테고리 생성
		$this->common->mkfolder("../config/uploadfolder");
		$this->common->mkfolder("../config/uploadfolder/journal");
		$this->common->upload_path = "../config/uploadfolder/journal";
		
		//echo $this->common->upload_path;
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->common->uploadfile($file);
		}else if($mode == "update"){
			$this->common->getProductImgList($uid, "j");//기존 상품을 가져온다.
			//echo $this->common->oldfilename;
			//exit;
			$this->common->uploadfile($file);//배열로서 전달됨
		}
		$rtnfile = $this->common->returnfile;
		
		//if($copyimg[1] == "1" ) $rtnfile[1] = $this->mkthumnail($rtnfile[0],100,100);
		//if($copyimg[2] == "1" ) $rtnfile[2] = $this->mkthumnail($rtnfile[0],300,300);
		
		## rtnfile 0 : 큰이미지, 1:작은이미지, 2:중간이미지
		return $rtnfile;
	}
	
	
	function movie_img_up($mode="insert", $file, $uid=null){
		## $mode : update or insert, $file: upload파일명- 파일피드이름, $category:상품카테고리, 
		## 저장될 카테고리 생성
		$this->common->mkfolder("../config/uploadfolder");
		$this->common->mkfolder("../config/uploadfolder/movie");
		$this->common->upload_path = "../config/uploadfolder/movie";
		
		$this->common->uploadmode = $mode;
		
		if($mode == "insert"){
			$this->common->uploadfile($file);
			//echo "file:$file <br>";
			//exit;
			
		}else if($mode == "update"){
			$this->common->getProductImgList($uid, "v");//기존 상품을 가져온다.
			$this->common->uploadfile($file);//배열로서 전달됨
		}
	//	print_r($this->common->returnfile);
		$rtnfile = $this->common->returnfile;
		

		#워터마크 시작
		//if($rtnfile[0]) $this->mkwatermark($rtnfile[0]);
		return $rtnfile;
	}
	
## 아래부터는 금번 프로젝트 용  끝	
	
	function mkthumnail($srcimg, $width, $height){
		# $copyfile 이 존재할 경우 파일을 copy한다.
		$srcpath	= $this->common->upload_path."/".$srcimg;//저장 파일명
		$dst_path	= $this->common->upload_path;
		$srcimg		= $this->common->getImgName($srcimg);
		$srcimg		=  base64_encode("s_".$srcimg);
		$newimg		= $this->common->Image->thumnail($srcpath, $dst_path, $width, $height, $srcimg);
		return $newimg;
	}

	function mkwatermark($sourceimg, $logoimg=NULL){//class.common 에 동일 함수 존재
	//.echo $sourceimg;
	//echo "this->watermark:".$this->watermark." <br>";
		$dstpath = $srcpath	= $this->common->upload_path."".$sourceimg;//저장 파일명
		if($this->watermark == "text"){
			$info = getimagesize($srcpath);
			$mime = explode("/", $info["mime"]);##image/jpeg
			$this->common->Image->font_path = "./basicconfig/font/arial.ttf";
			$this->common->Image->dst_x=$info[0]; //출력이미지 width 크기값
			$this->common->Image->dst_y=$info[1];
			$this->common->Image->savefile = $dstpath;
			$this->common->Image->impressWaterMark($mime[1],$srcpath,$this->watermark_text);
		}else if($this->watermark == "img"){
		
			$logo_path = $_SERVER["DOCUMENT_ROOT"].$this->watermark_img;
		//	echo "srcpath:$srcpath , logo_path : $logo_path <br>";
			$this->common->Image->imageWaterMaking($srcpath, $logo_path, 90);
			
			//exit;
		}
	}
	
	function input_mallext($uid=null, $post){## 확장성을 고려한 추가필드 입력
		##$post 는 나중에 $_POST 값을 그대로 받아 처리예정
		if($uid){
			$sqlstr = "select count(1) from wizMallExt where mid = '".$uid."'";
			$result = $this->dbcon->get_one($sqlstr);
		}

		if($result){//수정모드
			$sqlstr = "update wizMallExt set filename = '".$op1."' where mid = '".$uid."'";
		}else{//입력모드
			$sqlstr = "INSERT INTO wizMallExt (mid) VALUES('".$uid."')";
		}
		$this->dbcon->_query($sqlstr);
	}

	function input_imgtable($uid, $rtnfile, $flag="m"){
		if(is_array($rtnfile))
		{
			//추후 필요할 경우 이곳에서 다양한 부분들을 처리해준다.지금은 wizmall전용
			//  flag m: 쇼핑몰, 
            $this->dbcon->deleteData("wizMall_img", "pid = '".$uid."' and opflag='".$flag."'");

			
			foreach($rtnfile as $key=>$value){
			    unset($ins);
                $ins["pid"]         = $uid;
                $ins["orderid"]     = $key;
                $ins["filename"]    = $value;
                $ins["opflag"]      = $flag;
				$this->dbcon->insertData("wizMall_img", $ins);
			}
		}
	}


	function pd_img_delete($uid, $idx){## 상품의 특정이미지 삭제
		$orderid = $idx;//+1;
		//삭제할 파일명및 카테고리 명을 구한다.
		$sqlstr = "select i.filename, m.Category from wizMall_img i 
					left join wizMall m on m.UID = i.pid 
					where i.pid = '".$uid."' and i.orderid = '".$orderid."'";
		$this->dbcon->_query($sqlstr);
		$list = $this->dbcon->_fetch_array();
		$Category = substr($list["Category"], -3);
		$filename = $list["filename"];
		
		//테이블에서 정보삭제
        $this->dbcon->deleteData("wizMall_img", "pid = '".$uid."' and orderid='".$orderid."'");
					
		//폴더에서 파일삭제
		$deletefile = "../config/uploadfolder/productimg/".$Category."/".$filename;
		if (is_file($deletefile))unlink($deletefile);
	}

	function htmleditorImg($str, $uid){
		$source	= "../config/tmp_upload/".session_id();
		$dest	= "../config/uploadfolder/editor/".$uid."/";
		if(is_dir($source)){
			$this->common->CopyFiles($source,$dest);
			//$this->common->RemoveFiles($source);//다중 필드사용시 에러로 인해 이부분 삭제하고 바로 처리
			$str = str_replace("/tmp_upload/".session_id(), "/uploadfolder/editor/".$uid, $str);
		}
		return $str;
		
	}

	function coorbuy($mode="insert", $pid, $c_sdate, $c_fdate, $c_c_price, $c_qty){
		$PriceQty = "";
		foreach($c_c_price as $key=>$value){
			$PriceQty .= $value.":".$c_qty[$key].":||";
		}
		if($mode == "insert"){
		    unset($ins);
            $ins["PID"]    = $pid;
            $ins["PriceQty"]    = $PriceQty;
            $ins["SDate"]    = $c_sdate;
            $ins["FDate"]    = $c_fdate;
            $ins["wdate"]    = time();
			$this->dbcon->insertData("wizcoorbuy", $ins);
		}else if($mode == "update"){
			$cnt = $this->dbcon->get_one("select count(1) from wizcoorbuy where PID=".$pid);
            unset($ups);
            $ups["PriceQty"]    = $PriceQty;
            $ups["SDate"]    = $c_sdate;
            $ups["FDate"]    = $c_fdate;
			if($cnt){
				$this->dbcon->updateData("wizcoorbuy", $ups, "PID=".$pid);
			}else{
			    $ups["PID"]    = $pid;
                $ups["wdate"]    = time();
				$this->dbcon->insertData("wizcoorbuy", $ups);
			}
		}
	}

	/*
	* $qty, $price 는 배열로 넘긴다.
	*/
	function diffprice($pid, $qtyArr, $priceArr){
		//기존의 것은 모두 지우고 새 로입력한다.
		$this->dbcon->deleteData("wizMallDiffPrice", "pid = ".$pid);
		if(is_array($qtyArr)){
			foreach($qtyArr as $key=>$val){
				$qty	= $val;
				$price	= $priceArr[$key];
				if($qty && $price){
				    unset($ins);
                    $ins["pid"]    = $pid;
                    $ins["qty"]    = $qty;
                    $ins["price"]    = $price;
					$this->dbcon->insertData("wizMallDiffPrice", $ins);
				}
			}
		}
	}

	## 상품정렬순서 실렉트 박스
	function sel_pd_order($sel=null){
		$array	= array(""=>"상품정렬하기","m.UID@desc"=>"등록순 정렬","m.Date@desc"=>"수정순 정렬","m.Price@desc"=>"가격순 정렬","m.Hit@desc"=>"조회순 정렬","m.OutPut@desc"=>"판매순 정렬","m.Point@desc"=>"포인트순 정렬");
		$arg[0]	= "style='WIDTH: 140px' onChange=this.form.submit()";
		$this->common->mkselectmenu("orderby", $array, $sel, $arg);
	}

	function sel_pd_opt($sel=null){
		$a = array('');
		$b = array('옵션별');
		
		$regoption	= $this->mall->getpdoption();

		while(list($key, $val)=each($regoption)):
			//$checked = in_array($val["uid"], $c_option) ? " checked":"";
			//echo "<input type='checkbox' name='Multi_Regoption[]' value='".$val["uid"]."' $checked >".$val["op_name"]."&nbsp; ";
			array_push($a, $val["uid"]);
			array_push($b, $val["op_name"]);
		endwhile;


		$array = $this->common->arraycombine($a, $b);
		//$array = array_combine($a, $b);

		//array_push($array, $arr);
		//print_r($array);
		$arg[0]	= "style='width: 100px' onChange=this.form.submit()";
		$this->common->mkselectmenu("OptionList", $array, $sel, $arg);
	}

	## 회원정렬순서 실렉트 박스
	function sel_mem_order($sel=null){
		$array	= array(""=>"선택부분별 정렬","m.mregdate@desc"=>"등록날짜순정렬","m.mid@asc"=>"아이디순 정렬","m.mname@asc"=>"이름순 정렬","m.mpoint@desc"=>"포인트순 정렬","m.mgrade@asc"=>"등급순 정렬","m.mloginnum@desc"=>"접속순 정렬","i.gender@asc"=>"성별구분순 정렬");
		$arg[0]	= "style='WIDTH: 140px' onChange=this.form.submit()";
		$this->common->mkselectmenu("sel_orderby", $array, $sel, $arg);
	}
	## 검색필드타이틀
	function sel_mem_stitle($sel=null){
		$array	= array(""=>"검색영역","m.mid"=>"아이디","m.mname"=>"이 름","i.address1"=>"주거지역","i.email"=>"이메일","i.jumin"=>"주민번호(13)");
		$arg[0]	= "";
		$this->common->mkselectmenu("stitle", $array, $sel, $arg);
	}

	## 주문배송관련
	function sel_order_order($sel=null){
		$array	= array(""=>"선택부분별 정렬","b.TotalAmount@desc"=>"구매금액순 정렬","b.PayMethod@asc"=>"결제방식  구분","b.MemberID@asc"=>"아이디순정렬");
		$arg[0]	= "style=\"WIDTH: 140px\" onChange=this.form.submit()";
		$this->common->mkselectmenu("sel_orderby", $array, $sel, $arg);
	}
	## 검색필드타이틀
	function sel_order_stitle($sel=null){
		$array	= array(""=>"검색영역","b.OrderID"=>"주문번호","b.SName"=>"주문자","b.RName"=>"수령자","b.RCompany"=>"상호");
		$arg[0]	= "";
		$this->common->mkselectmenu("stitle", $array, $sel, $arg);
	}

	## 검색필드타이틀
	function sel_order_status($arr, $sel=null){
		$a = array('');
		$b = array('거래상태별 구분');
		
		foreach($arr as $key=>$value){
			array_push($a, $key);
			array_push($b, $value);
		}
		$array = $this->common->arraycombine($a, $b);
		//$array = array_combine($a, $b);

		//array_push($array, $arr);
		//print_r($array);
		$arg[0]	= "style='WIDTH: 120px' onChange=this.form.submit()";
		$this->common->mkselectmenu("orderstatus", $array, $sel, $arg);
	}


	## sms 및 문자 발송관련
	function getmessage_cont($status, $flag){
		$sqlstr = "select * from wizordermail where delivery_status = '".$status."' and flag='".$flag."'";
		$list = $this->dbcon->get_row($sqlstr);
		return $list;		
	}

	## 카테고리 메니저
	function getcatorder($lv, $ccode){ ##레벨에 따른 카테고리 순서 뽑아오기
		$strlen = $lv * 3;//카테고리당 3자리씩 자른다.(뒤부터 1차, 2차...  카테고리
		$comlen = $strlen - 3;
		$sqlstr = "select max(cat_order) from wizCategory where LENGTH(cat_no) = ".$strlen." and RIGHT(cat_no, ".$comlen.") = '".$ccode."'";
		$maxcnt = $this->dbcon->get_one($sqlstr);
		return $max = $maxcnt+1;
	}

	function getcatno($lv, $ccode){ ##레벨에 따른 카테고리 순서 뽑아오기
		$strlen = $lv * 3;//카테고리당 3자리씩 자른다.(뒤부터 1차, 2차...  카테고리
		$comlen = $strlen - 3;
		$sqlstr = "select max(cat_no)  from wizCategory where LENGTH(cat_no) = ".$strlen." and RIGHT(cat_no, ".$comlen.") = '".$ccode."'";
		$maxcnt = $this->dbcon->get_one($sqlstr);	
		return $catno = sprintf("%03d", (int)substr($maxcnt,0, 3)+1).$ccode;
	}


	function hangul_qurey($key){
		switch($key)
		{
			case "ㄱ":$str = "and name RLIKE '^(ㄱ|ㄲ)' OR (name >= '가' AND name < '나') "; break;
			case "ㄴ":$str = "and name RLIKE '^ㄴ' OR (name >= '나' AND name < '다') "; break;
			case "ㄷ":$str = "and name RLIKE '^(ㄷ|ㄸ)' OR (name >= '다' AND name < '라') "; break;
			case "ㄹ":$str = "and name RLIKE '^ㄹ' OR (name >= '라' AND name < '마') "; break;
			case "ㅁ":$str = "and name RLIKE '^ㅁ' OR (name >= '마' AND name < '바') "; break;
			case "ㅂ":$str = "and name RLIKE '^(ㅂ|ㅃ)' OR (name >= '바' AND name < '사') "; break;
			case "ㅅ":$str = "and name RLIKE '^(ㅅ|ㅆ)' OR (name >= '사' AND name < '아') "; break;
			case "ㅇ":$str = "and name RLIKE '^ㅇ' OR (name >= '아' AND name < '자') "; break;
			case "ㅈ":$str = "and name RLIKE '^(ㅈ|ㅉ)' OR (name >= '자' AND name < '차') "; break;
			case "ㅊ":$str = "and name RLIKE '^ㅊ' OR (name >= '차' AND name < '카') "; break;
			case "ㅋ":$str = "and name RLIKE '^ㅋ' OR (name >= '카' AND name < '타') "; break;
			case "ㅌ":$str = "and name RLIKE '^ㅌ' OR (name >= '타' AND name < '파') "; break;
			case "ㅍ":$str = "and name RLIKE '^ㅍ' OR (name >= '파' AND name < '하') "; break;
			case "ㅎ":$str = "and name RLIKE '^ㅎ' OR name >= '하' "; break;
			case "eng":
				$str = "and (name LIKE 'A%' ";
				for($i=66; $i<=90; $i++)
				{
					$temp = chr($i);
					$str .= "OR name LIKE '$temp%' "; 
				}
				$str .= ") "; 
				break;
		}

		return $str;
	} 

	function mkmanagerlog($tid, $tblname, $userid, $username=null){ ##일반관리자들이 제품을 수정할 경우 로그 테이블을 남긴다.
		//$tid : 테이블 고유값(uid), $addflag : 테이블명 혹은 특정 인자값
		$sqlstr = "select count(*) from `wizmanagelog` where tid = '".$tid."' and tblname = '".$tblname."'";
		$result = $this->dbcon->get_one($sqlstr);
		$addflag = $result ? "s":"m";
        unset($ins);
        $ins["tid"]    = $tid;
        $ins["addflag"]    = $addflag;
        $ins["tblname"]    = $tblname;
        $ins["userid"]    = $userid;
        $ins["username"]    = $username;
        $ins["wdate"]    = time();
		return $this->dbcon->insertData("wizmanagelog", $ins);
	}

	function managerlogm($tid, $tblname){//class.gamech 에도 동일함수 존재
		$sqlstr = "select userid, username, wdate from wizmanagelog where tblname = '".$tblname."' and tid = '".$tid."' and addflag = 'm'";
		$list = $this->dbcon->get_row($sqlstr);
		$this->mname = $list["username"];
		$this->mid = $list["userid"];
		$this->wdate = $list["wdate"];
	}
	
	function managerlogs($tid, $tblname){
		$sqlstr = "select userid, username, wdate from wizmanagelog where tblname = '".$tblname."' and tid = '".$tid."' and addflag = 's'";
		return $this->dbcon->_query($sqlstr);
	}
	
	function insertSearchKey($tablename, $content, $uid){
		/* 토탈 보드에 자료 입력(총 검색을 위해) */
		unset($ins);
        $ins["BID"]    = $tablename;
        $ins["UID"]    = $uid;
        $ins["CONTENTS"]    = $content;
        return $this->dbcon->insertData("wizTable_TotalSearch", $ins);			
	}
	
	function accessGrade($grade){//관리자 접근 권한
		$accessgrade = array("admin", "1", "2", "3", "4", "5", "6", "7");
		return in_array($grade, $accessgrade);
	}

	function accessBoardGrade($grade){//보드 접근 권한
		$accessgrade = array("admin", "1");
		return in_array($grade, $accessgrade);
	}
}