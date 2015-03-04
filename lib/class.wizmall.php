<?php
class mall{

	var $dbcon;
	var $common;
	var $cfg;//외부 $cfg 관련 배열
	var $op;//기타 활용 변수값(iframe:true,)

	## db 클라스 함수 호출용
	function db_connect(&$dbcon){//db_connection 함수 불러오기
		$this->dbcon = $dbcon;
	}

	## common 클라스 함수 호출용
	function common($common){//db_connection 함수 불러오기
		$this->common = &$common;
	}

## 다중 클라스 함수 호출용
	function get_object(&$dbcon=null, &$common=null){//
		if($dbcon) $this->dbcon	= $dbcon;
		if($common) $this->common	= $common;
	}


#######################################
########   [ 장바구니 담기 ] 
#######################################
## CART 부분은 별도의 Class를 생성후 전담 처리
	#CART파일의 생성시간을 구해서 하루초과에 대해서는 자동삭제(여기서는 하루 기준)..
	function CartDbClear(){ ## class.cart에서 이부분 처리
		$this->cart->CartDbClear();
	}
	
	function wizCartExe($oid,$pid,$qty,$optionfield){## class.cart에서 이부분 처리
		$this->cart->wizCartExe($oid,$pid,$qty,$optionfield);
	}
	
	## 장바구니 옵션값을 배열로 변환
	function optoArr($op){## class.cart에서 이부분 처리
		$this->cart->optoArr($op);	 
	}
	
	## 장바구니 옵션값을 텍스트로 변환
	function optoStr($op){## class.cart에서 이부분 처리
		$this->cart->optoStr($op);	
		
	}
	
	## 장바구니 상품갯수 변경
	function changeCartqty($uid, $qty){## class.cart에서 이부분 처리
		$this->cart->changeCartqty($uid, $qty);
	}
	function wizCartExe_sample($oid,$pid,$qty,$price,$point){
		$this->cart->wizCartExe_sample($oid,$pid,$qty,$price,$point);
	}	
	
	function ResetCart(){	#하루전 wizCart 데이타는 삭제
		$this->cart->wResetCart();
	}
	







	function evaluProduct($mode, $pid){
		//$mode : insert, delete;
		$user_id 		= $this->user_id ? $this->userid:$_COOKIE[MEMBER_ID];
		$user_name 		= $this->user_name;
		$user_passwd 	= $this->user_passwd;
		$user_email 	= $this->user_email;
		$evalu_grade 	= $this->evalu_grade;
		$subject 		= $this->subject;
		$contents 		= $this->contents;
		$txttype 		= $this->texttype;
		$count 			= $this->count;
		$ip 			= $REMOTE_ADDR;
		$query 			= $this->query;
		$code 			= $this->code;
		
		
		if($mode == "insert"){
			$sqlstr = "INSERT INTO wizEvalu 
			(GID,ID,Name,Passwd,Email,Grade,Subject,Contents,TxtType,Count,IP,Wdate)
					VALUES
					('$pid','$userid','$user_name','$user_passwd','$user_email','$evalu_grade','$subject','$contents','$txttype','$count','$ip',".time().")"; 
					
			$this->dbcon->_query($sqlstr);
			
			ECHO "<script>window.alert('고객님의 상품평에 감사드립니다.');
			location.replace('$PHP_SELF?query=$query&code=$code&no=$pid');
			</script>";
			exit;
		
		}else if($mode == "delete"){
			$sqlstr = "select ID from wizEvalu where UID = '$repleuid'";
			$RepleID = $this->dbcon->_query($sqlstr);
				if($RepleID != $this->cfg["member"]["mid"]){
					echo "<script>window.alert('본인이 작성한 글만을 지울 수가 있습니다.');location.replace('$PHP_SELF?query=$query&code=$code&no=$GID');</script>";
					exit;
				}else{
					$sqlstr = "delete from wizEvalu where UID = '$repleuid'";
					$this->dbcon->_query($sqlstr);
					echo "<script>location.replace('$PHP_SELF?query=$query&code=$code&no=$GID');</script>";
					exit;
				}
		
		}
	
	}
	
