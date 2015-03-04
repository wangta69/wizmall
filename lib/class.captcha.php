<?php
class captcha{

	
	
	public function __construct() {
		session_start();
	}
		
	/**
	 * Generate Random String with MD5
	 */
	public function setcaptcha(){
		$tmp_str = substr(md5(time()),0,10);

		// Generate random
		list($usec, $sec) = explode(' ', microtime()); 
		$seed =  (float)$sec + ((float)$usec * 100000); 
		srand($seed);
		$keylen = strlen($tmp_str);
		$div = (int)($keylen / 2);
		
		while (count($arr) < 3) 
		{
			unset($arr);
			for ($i=0; $i<$keylen; $i++) 
			{
				$rnd = rand(1, $keylen);
				$arr[$rnd] = $rnd;
				if ($rnd > $div) break;
			}
		}


		sort($arr);

		$norobot_str		= "";
		$norobot_key	= "";
		$m = 0;
		for ($i=0; $i<count($arr); $i++) 
		{
			for ($k=$m; $k<$arr[$i]-1; $k++)  $norobot_str .= $tmp_str[$k];
			$norobot_str .= '<font size="3" color="#FF0000"><b>'.$tmp_str[$k].'</b></font>';
			$norobot_key .= $tmp_str[$k];
			$m = $k + 1;
		}

		if ($m < $keylen) {
			for ($k=$m; $k<$keylen; $k++)
				$norobot_str .= $tmp_str[$k];
		}
		$_SESSION["ss_norobot_key"]	= $norobot_key;
		
		return $norobot_str;
	}

	/**
	 * Check if Posted captcha is Session captcha 
	 * @param $params Array array("in_captcha"=>"'")\
	 * @return Boolean 
	 */
	public function chk_captcha($params){
		$ss_norobot_key	= $_SESSION["ss_norobot_key"];
		
		$rtn	= false;
		if( trim($params["in_captcha"]) && $ss_norobot_key == $params["in_captcha"]){
			$rtn = true;
			$_SESSION["ss_norobot_key"]	= $ss_norobot_key = "";
		} 
		return $rtn;
	}

		

}