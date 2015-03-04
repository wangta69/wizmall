<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.custom.min.js"></script>
<!-- tool tip 용 -->
<script type="text/javascript" src="/js/jquery.plugins/aToolTip/js/atooltip.min.jquery.js"></script>
<link type="text/css" href="/js/jquery.plugins/aToolTip/css/atooltip.css" rel="stylesheet"  media="screen" />
<script type="text/javascript" src="/js/jquery.plugins/jquery.popup-1.0.0/jquery.popup-1.2.0.js"></script>
<link type="text/css" href="/js/jquery.plugins/jquery.popup-1.0.0/css/popup.css" rel="stylesheet"  media="screen" />
<script>
var calenar_url	= './calendar.php';
$(function(){
	gotoCalendar('','');
});

function gotoCalendar(mode, month){
	$("#cal_mode").val(mode);
	$("#cal_month").val(month);
	$.post(calenar_url, $("#cal_move").serialize(), function(data){
		$("#calendarHTML").html(data);
	});
}
</script>
</head>

<body>
<div id="calendarHTML"></div>

</body>
</html>
