<?php
include "../../../lib/inc.depth3.php";
include "../../../lib/class.calendar.php";
$date	= $_GET["date"];
$sql = "select UID, Schedule_Date, ScheduleSubject, Schedule from wizDiary where FROM_UNIXTIME(Schedule_Date, '%Y%m%d') = '".$date."' order by Schedule_Date asc";
$rows	= $dbcon->get_rows($sql);

if(is_array($rows)) foreach($rows as $key => $val){
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

<div style="background-color:#FFFFFF; margin:10px; font-size:12px;">
  <table style="font-size:12px;" class="cal_view_table">
    <tr>
      <td>제목 : <?=$val["ScheduleSubject"]?></td>
    </tr>
    <tr>
      <td>일시 : <?=date("Y.m.d H:i", $val["Schedule_Date"])?></td>
    </tr>
    <tr>
      <td><?=nl2br($val["Schedule"])?></td>
    </tr>
  </table>
</div>
<?
}
?>
