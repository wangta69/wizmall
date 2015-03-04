<?php
//$realpath	=  realpath(__FILE__);

require_once realpath(dirname(__FILE__) . '/cfg.common.php');
require_once realpath(dirname(__FILE__) . '/../config/cfg.core.php');
require_once realpath(dirname(__FILE__) . '/../config/db_info.php');
require_once realpath(dirname(__FILE__) . '/../config/common_array.php');
require_once realpath(dirname(__FILE__) . '/class.database.php');
$dbcon		= new database($cfg["sql"]);

require_once realpath(dirname(__FILE__) . '/class.image.php');
$Image		= new Image();

require_once realpath(dirname(__FILE__) . '/class.common.php');
$common = new common();
$common->cfg=$cfg;
$common->pub_path = "./";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮
$common->get_object($dbcon, $Image);

require_once realpath(dirname(__FILE__) . '/class.member.php');
$member		= new member();
$member->get_object($dbcon, $common);