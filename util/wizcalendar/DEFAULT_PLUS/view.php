<?
include "../../../lib/inc.depth3.php";
include "../../../lib/class.calendar.php";
$date	= $_GET["date"];
$sql = "select UID, Schedule_Date, ScheduleSubject, Schedule from wizDiary where FROM_UNIXTIME(Schedule_Date, '%Y%m%d') = '".$date."' order by Schedule_Date asc";
		$rows	= $dbcon->get_rows($sql);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<? include("../../../inc/title.html");?>
</title>
<script type="text/javascript" src="../../../lib/swf.js"></script>
<script language="javascript" src="/js/jquery.min.js"></script>
<link href="../../../lib/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? if(is_array($rows)) foreach($rows as $key => $val){
?>

<div style="background-color:#FFFFFF; margin:10px">
  <table width="100%">
    <tr style="background-color:#CCCCCC">
      <td><?=$val["ScheduleSubject"]?>
        (
        <?=date("Y.m.d H:i", $val["Schedule_Date"])?>
        )</td>
    </tr>
    <tr>
      <td><?=nl2br($val["Schedule"])?></td>
    </tr>
  </table>
</div>
<?
		}
		?>
</body>
</html>