	## 카테고리를 실렉트 형식으로 변환하여 가져옮
	## $depth : 현재 카테고리 : 1 : 1차분류, 2:2차분류, 3:3차분류
	## $curr_cat : 현재 카테고리 : 현재 카테고리가 존재하면selected 되게 설정
	function getSelectCategory($depth, $curr_cat=null, $catflag="wizmall"){
		//echo $this->check_dbinfo();
		if($depth == "1"){
			$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 3 and cat_flag = '".$catflag."' ORDER BY cat_order ASC";
			$this->dbcon->_query($sqlstr);
			while($list=$this->dbcon->_fetch_array()):
				$cat_no 	= $list["cat_no"];
				$cat_name 	= $list["cat_name"];			
				$selected = substr($curr_cat, -3) == $cat_no?"selected":""; 
				echo"<option value='".$cat_no."' ".$selected.">".$cat_name."</option> \n";
			endwhile;
			
		}else if($depth == "2"){
			$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 6 AND RIGHT(cat_no, 3) = '".substr($curr_cat, -3)."' and cat_flag = '".$catflag."' ORDER BY cat_order ASC";
			
			$this->dbcon->_query($sqlstr);
			while($list=$this->dbcon->_fetch_array()):
				$cat_no 	= $list["cat_no"];
				$cat_name 	= $list["cat_name"];			
				$selected = substr($curr_cat, -6) == $cat_no?"selected":""; 
				echo"<option value='".$cat_no."' ".$selected.">".$cat_name."</option> \n";
			endwhile;
					
		}else if($depth == "3"){
			//$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE cat_no >= 10000 and substring(cat_no, 3, 4)='".substr($curr_cat, -4)."' ORDER BY cat_no ASC";
			$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 9 AND RIGHT(cat_no, 6) = '".substr($curr_cat, -6)."' and cat_flag = '".$catflag."' ORDER BY cat_order ASC";
			$this->dbcon->_query($sqlstr);
			while($list=$this->dbcon->_fetch_array()):
				$cat_no 	= $list["cat_no"];
				$cat_name 	= $list["cat_name"];
				$selected = substr($curr_cat, -9) == $cat_no?"selected":""; 
				echo"<option value='".$cat_no."' ".$selected.">".$cat_name."</option> \n";
			endwhile;		
		}
	}
	
	## 카테고리를 풀로 가져옮 예) 1차 > 2차 > 3차
	## $code : 현재 카테고리

	function getCategory($code){
		$len = strlen($code);
		if($len>6){
			$sqlstr = "select cat_name from wizCategory where cat_no = '$code'"; 
			$cat_name = $this->dbcon->get_one($sqlstr);
			$rtn[2]["cat_name"] = $cat_name;
			$rtn[2]["cat_no"] = $code;
		}

		if($len>3){
			$sqlstr = "select cat_name from wizCategory where cat_no = '".substr($code, -6)."'"; 
			$cat_name = $this->dbcon->get_one($sqlstr);
			$rtn[1]["cat_name"] = $cat_name;
			$rtn[1]["cat_no"] = substr($code, -6);
		}

		if($len>0){
			$sqlstr = "select cat_name from wizCategory where cat_no = '".substr($code, -3)."'"; 
			$cat_name = $this->dbcon->get_one($sqlstr);
			$rtn[0]["cat_name"] = $cat_name;
			$rtn[0]["cat_no"] = substr($code, -3);
		}
		//print_r($rtn);
		return $rtn;
	}

	function getCategoryFullPath($code){
		//$code = (int)$code;
		$cat = $this->getCategory($code);
		//echo "code = $code <br>";
		//echo "cat = $cat <br>";
		ksort($cat);
		foreach($cat as $key=>$value){
			$split = $key != 0 ? "&gt;":"";
			$rtn_category .= $split.$value["cat_name"];
		}
		return $rtn_category;
		/*
		$stepLen = round(strlen($code)/3);
		$split = "&gt;";
		$rtn_category = "";
		for($i=1; $i<=$stepLen; $i++){
			$j = $i*3;
			$cat_no = (int)substr($code, -$j);
			$sqlstr = "select cat_no, cat_name from wizCategory where cat_flag = 'wizmall' and cat_no =  $cat_no";
			$list = $this->dbcon->get_row($sqlstr);
			if($i != 1) $rtn_category .= $split;//분리자 넣기
			$rtn_category .= $list["cat_name"];
		}
		return $rtn_category;
		*/
	}
	
	function getNavy($code, $option=null){
		$navy_path = "<ul class=\"breadcrumb\"><li><a href=\"./\">Home</a></li>";
		if($option){## 현재 공동구매는 code가 없으므로 에러발생
			$sql = "select op_name from wizpdoption where uid = ".$option;
			$op_name = $this->dbcon->get_one($sql);
			$this->Regoption =$op_name;
			$navy_path .= "<li class=\"active\">".$op_name."</li>";
		}else if($code){
			$cat = $this->getCategory($code);
			ksort($cat);
			$len = count($cat)-1;
			foreach($cat as $key=>$value){
				if($key==$len){
					$navy_path .= "<li class=\"active\">".$value["cat_name"]."</li>";
					$this->navy_title = $value["cat_name"];//현재 값을 리턴한다.
				}else{
					$navy_path .= "<li><a href='wizmart.php?code=".$value["cat_no"]."'>".$value["cat_name"]."</a></li>";
				}
			}
			
		}
		$navy_path .= "</ul>";
		return $navy_path;
	}

