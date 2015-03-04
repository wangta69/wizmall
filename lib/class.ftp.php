<?php
	/**********************************************************
	* 이미지 파일 FTP 올리기
	**********************************************************/


	// 이미지 인지 확인
	if(!eregi("image", $_FILES[file][type][$img_idx])) {
		alert_msg("이미지만 업로드 가능합니다.");
		exit;
	}

	if($_FILES[file][size][$img_idx] > $max_size) {
		alert_msg(" $max_size 사이즈 이하로 업로드 가능합니다.");
		exit;
	}

	// 화일명과 확장자 분리
	$name_array = explode("." , $_FILES[file][name][$img_idx]);

	// 확장자가 맞는지 확인 BMP 팅겨낸다.
	if($name_array[(count($name_array)-1)] != "jpg" && $name_array[(count($name_array)-1)] != "JPG" && $name_array[(count($name_array)-1)] != "gif" && $name_array[(count($name_array)-1)] != "GIF"){
		alert_msg("jpg, gif 화일만 가능합니다.");
		exit;
	}


	// 확장자가 맞는지 확인 BMP 팅겨낸다.
	if($name_array[(count($name_array)-1)] != "jpg" && $name_array[(count($name_array)-1)] != "JPG" && $name_array[(count($name_array)-1)] != "gif" && $name_array[(count($name_array)-1)] != "GIF"){
		alert_msg("jpg, gif 화일만 가능합니다.");
		exit;
	}

	$file_name = $name_array[0];
	$file_extension = $name_array[1];

	$new_file_name = time().$img_idx.".".$file_extension;

	
	######################################################################
	# FTP 로 이미지를 올린다.
	######################################################################
		
	//원격서버에 연결한다. 
	if(!($fc = ftp_connect($Server_Host, $Server_Port))) 
	{
		alert_msg("부하로 인해 늦어지고있습니다.\\n\\n잠시후 이용해주시기 바랍니다!");
		exit;
	}

	// passv 모드 변경 왜 해야하는지 모름 그래야 업로드됨 ..
	//ftp_pasv($fc, true);

	//원격서버에 로그인한다. 
	if(!ftp_login($fc, $Server_Id, $Server_Pw)) 
	{
		alert_msg("부하로 인해 늦어지고있습니다.\\n\\n잠시후 이용해주시기 바랍니다!!");
		exit;
	}

	// 첫번째 경로 바꿔서 생성
	$dir = "/".$Server_Id."/" . $ImgDir;

	// 처음 디렉토리가 있는지 없는지 없으면 생성
	if(!@ftp_chdir($fc, $dir)) {
	  
	  if(!ftp_mkdir($fc, $dir)){ // 첫번째 경로가 없으면 생성
		alert_msg("업로드에 실패 했습니다.\\n\\n관리자에게 문의 하세요!");
		exit;
	  }

	  if(!ftp_chdir($fc, $dir)){ // 생성후 경로 변경
		alert_msg("업로드에 실패 했습니다.\\n\\n관리자에게 문의 하세요!!");
		exit;
	  }

	}

	
	// 두번째 경로 바꿔서 생성
	$dir = "/".$Server_Id."/" . $ImgDir . "/" . $ImgDate;

	// 두번째 디렉토리가 있는지 없는지 없으면 생성
	if(!@ftp_chdir($fc, $dir)) {
	  
	  if(!ftp_mkdir($fc, $dir)){ // 첫번째 경로가 없으면 생성
		alert_msg("업로드에 실패 했습니다.\\n\\n관리자에게 문의 하세요!");
		exit;
	  }

	  if(!ftp_chdir($fc, $dir)){ // 생성후 경로 변경
		alert_msg("업로드에 실패 했습니다.\\n\\n관리자에게 문의 하세요!!");
		exit;
	  }

	}


	// 파일 업로드
	if(!ftp_put($fc, "./".$new_file_name, $_FILES[file][tmp_name][$img_idx], FTP_BINARY))
	{ 
		alert_msg("파일을 지정한 디렉토리로 복사 하는 데 실패했습니다.");
		//ftp_pasv($fc,FALSE);
		exit; 
	}


	//ftp_pasv($fc,FALSE);

	// 임시파일 삭제
	unlink($_FILES[file][tmp_name][$img_idx]);
	
	// FTP 닫자
	ftp_quit($fc);
	######################################################################
