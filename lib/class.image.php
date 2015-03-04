<?php
## 제작자 : 폰돌
## http://www.shop-wiz.com

## 실 사용
## $mymark = new Image();
## $mymark->font_path = '/font/arial.TTF';//폰트명은 서버에 올리신후 사용 , Must Be TrueType fonts
## $mymark->font_size = 30;   //폰트크기
## $mymark->font_x = 190; // 폰트위치 x
## $mymark->font_y = 365; // 폰트위치 y
## $mymark->font_color = array(0=>array("0","0","0"));//폰트색상
## $mymark->dst_x=200; //출력이미지 width 크기값
## $mymark->dst_y=200; //출력이미지 높이값
## $mymark->savefile = "good.jpg";//워터마크적용후 저장할 이름
## $mymark->impressWaterMark('jpeg','./pimg.jpg','류영형');

class Image {  
	
	var $font_size = 15;   //폰트 크기
	var $font_path = 'arial.ttf'; //Must Be TrueType fonts
	var $xpad = 20;  //이미지 x padding
	var $ypad = 20;  //이미지 y padding
	var $font_x; //폰트 위치 x
	var $font_y; //폰트 위치 y
	var $font_color = array(
					"0"=>array("0","0","0"), 
					"1"=>array("255","255","255")
					);//폰트 칼라
	var $dst_x; //출력이미지 width 크기값
	var $dst_y; //출력이미지 height 크기값
	var $savefile = "";
	


	//워터마크 만들기(텍스트형)
	function impressWaterMark($type,$image,$string = null) {   
		//$type = strtolower($type);   // 이후 $type은 삭제
		$src_info = getimagesize($image); 
		//현재 EUC-KR 일경우 아래 부분을 활성화 시킨다.
		//$string = iconv("EUC-KR", "UTF-8", $string);
		
		$src_im = $this->imagecreatefrom($src_info[2], $image);##소스이미지 생성
		
		//출력 이미지 크기 설정
		$src_x = imagesx($src_im);
		$src_y = imagesy($src_im);
		$dst_x = $this->dst_x ? $this->dst_x : $src_x;   
		$dst_y = $this->dst_y ? $this->dst_y : $src_y; 
				
		// string 이 없을 경우 기본 이미지를 출력하고 중지한다.
		
		if($string === null) {   //타입까지 맞아야 트루
			switch($src_info[2]){
				case 1: imagegif($src_im); break;   # gif
				case 2: imagejpeg($src_im); break;  # jpg
				case 3: imagepng($src_im); break;   # png
			}   
			imagedestroy($dst_im);   
			return;   
		} 
		  
		//출력용 이미지 생성
		$dst_im = @imagecreatetruecolor($dst_x, $dst_y); 
		if (empty($dst_im)) return false; 
		$background_color = @imagecolorallocate($dst_im, 255, 255, 255); 
		if (empty($background_color)) return false; 
		
		imagefilledrectangle($dst_im, 0, 0, $dst_x, $dst_y, $background_color);

		//폰트 박스 만들기
		$_font_size = imagettfbbox($this->font_size,50,$this->font_path,$string);   
		
		//imagettfbbox ( float $size , float $angle , string $fontfile , string $text )
		$dx = abs($_font_size[2]-$_font_size[0]);   
		$dy = abs($_font_size[5]-$_font_size[3]);   
		
		
		//폰트 출력위치 선정
		$font_x = $this->font_x ? $this->font_x : (int)($this->xpad/2);   
		$font_y = $this->font_y ? $this->font_y : $dy+(int)($this->ypad/2); 		
			
		//font 입력이 여러개면 워터 마크 기능을 위해 여러번 찍어준다
		foreach($this->font_color as $key=>$value){
			$color_R = $value[0];
			$color_G = $value[1];
			$color_B = $value[2];
			$Fontshift = $key*(-1);
			$fontColor = imagecolorallocate($dst_im,$color_R,$color_G,$color_B); 
			imagettftext($src_im,$this->font_size,0,$font_x+$Fontshift,$font_y+$Fontshift,$fontColor,$this->font_path,$string);
			//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
		}


		imagecopyresampled($dst_im, $src_im,0, 0, 0, 0, $dst_x, $dst_y, $src_x, $src_y);
		//bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
		 
		 //bool imagejpeg ( resource $image [, string $filename [, int $quality ]] )//$filename 이 없을 경우 브라우저 출력

		switch($src_info[2]){  
			case 1: #gif 
				if($this->savefile) imagegif($dst_im, $this->savefile); 
				else imagegif($dst_im); 
			break;   
			case 2: #jpg
				if($this->savefile) imagejpeg($dst_im, $this->savefile);
				else imagejpeg($dst_im); 
			break;   
			case 3: #png
				if($this->savefile) imagepng($dst_im, $this->savefile);
				else imagepng($dst_im); 
			break;   
		}   
		chmod($this->savefile, 0606); 
		imagedestroy($dst_im);   
		imagedestroy($src_im);   
	} 
	

	

/*-----------------------------------------------------------------------------  
-----------------------------------------------------------------------------*/ 
	function imageWaterMaking($src_img, $logo_img, $img_quality = 90){ ## 이미지 merg 용 watermark
		## src_img : 원본이미지(대상이미지), $logo_img : 워터마크 입힐 로고(이미지)-투명gif 나 png 권장, $img_quality: 이미지 생성시 quality 
		$src_info = getimagesize($src_img); 
		$logo_info = getimagesize($logo_img); 

		if(!$src_info[0]) return ARRAY(false, "원본이미지가 없습니다.!"); ## 원본이미지 검사
		if(!$logo_info[0]) return ARRAY(0, "로고이미지가 없습니다."); ##로고이미지 검사


		$src_im = $this->imagecreatefrom($src_info[2], $src_img);##소스이미지 생성

		$logo_im = $this->imagecreatefrom($logo_info[2], $logo_img);##로고이미지 생성
		
		# logo가 위치할 포지션 구하기(기본 : 중앙)
		$position_x = ($src_info[0] - $logo_info[0]) / 2; 
		$position_y = ($src_info[1] - $logo_info[1]) / 3 * 2.5; 

		#현재의 이미지를 그리고 새로 리사이징 하기
		imagecopyresized($src_im, $logo_im, $position_x, $position_y, 0, 0, imagesx($logo_im), imagesy($logo_im), imagesx($logo_im), imagesy($logo_im)); 

		#####----- 이미지 저장 -----##### 
		switch($src_info[2]){ 
			case 1 : $result = @imagegif($src_im, $src_img, $img_quality);break; 
			case 2 : $result = @imagejpeg($src_im, $src_img, $img_quality);break; 
			case 3 : $result = @imagepng($src_im, $src_img, $img_quality);break; 
			default : return ARRAY(0, "워터 마크를 생성하는 중 오류가 허용되지 않은 포맷으로 인해 오류가 발생하였습니다."); 
		} 

		if($result) return ARRAY(1, "success");
		else return ARRAY(0, "워터마크 생성중 오류가 발생하였습니다."); 
	} 


#	$file : 소스파일 풀경로
#	$save_filename : 저장될 파일명. 
#	$save_path :  저장될 경로 
#	$max_width = 100;  // 저장될 이미지 가로 
#	$max_height = 100;  // 저장될 이미지 세로 
  
#	thumnail($user_file, $save_filename, $save_path, $max_width, $max_height, filename);  // 셈네일 이미지 저장 

