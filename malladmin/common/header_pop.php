<?php
include "../../lib/inc.depth2.php";

include "../../lib/class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common, $mall);

include ("../AUTH_CHECK.php");
