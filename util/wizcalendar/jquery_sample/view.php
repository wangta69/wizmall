<?php
include "../../../lib/inc.depth3.php";
include "../../../lib/class.calendar.php";

$date	= $_GET["date"];
$uid	= $_GET["uid"];
if($uid){
	$sql = "select uid, schedule_date, schedule_title, schedule_comment from wizDiary where uid = ".$uid;
	$rows	= $dbcon->get_rows($sql);
}else if($date){
	$sql = "select uid, schedule_date, schedule_title, schedule_comment from wizDiary where FROM_UNIXTIME(schedule_date, '%Y%m%d') = '".$date."' order by schedule_date asc";
	$rows	= $dbcon->get_rows($sql);
}

?>
<style>
.cal_view_table{
	border-top:1px solid #dddddd;
	border-left:0px solid #dddddd;
	border-right:0px groove #dddddd;
	border-bottom:0px;
	border-spacing:1px;
	width:300px;
	line-height: 200%; 
	padding:0 0 0 0;
}

.cal_view_table th{
	background-color:#E6E9EA; 
	text-align:left;
	font-weight:normal;
	padding-left:10px;
}

.cal_view_table input[type=text], .cal_view_table  input[type=password]{
 border: 1px #CCCCCC solid;
 width:150px;
}

table.cal_view_table tr td{
	border-top:0px;
	border-left:0px;
	border-right:0px;
	text-align:left;
	padding-left:5px;
	border-bottom: 1px solid #dddddd;	
}
</style>
<?php
if(is_array($rows)) foreach($rows as $key => $val){
?>
<div style="background-color:#FFFFFF; margin:10px; font-size:12px;">
  <table style="font-size:12px;" class="cal_view_table">
  	<col width = "80px">
  	<col width = "*">
    <tr>
      <th>제목 </th>
      <td>: <?php echo $val["schedule_title"]?></td>
    </tr>
    <tr>
      <th>일시</th>
      <td>: <?php echo date("Y.m.d H:i", $val["schedule_date"])?></td>
    </tr>
    <tr>
      <td colspan="2"><?php echo nl2br($val["schedule_comment"])?></td>
    </tr>
  </table>
</div>
<?php
}
?>
