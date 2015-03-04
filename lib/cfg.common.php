<?php
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
//header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


/*
|---------------------------------------------------------------
| PHP ERROR REPORTING LEVEL
|---------------------------------------------------------------
| For more info visit:  http://www.php.net/error_reporting
|
*/
//error_reporting(0);//Turn off all error reporting
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', On);
if (!isset($set_time_limit)) $set_time_limit = 0;
@set_time_limit($set_time_limit);


//session 관련 설정
//ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
//ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화
$doc_root = $_SERVER["DOCUMENT_ROOT"];

if(is_dir($doc_root."/config/session")) session_save_path($doc_root."/config/session");
if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");


ini_set("session.cache_expire", 300); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 1440); // session data의 gabage collection 존재 기간을 지정 (초
session_set_cookie_params(0, "/");
@session_start();


if (strpos($system_folder, '/') === FALSE)
{
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
	{
		$system_folder = realpath(dirname(__FILE__)).'/'.$system_folder;
	}
}
else
{
	$system_folder = str_replace("\\", "/", $system_folder); 
}

define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');

$cfg['base_url']	= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$cfg['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
$cfg['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

$cfg["common"]["lan"]			= "utf-8";
$cfg["common"]["ver"]			= "6.6.8";
$cfg["common"]["mempwd"]		= "PASSWORD";//회원 패스워드를 암호화 하여 설정(사용안할 경우 주석처리)
$cfg["common"]["memjumin"]		= "PASSWORD";//회원 주민번호를 암호화 하여 설정(사용안할경우 주석처리)

## html head 및 doctype 설정
header("Content-Type: text/html; charset=".$cfg["common"]["lan"]);
$doctype = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
$doctype .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

// 짧은 환경변수를 지원하지 않는다면
if (isset($HTTP_POST_VARS) && !isset($_POST)) {
	$_POST		= &$HTTP_POST_VARS;
	$_GET		= &$HTTP_GET_VARS;
	$_SERVER	= &$HTTP_SERVER_VARS;
	$_COOKIE	= &$HTTP_COOKIE_VARS;
	$_ENV		= &$HTTP_ENV_VARS;
	$_FILES		= &$HTTP_POST_FILES;
    if (!isset($_SESSION))
		$_SESSION	= &$HTTP_SESSION_VARS;
}

if (phpversion() >= 4.2) {//global on/off 에 관계없이 모든 변수 받기(보안상 허점 노출 될 수 있음, 사용하지 않는 방향으로 프로그램 변경예정)
   if (count($_POST))	extract($_POST, EXTR_PREFIX_SAME, 'VARS_');
   if (count($_GET))	extract($_GET, EXTR_PREFIX_SAME, '_GET');
   if (count($_SERVER))	extract($_SERVER, EXTR_PREFIX_SAME, 'SERVER_');
   if (count($_FILES))	extract($_FILES, EXTR_PREFIX_SAME, 'FILES_' );
   if (count($_ENV))	extract($_ENV, EXTR_PREFIX_SAME, 'ENV_');
   if (count($_COOKIE))	extract($_COOKIE, EXTR_PREFIX_SAME, 'COOKIE_');
   if (count($_SESSION))extract($_SESSION, EXTR_PREFIX_SAME, 'SESSION_');
}


if( !get_magic_quotes_gpc() ){//magic_quotes_gpc 값이 FALSE 인 경우 addslashes() 적용
	if( is_array($_GET) )
	{
		while( list($k, $v) = each($_GET) )
		{
			if( is_array($_GET[$k]) )
			{
				while( list($k2, $v2) = each($_GET[$k]) )
				{
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			}
			else
			{
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}

	if( is_array($_POST) )
	{
		while( list($k, $v) = each($_POST) )
		{
			if( is_array($_POST[$k]) )
			{
				while( list($k2, $v2) = each($_POST[$k]) )
				{
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			}
			else
			{
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}

	if( is_array($_COOKIE) )
	{
		while( list($k, $v) = each($_COOKIE) )
		{
			if( is_array($_COOKIE[$k]) )
			{
				while( list($k2, $v2) = each($_COOKIE[$k]) )
				{
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			}
			else
			{
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}

//보안적용
	if( is_array($_GET) )
	{
		while( list($k, $v) = each($_GET) )
		{
			if(!is_array($v)){//�迭�ϰ�� �ٸ� ��� ����ȴ�.
				$_GET[$k]	= sqlInjection($v);
				${$k}		= sqlInjection($v);
			}
		}

		@reset($_GET);
	}

	if( is_array($_POST) )
	{
		
		while( list($k, $v) = each($_POST) )
		{
			if(!is_array($v)){//�迭�ϰ�� �ٸ� ��� ����ȴ�.
			//�Խù��̳� ��ǰ����� ���� ��ũ ������ �ٲٴ� ���� �߻� ������ �Ʒ� ����... �����?
				//$_POST[$k]	= sqlInjection($v);
				//${$k}		= sqlInjection($v);
			}
		}
		@reset($_POST);
	}
//보안관련 설정
function sqlInjection($string){
	//sqlInjection 관련 처리
	//http와 같은 경우는 url경로로 사용할수도 있으므로 추후 이부분은 별도 처리한다.
	//�Ϻ� Ű���忡�� �����̽��� �R���μ� �ణ�� �����Ӱ� ����
	$badWord				= array("/delete/i", "/update/i", "/select/i", "/union/i", "/insert/i", "/drop/i", "/ascii/i", "/substr/i", "/database/i", "/--/i", "/benchmark/i", "/lpad/i", "/rpad/i", "/length/i", "/set/i", "/where/i", "/#(%23)/i");//, "/http/i"
	$reaplaceWord	= array("del ete", "up date", "sel ect", "uni on", "in sert", "d rop", "as cii", "sub str", "data base", "- -", "bench mark", "l pad", "r pad", "leng th", "s et", "wh ere",  "#(% 23)");//, "/http/i"
	foreach($badWord as $key=>$val){
		$string = preg_replace($val, $reaplaceWord[$key], $string);
	}

	//��Ÿ �� ��� ���ٿ� ���� ó��
	$badURL = array("/[\.]{3,}\//i", "/[\/]{2,}/i", "/[\.]{3,}/i", "/[\.]{2,}/i");
	foreach($badURL as $key){
		if(!preg_match('/http/', $string)){//eregi -> preg_match
			$string = preg_replace($key, "__", $string);
		}
	}
	return $string;
}