	function thumnail($file, $save_path, $max_width, $max_height, $filename){
	
		   $img_info = getImageSize($file);
		   $save_filename = $filename;
		   switch($img_info[2]){
				case (1):$src_img = ImageCreateFromGif($file);break;
				case (2):$src_img = ImageCreateFromJPEG($file);break;
				case (3):$src_img = ImageCreateFromPNG($file);break;
				case (6):$src_img = imagecreatefrombmp($file);break;
				case (15):$src_img = imagecreatefromwbmp($file);break;
				default:return 0;break;
		   }
		   //echo "src_img:".$src_img."</br>";

		   $img_width	= $img_info[0];
		   $img_height	= $img_info[1];
	
		   if($img_width > $max_width || $img_height > $max_height)
		   {
				$width_ratio	= $max_width/$img_width;
				$height_ratio	= $max_height/$img_height;

				if($width_ratio >= $height_ratio){
					$dst_width	= $max_height * $img_width / $img_height;
					$dst_height	= $max_height;
				}else{
					$dst_width	= $max_width;
					$dst_height	= $max_width * $img_height / $img_width;
				}
		   }else{
				  $dst_width = $img_width;
				  $dst_height = $img_height;
		   }
		   if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
		   if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;
	
		   if($img_info[2] == 1) 
		   {
				  $dst_img = imagecreate($max_width, $max_height);
		   }else{
				  $dst_img = imagecreatetruecolor($max_width, $max_height);
		   }
	

		 $bgc = imagecolorallocate($dst_img, 255, 255, 255);
  //$bgc = imagecolorallocate($dst_img, 62, 62, 62);
		   imagefilledrectangle($dst_img, 0, 0, $max_width, $max_height, $bgc); 
		   imagecopyresampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, imagesx($src_img),imagesy($src_img));	   
		   switch($img_info[2]){
				case (1):
				  imageinterlace($dst_img);
				  //echo $dst_img.", ".$save_path."/".$save_filename;
				  imagegif($dst_img, $save_path."/".$save_filename);
				break;
				case (2):
				  imageinterlace($dst_img);
				  imagejpeg($dst_img, $save_path."/".$save_filename,85); //ImageJPEG($dst_img, $save_path.$save_filename);
				break;
				case (3):
					imagepng($dst_img, $save_path."/".$save_filename, 9);
				break;
				case (6):
					imagebmp($dst_img, $save_path."/".$save_filename);
				break;
				case (15):
					imagewbmp($dst_img, $save_path."/".$save_filename);
				break;
		   }
		   ImageDestroy($dst_img);
		   ImageDestroy($src_img);
		   return $save_filename;
	} 
	
	function imagecreatefrom ($imgtype, $image){
		switch($imgtype){ ##소스이미지 생성
			case 1 : $src_im = imagecreatefromgif($image); break; # gif
			case 2 : $src_im = imagecreatefromjpeg($image); break; # jpg
			case 3 : $src_im = imagecreatefrompng($image); break; # png
			default : return false; 
		}
		return $src_im;
	} 	
}