	## 아래는 샘플로서 class.statistics 에 있는 내용
	function get_cat_line($category, $link=null){//카테고리를 순차적으로 보여줌
		$len = strlen($category);
		$link = $PHP_SELF."?menushow=$menushow&theme=$theme&orderby=$orderby&cp=$cp";
		$rtn = "";
		if($len>6){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '$category'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$link."&category=".$category."'><font color='#006633'>$cat_name</font></A>";
		}

		if($len>3){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($category, -6)."'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$link."&category=".substr($category, -6)."'><font color='#006633'>$cat_name</font></A>";
		}

		if($len>0){
			$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($category, -3)."'"; 
			$cat_name = $this->dbcon->get_one($sqlcatstr);
			$rtn .= " &gt; <A HREF='".$link."&category=".substr($category, -3)."'><font color='#006633'>$cat_name</font></A>";
		}

		echo $rtn;

	}


	## 제품코드를 이용해 제품상세정보를 가져온다.
	## $uid : 제품고유 코드값
	## $field : 자져올 필드 예) "UID,Name,Price,Picture,Category"
	function getProductInfo($uid, $field="Name,Price,Picture,Category"){
		$sqlstr = "select $field from wizMall where UID = '$uid'";
		$list = $this->dbcon->get_row($sqlstr);
		return $list;
	}
	
	## [쿠폰] 발급 쿠폰갯수 구하기
	## $uid : 쿠폰카운트
	function getCouponCnt($uid){
		$sqlstr = "select count(1) from wizUsercoupon where couponid = '$uid'";
		$list = $this->dbcon->get_one($sqlstr);
		return $list;
	}
	
	## 비교상품관련 리스트 출력
	function getSimilarPd($SimilarPd){
		foreach($SimilarPd as $key => $value){
			if($value){
				$sqlstr = "select UID, Name from wizMall where UID = '$value'";
				$this->dbcon->_query($sqlstr);
				$list = $this->dbcon->_fetch_array();
				$pname = $list["Name"];
				echo "<option value='$value' selected='selected'>$pname</option>\n";
			}
		}
	}
	
	## 제품 클릭시 상세보기로 이동하는 경로
	function pdviewlink($uid,$code,$stockout){
		if (!strcmp($stockout,"1")) {
			$viewlink = "javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')";
		}else {
			$viewlink = "./wizmart.php?query=view&code=$code&no=$uid&op=".$this->op;
		}
		return $viewlink;
	}
	

	
	## 카테고리별 제품등록수 변경
	## $catno : 현재 카테고리
	function insertPdCnt($catno, $mode="update"){
		if($mode == "update"){
			$sqlstr = "update wizCategory set pcnt = pcnt + 1 where cat_no = '$catno'";
			//echo $sqlstr;
			$this->dbcon->_query($sqlstr);
		}else if($mode == "delete"){
			$sqlstr = "update wizCategory set pcnt = pcnt - 1 where cat_no = '$catno'";
			$this->dbcon->_query($sqlstr);
		}
	
	}
	
	## 카테고리별 제품등록수 초기화
	## 카테고리가 이상하게 꼬여 있을 경우 이부분을 실행시켜 초기화 시켜준다.
	function resetPdCnt(){
		## 모든 카운트를 0으로 정리
		$sqlstr = "update wizCategory set pcnt = 0";
		$this->dbcon->_query($sqlstr);
	
		$sqlstr = "select Category FROM wizMall";
		$qry	= $this->dbcon->_query($sqlstr);
		//	exit;
		while($list = $this->dbcon->_fetch_array($qry)){
			$Category = $list["Category"];
			$substr = "update wizCategory set pcnt = pcnt + 1 where cat_no = '$Category'";
			$subqry = $this->dbcon->_query($substr);
		}
		return true;
		//echo "alert('초기화 되었습니다.');";
	
	}
	#######################################
	########   [ 제품삭제] 
	#######################################
	
