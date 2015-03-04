<!DOCTYPE html>
<html lang="kr">
<head>
<meta charset="<?php echo $cfg["common"]["lan"]?>">
<title>무료 쇼핑몰 솔루션 - 숍위즈(http://www.shop-wiz.com)</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"];?>" />

<link rel="stylesheet" href="./css/mall.css" type="text/css" />
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/wizmall.js"></script>
<link type="text/css" rel="stylesheet" href="./js/bootstrap/css/mallbootstrap.css">
<script type="text/javascript" src="./js/bootstrap/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="./js/bootstrap/css/basic.css">
<link type="text/css" rel="stylesheet" href="./css/base.css" />
<link type="text/css" rel="stylesheet" href="./css/common.css" />
<!--[if lt IE 8]>
    <link href="/js/bootstrap/css/bootstrap-ie7.css" rel="stylesheet">
<![endif]-->
<!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
	<?php echo get_topgnb(); ?>
	<div class="container"><!-- 전체 레이아웃 감쌈 -->
		<div class="container bs-docs-container">
			<div class="row">
				<div class="col-left">
					<?php echo get_sider(); ?>
					<!-- menu include -->
				</div><!-- col-lg-3 -->
			<div class="col-main">