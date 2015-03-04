<?php
include_once "../../lib/cfg.common.php";
include_once "../../config/cfg.core.php";
include_once "../../config/db_info.php";
include_once "../../config/common_array.php";

include_once "../../lib/class.database.php";
$dbcon		= new database($cfg["sql"]);

include_once "../../lib/class.image.php";
$Image		= new Image();

include "../../lib/class.common.php";
$common = new common();
$common->cfg=$cfg;
$common->pub_path = "../../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮
$common->get_object($dbcon, $Image);

include_once "../../lib/class.member.php";
$member		= new member();
$member->get_object($dbcon, $common);