	function deleteProduct($uid){
		if($uid){
			$sqlstr = "SELECT Picture, Category FROM wizMall WHERE UID='$uid'";
			$list = $this->dbcon->get_one($sqlstr);
			$Picture = explode("|", $list["Picture"]);
			$Category = $list["Category"];
			$big_cat = substr($Category, -3);
			
			for($i=0; $i<sizeof($Picture); $i++){
				if($big_cat && $Picture[$i]){
					if (file_exists("../config/uploadfolder/productimg/$big_cat/$Picture[$i]") && $Picture[$i]) {
						unlink("../config/uploadfolder/productimg/$big_cat/$Picture[$i]");
					}
				}
			}
			
			$sqlstr = "select filename from wizMall_img where pid = '$uid'  and opflag = 'm'";
			$result = $this->dbcon->_query($sqlstr) ;
			while($list = $this->dbcon->_fetch_array($result)):
				$filename = $list["filename"];
				if($big_cat && $filename){
					if (file_exists("../config/uploadfolder/productimg/$big_cat/$filename") && $filename) {
						unlink("../config/uploadfolder/productimg/$big_cat/$filename");
					}
				}
			endwhile;
			
			## html editor 에 등록된 이미지 폴더 삭제
			if($uid){
				$source = "../config/uploadfolder/editor/".$uid;
				$this->common->RemoveFiles($source);
			}
			
			## 상품 DB의 제품삭제
			$this->insertPdCnt($Category, "delete");
			
			## 다중카테고리에 등록된 제품 삭제
			$sqlstr = "SELECT Category FROM wizMall WHERE PID='$uid'";
			$result = $this->dbcon->_query($sqlstr);
			while($list = $this->dbcon->_fetch_array($result)){
				$Category = $list["Category"];
				$this->insertPdCnt($Category, "delete");
			}
			##  제품테이블에서 삭제		
			$this->dbcon->_query("DELETE FROM wizMall WHERE PID=$uid");
			
			## 제품이미지 테이블 삭제
			$this->dbcon->_query("DELETE FROM wizMall_img WHERE pid=$uid");
			
			## 상품평삭제
			$this->dbcon->_query("DELETE FROM wizEvalu WHERE GID=$uid");
			
			## 추가 필드 항목 삭제
			$this->dbcon->_query("DELETE FROM wizMallExt  WHERE mid=$uid");
			
			## 옵슨 항목 삭제
			$this->dbcon->_query("DELETE FROM wizMalloption  WHERE ouid=$uid");		
			
			## 재고 항목 필드 삭제
			$this->dbcon->_query("DELETE FROM wizInputer  WHERE Igoodscode=$uid");	
		}
	}	
	
	
	function deleteNews($uid){	
		## 등록된 이미지 삭제
		$sqlstr = "select filename from wizMall_img where pid = '$uid' and opflag = 'n'";
		$this->dbcon->_query($sqlstr) ;
		while($list = $this->dbcon->_fetch_array()):
			$filename = $list["filename"];
			if (file_exists("../config/uploadfolder/productimg/$filename") && $filename) {
				unlink("../config/uploadfolder/productimg/$filename");
			}
		endwhile;
		

		
		## 상품 DB의 제품삭제
		$this->dbcon->_query("DELETE FROM wizgamenews WHERE UID=$uid");
		
		## 제품이미지 테이블 삭제
		$this->dbcon->_query("DELETE FROM wizMall_img WHERE pid=$uid and opflag = 'g'");
		
		## 상품평삭제
		//$this->dbcon->_query("DELETE FROM wizEvalu WHERE GID=$uid");
		## 수정로그 삭제
		$this->dbcon->_query("DELETE FROM wizmanagelog where tblname = 'wizgamenews' and tid=$uid");
	}
	
	function deletegameInfo($uid){	
		## 등록된 이미지 삭제
		$sqlstr = "select filename from wizMall_img where pid = '$uid' and opflag = 'g'";
		$this->dbcon->_query($sqlstr) ;
		while($list = $this->dbcon->_fetch_array()):
			$filename = $list["filename"];
			if (file_exists("../config/uploadfolder/productimg/$filename") && $filename) {
				unlink("../config/uploadfolder/productimg/$filename");
			}
		endwhile;
		

		
		## 상품 DB의 제품삭제
		$this->dbcon->_query("DELETE FROM wizgame WHERE UID=$uid");
		
		## 제품이미지 테이블 삭제
		$this->dbcon->_query("DELETE FROM wizMall_img WHERE pid=$uid and opflag = 'g'");
		
		## 상품평삭제
		//$this->dbcon->_query("DELETE FROM wizEvalu WHERE GID=$uid");
		## 수정로그 삭제
		$this->dbcon->_query("DELETE FROM wizmanagelog where tblname = 'wizgamenews' and tid=$uid");
		
		##서비스 평점 삭제
		$this->dbcon->_query("DELETE FROM wizgameeva where gid = $uid");
		
		## 연관 게임 삭제
		$this->dbcon->_query("DELETE FROM wizgameref where rid = $uid");
		
		## 연관 키워드 삭제 삭제
		$this->dbcon->_query("DELETE FROM wizTable_TotalSearch where BID = 'wizgame' and UID = $uid");			
	}		
	
	
	/**
	*	대분류를 기준으로 하위 모든 코드를 배열에 담아 둔다.
	*/
	function getCategoryTree($code){
		$bigcode	= substr($code, -3);
		$sql	= "select cat_order, cat_no, cat_name, pcnt from wizCategory where cat_flag = 'wizmall' and cat_no like '%$bigcode' order by cat_no asc";//현재를 포함한 하위 모든 코드를 담는다.
		$rows =  $this->dbcon->get_rows($sql);
		if(is_array($rows)) foreach($rows as $key => $val){
			$rtn[$val["cat_no"]]	 = $val;
		}

		return $rtn;
		
		////$sql	= "select * from wizCategory where cat_flag = 'wizmall' and if(CHAR_LENGTH(cat_no) == 3 ) like '%$code'";

	}

