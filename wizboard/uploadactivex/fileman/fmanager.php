<?
function GetFileSize($size){
	if($size<1024) return (intval($size) . " Bytes");
	else if($size >1024 && $size< 1024 *1024)  {
		return sprintf("%0.1f KB",$size / 1024);
	}else return sprintf("%0.2f MB",$size / (1024*1024));
	
}

function isHangulString($name){

	for($i = 0; $i < strlen($name); $i++) { 
	   if(ord($name[$i]) >= 0x80) {
		return 1;
		exit; 
	   }
	}

	return 0;
}

function GetFileExt($sFileName){

	if(strpos($sFileName,".")==false) return "";


	$aTemp=explode(".",strtolower($sFileName));

    $iTemp1=count($aTemp)-1;

    return trim($aTemp[$iTemp1]);

}
	

function DeleteDir($sPath){
	

	$sTempDir=$sPath;

	if(is_dir($sTempDir)){

		$hDir=opendir($sTempDir);

		while($sFileName=readdir($hDir)){
			
			if($sFileName!="." and $sFileName!=".."){

				if(is_dir($sTempDir."/".$sFileName)){
					
					DeleteDir($sTempDir."/".$sFileName);

				}else{
			
					unlink($sTempDir."/".$sFileName);

				}

				clearstatcache();
			}

		}//end of while

		closedir($hDir);
		
		rmdir($sPath);	


	}else{
		unlink($sTempDir);
	}


}

	$SEP_CHAR="*";


	$WEBDISK_ROOT_DIR=realpath("./")."/test/";
	
	$ROOT_DIR=$WEBDISK_ROOT_DIR;

	
	if(trim($uid)!="")$ROOT_DIR.=$uid."/";


	if(!(is_dir($ROOT_DIR) )){

		mkdir($ROOT_DIR, 0777 );
		chmod($ROOT_DIR, 0777 );

	}//end of if


	if($mode=="")$mode="list";

	$mode=strtoupper($mode);


	switch($mode){

		case "LIST":

			$sList="";

			if($source=="/")$source="";

			$AcessDir=$ROOT_DIR.$source;


			$hDir=opendir($AcessDir);

			while($sFileName=readdir($hDir)){
				
				$sTempDir=$AcessDir.$sFileName;
				
			
				if(is_dir($sTempDir)){
					
					$iFileDate=filemtime($sTempDir);
				
					$sFileDate=date("Y-m-d h:i:s",$iFileDate);

					if(trim($sFileName)!="." and trim($sFileName)!=".."){
						$sList.= $sFileName."/".$SEP_CHAR.$SEP_CHAR.$sFileDate.$SEP_CHAR;
					}
				
				}else{

					$sFileSize=GetFileSize(filesize($sTempDir));
				
					$iFileDate=filemtime($sTempDir);
				
					$sFileDate=date("Y-m-d h:i:s",$iFileDate);

			
					$sList.= $sFileName.$SEP_CHAR.$sFileSize.$SEP_CHAR.$sFileDate.$SEP_CHAR;

				}

				clearstatcache();

			}//end of while

			echo $sList;

			clearstatcache();

			closedir($hDir);


		break;//end of LIST

		case "UPLOAD":


			if($base=="/")$base="";
			if($dir=="/")$dir="";

			$AcessDir=$ROOT_DIR.$base;

			
			if($dir!=""){

				$sTempDir=$AcessDir;

				$aTemp=explode("/",strtolower($dir));

				for($i=0;$i<=count($aTemp)-1;$i++){

					if(trim($aTemp[$i])!=""){

						$sTempDir.=$aTemp[$i];

						if(!(is_dir($sTempDir) )){

							mkdir($sTempDir, 0777 );
							chmod($sTempDir, 0777 );

						}//end of if

						$sTempDir.="/";

					}//end of if

				}//end of for
			
			}//end of if

			
			$varname = "UPLOADFILE";
			$varname_name = "UPLOADFILE_name";
			$varname_type = "UPLOADFILE_type";
			$varname_size = "UPLOADFILE_size";


			if($$varname == "" || $$varname == "none"){
				break;
			} 

			$$varname=str_replace("\\\\","\\", $$varname);


			$sFileName1=basename($$varname_name);
/*
			//리눅스 코드 (서버가 한글 파일명과 파일명 사이에 공백을 지원하지 않는 운영체제 일 경우...

			//Linux에서는 파일명에 공백문자를 지원하지 않으므로 _(언더바)로 대체한다.
			$sFileName1=str_replace(" ","_",basename($$varname_name));

			//Linux에서는 한글도 안된다.
			if(isHangulString($sFileName1)){

				$uid = md5(uniqid(rand()));
				
				$sFileName1=$uid.".".GetFileExt(basename($sFileName1));

			}
*/



			$sTempDir=$AcessDir.$dir.$sFileName1;
			
			copy($$varname,$sTempDir);


		break;//end of UPLOAD

		case "DOWNLOAD":

			if($source=="/")$source="";

			$AcessDir=$ROOT_DIR.$source;
			
			$sTempDir=$AcessDir.$filename;

			if(is_file($sTempDir)){

				header("Content-Type: application/octet-stream;"); 
				Header("Content-Transfer-Encoding: binary");
				header("Content-disposition: inline; filename=\"$filename\"");
				header("Content-Length: ".filesize($sTempDir)); 
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Pragma: no-cache"); 

				echo readfile($sTempDir);
			}

		break;//end of DOWNLOAD

		
		
		case "DELETE":
		
			//mode, source, filename : Query
			
			if($source=="/")$source="";

			$AcessDir=$ROOT_DIR.$source;
			
			$sTempDir=$AcessDir.$filename;
			
			DeleteDir($sTempDir);


		break;//end of DELETE

		case "FILESIZE":
   
		if($source=="/")$source="";

			$AcessDir=$ROOT_DIR.$source;

			$sTempDir=$AcessDir.$filename;

			$i=filesize($sTempDir);

			if($i<1)$i=0;

		echo $i;



		break;//


		case "MKDIR":

			//mode, base, dir : Query

			if($base=="/")$base="";
			if($dir=="/")$dir="";

			$AcessDir=$ROOT_DIR.$base;
			
			if($dir!=""){

				$sTempDir=$AcessDir;

				$aTemp=explode("/",strtolower($dir));

				for($i=0;$i<=count($aTemp)-1;$i++){

					if(trim($aTemp[$i])!=""){

						$sTempDir.=$aTemp[$i];


						if(!(is_dir($sTempDir) )){

							mkdir($sTempDir, 0777 );
							chmod($sTempDir, 0777 );

						}//end of if

						$sTempDir.="/";

					}//end of if

				}//end of for
			
			}//end of if

		break;//end of MKDIR

	}//end of switch
	
?>