/**
 * Creates function imagecreatefrombmp, since PHP doesn't have one
 * @return resource An image identifier, similar to imagecreatefrompng
 * @param string $filename Path to the BMP image
 * @see imagecreatefrompng
 * @author Glen Solsberry <glens@networldalliance.com>
 */
if (!function_exists("imagecreatefrombmp")) {
	function imagecreatefrombmp( $p_sFile ) {
	 $file    =    fopen($p_sFile,"rb");
    $read    =    fread($file,10);
    while(!feof($file)&&($read<>""))
        $read    .=    fread($file,1024);
    $temp    =    unpack("H*",$read);
    $hex    =    $temp[1];
    $header    =    substr($hex,0,108);
    if (substr($header,0,4)=="424d")
    {
        $header_parts    =    str_split($header,2);
        $width            =    hexdec($header_parts[19].$header_parts[18]);
        $height            =    hexdec($header_parts[23].$header_parts[22]);
        unset($header_parts);
    }
    $x                =    0;
    $y                =    1;
    $image            =    imagecreatetruecolor($width,$height);
    $body            =    substr($hex,108);
    $body_size        =    (strlen($body)/2);
    $header_size    =    ($width*$height);
    $usePadding        =    ($body_size>($header_size*3)+4);
    for ($i=0;$i<$body_size;$i+=3)
    {
        if ($x>=$width)
        {
            if ($usePadding)
                $i    +=    $width%4;
            $x    =    0;
            $y++;
            if ($y>$height)
                break;
        }
        $i_pos    =    $i*2;
        $r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]);
        $g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]);
        $b        =    hexdec($body[$i_pos].$body[$i_pos+1]);
        $color    =    imagecolorallocate($image,$r,$g,$b);
        imagesetpixel($image,$x,$height-$y,$color);
        $x++;
    }
    unset($body);
    return $image;
	}
	/*
	function imagecreatefrombmp( $filename ) {
		$file = fopen( $filename, "rb" );
		$read = fread( $file, 10 );
		while( !feof( $file ) && $read != "" )
		{
			$read .= fread( $file, 1024 );
		}
		$temp = unpack( "H*", $read );
		$hex = $temp[1];
		$header = substr( $hex, 0, 104 );
		$body = str_split( substr( $hex, 108 ), 6 );
		if( substr( $header, 0, 4 ) == "424d" )
		{
			$header = substr( $header, 4 );
			// Remove some stuff?
			$header = substr( $header, 32 );
			// Get the width
			$width = hexdec( substr( $header, 0, 2 ) );
			// Remove some stuff?
			$header = substr( $header, 8 );
			// Get the height
			$height = hexdec( substr( $header, 0, 2 ) );
			unset( $header );
		}
		$x = 0;
		$y = 1;
		$image = imagecreatetruecolor( $width, $height );
		foreach( $body as $rgb )
		{
			$r = hexdec( substr( $rgb, 4, 2 ) );
			$g = hexdec( substr( $rgb, 2, 2 ) );
			$b = hexdec( substr( $rgb, 0, 2 ) );
			$color = imagecolorallocate( $image, $r, $g, $b );
			imagesetpixel( $image, $x, $height-$y, $color );
			$x++;
			if( $x >= $width )
			{
				$x = 0;
				$y++;
			}
		}
		return $image;
	}

	*/
}
if (!function_exists("imagebmp")) {
	function imagebmp ($im, $fn = false)
	{
		if (!$im) return false;
				
		if ($fn === false) $fn = 'php://output';
		$f = fopen ($fn, "w");
		if (!$f) return false;
				
		//Image dimensions
		$biWidth = imagesx ($im);
		$biHeight = imagesy ($im);
		$biBPLine = $biWidth * 3;
		$biStride = ($biBPLine + 3) & ~3;
		$biSizeImage = $biStride * $biHeight;
		$bfOffBits = 54;
		$bfSize = $bfOffBits + $biSizeImage;
				
		//BITMAPFILEHEADER
		fwrite ($f, 'BM', 2);
		fwrite ($f, pack ('VvvV', $bfSize, 0, 0, $bfOffBits));
				
		//BITMAPINFO (BITMAPINFOHEADER)
		fwrite ($f, pack ('VVVvvVVVVVV', 40, $biWidth, $biHeight, 1, 24, 0, $biSizeImage, 0, 0, 0, 0));
				
		$numpad = $biStride - $biBPLine;
		for ($y = $biHeight - 1; $y >= 0; --$y)
		{
			for ($x = 0; $x < $biWidth; ++$x)
			{
				$col = imagecolorat ($im, $x, $y);
				fwrite ($f, pack ('V', $col), 3);
			}
			for ($i = 0; $i < $numpad; ++$i)
				fwrite ($f, pack ('C', 0));
		}
		fclose ($f);
		return true;
	}
}