	//if(!$lv & $samll_code) $lv=3;
	//else if(!$lv & $mid_code) $lv=2;
	//else if(!$lv & $big_code) $lv=1;
	/* 신규 코드 start */
	function whatincfile($code){
		//3칸씩 잘라 실제 코드값을 구한다
		//$productWhere;//상품리스팅에 사용 , categoryWhere: 상품리스트 상단카테고리에 사용, categoryCntWhere : 카테고리별 상품수 계산
		$whereis = "where cat_flag = 'wizmall' ";
		$c_depth = 0;
		$len = strlen($code);
		//echo "len = $len <br>";
		switch($len){
			case (3):
				$whereis .= " and right(cat_no, 3) =  '".substr($code, -3)."'";
				$this->productWhere = " and right(m2.Category, 3) =  '".substr($code, -3)."'";
				$this->categoryWhere = $whereis." and length(cat_no) = 6";
				$this->categoryCntWhere = "where right(cat_no, 3) =  '".substr($code, -3)."' and length(cat_no) > 3";
				$this->c_depth = 1;
				$realcode = substr("0".$code, -3);
			break;
			case (6):
				$whereis .= " and right(cat_no, 6) =  '".substr($code, -6)."'";
				$this->productWhere = " and right(m2.Category, 6) =  '".substr($code, -6)."'";
				$this->categoryWhere = $whereis." and length(cat_no) = 9";
				//$this->categoryCntWhere = $whereis." and cat_no >= 100";
				$this->categoryCntWhere = "where right(cat_no, 3) =  '".substr($code, -3)."' and length(cat_no) > 3";
				$this->c_depth = 2;
				$realcode = substr("0".$code, -6);
				$precode = substr("0".$code, -4);
			break;
			case (9):
				$whereis .= " and right(cat_no, 9) =  '".substr($code, -9)."'";
				$this->productWhere = " and right(m2.Category, 9) =  '".substr($code, -9)."'";
				//$this->categoryWhere = $whereis." and length(cat_no) = 9";
				$this->categoryWhere = "where cat_flag = 'wizmall'  and right(cat_no, 6) =  '".substr($code, -6)."' and length(cat_no) = 9";
				//$this->categoryCntWhere = $whereis." and cat_no >= 100";
				$this->categoryCntWhere = "where right(cat_no, 3) =  '".substr($code, -3)."' and length(cat_no) > 3";
				$this->c_depth = 3;
				$realcode = substr("0".$code, -9);
				$precode = substr("0".$code, -6);
			break;				
		}
		
		
		
		$sqlstr = "select max(cat_no) from wizCategory $whereis";
		//echo $sqlstr;
		$result = $this->dbcon->get_one($sqlstr);
		//echo "result:$result";
		switch(true){
			case ($result < 1000):
				$max_depth = 1;
				switch($max_depth - $this->c_depth){
					case 0: $whatincfile = "list_3.php"; break;			
				}			
			break;
			case ($result < 1000000):
				$max_depth = 2;
				switch($max_depth - $this->c_depth){
					case 0: $whatincfile = "list_3.php"; break;
					case 1: $whatincfile = "list_2.php"; break;
				
				}
			break;
			case ($result < 1000000000):
				$max_depth = 3;
				switch($max_depth - $this->c_depth){
					case 0: $whatincfile = "list_3.php"; break;
					case 1: $whatincfile = "list_2.php"; break;
					case 2: $whatincfile = "list_1.php"; break;
				
				}
				
			break;				
		}
		//echo "incfile = $whatincfile <br>";
		return $whatincfile;	
		
	}
	
	function getPdInfo($uid){//등록상품의 정보를 가져옮
		$sqlstr = "select Category from wizMall where UID = $uid";
		$list =$this->get_row($sqlstr);
		return $list;
	}
	
	
	function SaveViewItem($no){

		$sqlstr = "select m2.Category, m1.Picture, m1.Category as imgCat from wizMall m2 left join wizMall m1 on m2.PID = m1.UID where m2.UID='$no'";
		$this->dbcon->_query($sqlstr);
		$list = $this->dbcon->_fetch_array();
		$tmp = explode("|", $list["Picture"]);
		$cookie_img		= $tmp[0];
		$cookie_cat		= $list["Category"];
		$cookie_imgcat	= $list["imgCat"];

	//오늘본 제품을 세션에 담는다.
	//db로 처리할 경우 부담이 많이 올것 같아 파일로 처리
		$logdir = $path."config/wizmember_tmp/view_product";
		$view_file = $logdir."/".session_id().".php";
		$this->common->delLogFile($logdir);
		//readdir($logdir);
		if (is_file($view_file)){
			include $view_file;
			$cnt = sizeof($TODAY_PRODUCT[uid]);
			if (in_array ("$no", $TODAY_PRODUCT[uid])) {//값이 존재하면 현재 존재하는 값은 삭제한다.(최근에 본 내역으로 솔팅하기 위해);
				$keyvalue = array_search($no,$TODAY_PRODUCT[uid]);
				if(!is_null($keyvalue)){						
					$TODAY_PRODUCT[uid][$keyvalue] = "";
					$TODAY_PRODUCT[img][$keyvalue] = "";
					$TODAY_PRODUCT["category"][$keyvalue] = "";	
					$TODAY_PRODUCT["imgcategory"][$keyvalue] = "";
				}
			}
				$TODAY_PRODUCT[uid][] = $no;
				$TODAY_PRODUCT[img][] = $cookie_img;	
				$TODAY_PRODUCT["category"][] = $cookie_cat;
				$TODAY_PRODUCT["imgcategory"][] = $cookie_imgcat;
				reset($TODAY_PRODUCT);
				$view_file_list = "<?\n";
				foreach($TODAY_PRODUCT[uid] as $key => $value){
					if($value){
						$view_file_list .= "\$TODAY_PRODUCT[\"uid\"][$key] = \"$value\";\n";
						$view_file_list .= "\$TODAY_PRODUCT[\"img\"][$key] = \"".$TODAY_PRODUCT[img][$key]."\";\n";
						$view_file_list .= "\$TODAY_PRODUCT[\"category\"][$key] = \"".$TODAY_PRODUCT[category][$key]."\";\n";
						$view_file_list .= "\$TODAY_PRODUCT[\"imgcategory\"][$key] = \"".$TODAY_PRODUCT[imgcategory][$key]."\";\n";
					}
				}
				$view_file_list .= "?>";
				$fp = fopen($view_file, "w");
				fwrite($fp, $view_file_list);
				fclose($fp);
		}else{
			$fp = fopen($view_file, "w");
			$view_file_list = "<?
	\$TODAY_PRODUCT[\"uid\"][0] = \"$no\";
	\$TODAY_PRODUCT[\"img\"][0] = \"$cookie_img\";
	\$TODAY_PRODUCT[\"category\"][0] = \"$cookie_cat\";
	\$TODAY_PRODUCT[\"imgcategory\"][0] = \"$cookie_imgcat\";
	?>";
			fwrite($fp, $view_file_list);
			fclose($fp);
		}
		
	}
	
	/**
	 * $ShopIconSkin : 아이콘 스킨
	 * $Regoption : 현재 상품 아이콘(|으로 다중값 처리)
	 */
	function ShowOptionIcon($ShopIconSkin, $Regoption){
		$regoption	= $this->getpdoption();
		$ShowOptionIcon = "";
		$c_option = explode("|", $Regoption);
		if(is_array($c_option)){
			while(list($key, $val)=each($regoption)):
				$ShowOptionIcon .= in_array($val["uid"], $c_option) && $val["op_icon_image"] !="" ? "<img src='./config/pdoption/".$val["op_icon_image"]."'>" :"";
			endwhile;
		}
			//}
		Return $ShowOptionIcon;	
	}

	## 상품정렬순서 실렉트 박스
	function sel_pd_order($sel=null){
		$array	= array(""=>"선택부분별 정렬","m1.Date@desc"=>"등록순 정렬","m1.Name@asc"=>"상품명순 정렬","m1.Hit@desc"=>"인기순 정렬");
		$arg[0]	= "class=\"form-control\" onChange=\"submit()\"";
		$this->common->mkselectmenu("sel_orderby", $array, $sel, $arg);
	}
	## 상품검색필드타이틀
	function sel_pd_stitle($sel=null){
		$array	= array(""=>"검색영역","m1.Name"=>"상품명");
		$arg[0]	= "class=\"form-control\"";
		$this->common->mkselectmenu("stitle", $array, $sel, $arg);
	}

	## 상품디스플레이 갯수
	function sel_pd_listno($sel=null){
		$array	= array(""=>"기본설정","8"=>"8개","16"=>"16개","32"=>"32개","all"=>"전체디스플레이");
		$arg[0]	= "class=\"form-control\"";
		$this->common->mkselectmenu("ShopListNo", $array, $sel, $arg);
	}
	
	## 상품상세보기 관련
	## 조회수 증가
	function add_hit($uid){
		$this->dbcon->_query("UPDATE wizMall SET Hit = Hit+1 WHERE UID=".$uid);
	}


	function getview($uid){## 상품상세보기정보 가져오기

		$sqlstr = "SELECT m1.*, m2.UID as cuid, m2.PID cpid ";
		$sqlstr .= " FROM wizMall m2 ";
		$sqlstr .= "left join wizMall m1 on m1.UID = m2.PID ";
		$sqlstr .= "left join wizMallExt e on e.mid = m1.UID ";
		$sqlstr .= "WHERE m2.UID='$uid'";

		$this->dbcon->_query($sqlstr);
		$view = $this->dbcon->_fetch_array();
		$view["source_id"]		= $view["UID"];//멀티로 인해 원상품의 아이디를 보관한다.
		$view["Name"]				= stripslashes($view["Name"]);
		$view["CompName"]		= stripslashes($view["CompName"]);
		$TextType					= explode("|", $view["TextType"]);//0:상세설명, 1:간략설명, 2:배송정보
		$view["Description1"]	= $this->common->gettrimstr($view["Description1"], $TextType[0]);
		$view["Description2"]	= $this->common->gettrimstr($view["Description2"], $TextType[1]);
		$view["Description3"]	= $this->common->gettrimstr($view["Description3"], $TextType[2]);
		$view["Model"]			= stripslashes($view["Model"]);

		$img_folder 				= substr($view["Category"], -3);
		$filename					= $view["filename"]; 

		//상품에 관한 모든 이미지를 가져온다.
		$viewimg = $this->get_pd_img($view["source_id"]);//$viewimg[2]:크기(중);
		//$view["imgsrc"]			= "./config/uploadfolder/productimg/".$img_folder."/".$viewimg[2];
		$view["imgsrc"]			= "./lib/img.php?imgname=".$viewimg[2]."&folder=".$img_folder;
		$view["viewimg"]			= $viewimg;
		$view["img_folder"]		= $img_folder;

		//카드결재가를 계산한다.
		if(!STRCMP($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_PER"))
		$CARDCHECK = $view["CHECK"]*(1 + $cfg["pay"]["CARDCHECK_RATE_VALUE1"]/100);
		else 
		$CARDCHECK = $view["Price"] + $cfg["pay"]["CARDCHECK_RATE_VALUE2"];
		$CARDCHECK = number_format($CARDCHECK);

		if (($view["Input"] && $view["Input"] <= $view["Output"]) || $view["None"] == '1' ) 
		$common->js_alert("\\n\\n품절된 제품입니다.. 관리자에게 문의하십시오.\\n\\n");

		return $view;
	}

	function getprenext($uid, $code){
		/* 이전제품 다음제품을 구한다 */
		$PRE_GOODS_STR = "SELECT UID FROM wizMall WHERE UID < '$uid' AND Category = '$code' ORDER BY UID DESC LIMIT 1"; 
		$prenext["pre"]["uid"] = $this->dbcon->get_one($PRE_GOODS_STR);

		$NEXT_GOODS_STR = "SELECT UID FROM wizMall WHERE UID > '$uid' AND Category = '$code' ORDER BY UID ASC LIMIT 1";
		$prenext["next"]["uid"] = $this->dbcon->get_one($NEXT_GOODS_STR);

		return $prenext;

		/* 실적용 예 
		다음상품 : <img src="./skinwiz/viewer/$cfg["skin"]["ViewerSkin"]/images/backbutton.jpg" width="117" height="33" onClick="javascript:location.replace('wizmart.php?query=view&code=$code&no=$prenext["pre"]["uid"]')" style="cursor:pointer">
		이전상품 : <img src="./skinwiz/viewer/$cfg["skin"]["ViewerSkin"]/images/nextbutton.jpg" width="117" height="33" onClick="javascript:location.replace('wizmart.php?query=view&code=$code&no=$prenext["next"]["uid"]')" style="cursor:pointer">
		*/
	}

	## 상세보기에서 이전 디렉토리로 가기
	function getpredir($code,$optionvalue){
		if($optionvalue){
			$link = "./wizmart.php?code=$code&query=option&optionvalue=$optionvalue&op=".$this->op;
		}else{
			$link = "./wizmart.php?code=$code&op=".$this->op;
		}
		return $link;
	}

	function get_pd_img($uid){## 등록된 이미지 가져오기
		$sqlstr = "select orderid, filename from wizMall_img where pid = ".$uid;
		$this->dbcon->_query($sqlstr);
		while($list = $this->dbcon->_fetch_array()):
			$orderid	= $list["orderid"];
			$filename	= $list["filename"];
			$viewimg[$orderid] = $filename;
		endwhile;
		return $viewimg;
	}

	function pd_write_estim($post,$from=null){## 상품평가하기
		$IP			= $REMOTE_ADDR;
		$GID		= $post["GID"];//원상품아이디
		$no			= $post["no"];//현상품아이디
		$ID			= $post["ID"] ? $post["ID"]:$cfg["member"]["mid"];
		$Name		= $post["Name"]? $post["Name"]:$cfg["member"]["mname"];
		$Passwd		= $post["Passwd"]? $post["Passwd"]:$cfg["member"]["mpasswd"];
		$Email		= $post["Email"];
		$Grade		= $post["Grade"];
		$Subject	= $post["Subject"];
		$Contents	= $post["Contents"];
		$TxtType	= $post["TxtType"]? $post["TxtType"]:0;
		$Count		= $post["Count"];
		
		$query		= $post["query"];
		$code		= $post["code"];
		if(!$GID){
			if($from == "pop"){
				$this->common->js_windowclose("잘못된 경로로 접근하였습니다.");
			}else{
				$this->common->js_alert("잘못된 경로로 접근하였습니다.");
			}
		}
		$sqlstr = "INSERT INTO wizEvalu (GID,ID,Name,Passwd,Email,Grade,Subject,Contents,TxtType,Count,IP,Wdate)
		VALUES('$GID','".$ID."','$Name','$Passwd','$Email','$Grade','$Subject','$Contents','$TxtType','$Count','$IP',".time().")"; 
		$this->dbcon->_query($sqlstr);
		
		if($from == "pop"){
			$this->common->js_windowclose("고객님의 상품평에 감사드립니다", "../../../wizmart.php?query=$query&code=$code&no=$no");
			echo "$from";
		}else{
			$this->common->js_alert("고객님의 상품평에 감사드립니다.","$PHP_SELF?query=$query&code=$code&no=$no");
		}
	}

	function get_mart_design($code){## 카테고리에서 사용자 정의 디자인을 가져온다
		$sqlstr = "select cat_top, cat_bottom from wizCategory where cat_no = '".$code."'";
		$list = $this->dbcon->get_row($sqlstr);
		$mart_skin["top"]		= trim($list["cat_top"]);
		$mart_skin["bottom"]	= trim($list["cat_bottom"]);
		
		if(!$mart_skin["top"]){##최상위 카테고리 정보를 불러온다.
			$sqlstr = "select cat_top, cat_bottom from wizCategory where length(cat_no) = 3 AND cat_no =  '".substr($code, -3)."'";
			$list = $this->dbcon->get_row($sqlstr);
			$mart_skin["top"]		= trim($list["cat_top"]);
			$mart_skin["bottom"]	= trim($list["cat_bottom"]);
		}

		return $mart_skin;
	}

	function get_mart_skin($code){ //카테고리 매장 분류에서 사용자 정의가 되어있어면 아래와 같이 실행된다.
		/* 1차 카테고리 스킨정의 */
		$sqlstr = "select cat_skin, cat_skin_viewer from wizCategory where length(cat_no) = 3 and  right(cat_no, 3) ='".substr($big_code, -3)."' and cat_flag = 'wizmall'";
		$list = $this->dbcon->get_row($sqlstr);
		if($list["cat_skin"]) $this->cfg["skin"]["ShopSkin"]			= $list["cat_skin"];
		if($list["cat_skin_viewer"]) $this->cfg["skin"]["ViewerSkin"]	= $list["cat_skin_viewer"];

		/* 2차 카테고리 스킨정의 */
		$sqlstr = "select cat_skin, cat_skin_viewer from wizCategory where length(cat_no) = 6 and  right(cat_no, 6) ='".substr($big_code, -6)."' and cat_flag = 'wizmall'";
		$list = $this->dbcon->get_row($sqlstr);
		if($list["cat_skin"]) $this->cfg["skin"]["ShopSkin"]			= $list["cat_skin"];
		if($list["cat_skin_viewer"]) $this->cfg["skin"]["ViewerSkin"]	= $list["cat_skin_viewer"];
		/* 정의된 shop-skin이 있으면 이것으로 skin을 바꾼다.*/
	}

	## 공동구매 관련

	function get_co_con($PriceQty){
		$tmp = explode("||", $PriceQty);
		foreach($tmp as $key=>$value){
			if(chop($value)){
				$split= explode(":" , chop($value));
				$rtn[$key]["price"]	= $split[0];
				$rtn[$key]["qty"]	= $split[1];
			}
		}
		return $rtn;
	}

	function get_co_price($co, $Output, $Price){
		if ($Output >= $co[2]["qty"]) $c_price = $co[2]["price"];
		else if ($Output >= $co[1]["qty"]) $c_price = $co[1]["price"];
		else if ($Output >= $co[0]["qty"])	$c_price = $co[0]["price"];
		else $c_price = $Price;
		return $c_price;
	}

	function insert_tag($value1, $value2){//두개의 값을 비교하여 특정테그를 넣는 함수
		if($value1 != $value2) echo number_format($value2);
		else echo "<b><font color=red>".number_format($value2)."</font></b>";							
	}

	function getpdimgpath($category, $filename, $path="./"){## 상품이미지 경로
		$fullpath = $path."config/uploadfolder/productimg/".substr($category, -3)."/".$filename;
		return $fullpath;
	}

	//상품 등록 옵션을 가져와서 배열로 저장한다.
	function getpdoption(){
		$sqlstr = "select uid, op_name, op_icon_image from wizpdoption order by uid asc";
		$rtn	= $this->dbcon->get_rows($sqlstr);
		return $rtn;
	}
}