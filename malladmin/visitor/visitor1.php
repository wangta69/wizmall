<?php
/* 검색사별 keyword */
$engin = array("yahoo"=>"p", "naver"=>"query", "daum"=>"q", "empas"=>"q", "nate"=>"Query");
  // 날자 세팅
  if(!$year) $year=date("Y");
  if(!$month) $month=date("m");
  if(!$day) $day=date("d");
  // 사용자 IP 얻어옴
  $user_ip=$REMOTE_ADDR;
  $referer=$HTTP_REFERER;
  // 오늘의 날자 구함
  $today=mktime(0,0,0,$month,$day,$year);
  
  if(!$ismorespec){
  $fromtoday=mktime(0,0,0,$month,$day,$year);
  $totoday=mktime(0,0,0,$month,$day+1,$year);
  }else{
  $fromtoday=mktime($fromhour,$fromminute,0,$month,$day,$year);
  $totoday=mktime($tohour,$tominute,0,$month,$day,$year);
  }
  
  $yesterday=mktime(0,0,0,$month,$day,$year)-3600*24;
  // 이번달의 첫번째 날자 구함
  $month_start=mktime(0,0,0,$month,1,$year);
  // 이번달의 마지막 날자 구함
  $lastdate=01;
  while (checkdate($month,$lastdate,$year)): 
    $lastdate++;  
  endwhile;
  $lastdate=mktime(0,0,0,$month,$lastdate,$year);
  if(!$no)$no=1;
?>
<script src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
	$(".uniquebar").chart({	height:5,bgcolor:"blue"});
	$(".pageviewbar").chart({	height:5,bgcolor:"red"});
});


function reset_confirm(){
	if(confirm('\n초기화 하시겠습니까?\n 초기화 하실경우 기존 방문자 통계 로그는 초기화 됩니다.\n')){
		location.href="<? echo $PHP_SELF; ?>?menushow=<?php echo $menushow?>&theme=<? echo $theme; ?>&no=8";
	}else return;
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">방문자통계</div>
	  <div class="panel-body">
		 unique 값은 금일 순수 방문자수를 표시합니다.(1인 1번 이상 책크되지 
				않음)<br />
				초기화를 클릭하시면 방문자가 초기화 됩니다. <br />
				방문자 로그는 데이타베이스에 상당한 량을 차지하므로 주기적으로 초기화 시켜 주시기 바랍니다.
	  </div>
	</div>
	

	<form method="post" action="<?php echo $PHP_SELF?>" class="form-inline" role="form">
		<input type="hidden" name="no" value="<?php echo $no?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme"  value="<?php echo $theme?>">	
		
		<div class="form-group inline">
			<label class="sr-only" for="exampleInputEmail2">Year: </label>
			<select name="year" class="form-control w100 ">
<?php
$ThisYear = date("Y");
for($i=${ThisYear};$i>2003;$i--) {
if($year == $i) echo "<option value='$i' selected>$i</option>\n";
else echo "<option value='$i'>$i</option>\n";
}
?>
			</select>
		</div>
		<div class="form-group inline">
			<label class="sr-only" for="exampleInputEmail2">Month: </label>
			<select name="month" class="form-control w100">
<?php
for($i=1;$i<=12;$i++) {
if($month == $i) echo "<option value='$i' selected>$i</option>\n";
else echo "<option value='$i'>$i</option>\n";
}
?>
			</select>
		</div>
		<div class="form-group inline">
			<label class="sr-only" for="exampleInputEmail2">Day: </label>
			<select name="day" class="form-control w100">
<?php
for($i=1;$i<=31;$i++) {
if($day == $i) echo "<option value='$i' selected>$i</option>\n";
else echo "<option value='$i'>$i</option>\n";
}
?>
			</select>
		</div>

		<button type="submit" class="btn btn-default btn-xs">이동하기</button>
		<a href="javascript:reset_confirm();" class="btn btn-default btn-xs">초기화 하기</a>
	</form>
	
	<p></p>
<?php
//-------------------------- 카운터 수 구해옴 -----------------------------//
  // 전체
  $total=$dbcon->_fetch_array($dbcon->_query("select unique_counter, pageview from wizcounter_main where no=1"));
  $count["total_hit"]=$total[0];
  $count["total_view"]=$total[1];
  // 오늘 카운터 읽어오는 부분
  $detail=$dbcon->_fetch_array($dbcon->_query("select unique_counter, pageview from wizcounter_main where date='$today'"));
  $count["today_hit"]=$detail[0];
  $count["today_view"]=$detail[1];
  // 어제 카운터 읽어오는 부분
  $detail=$dbcon->_fetch_array($dbcon->_query("select unique_counter, pageview from wizcounter_main where date='$yesterday'"));
  $count["yesterday_hit"]=$detail[0];
  $count["yesterday_view"]=$detail[1];
  // 최고 카운터 읽어오는 부분
  $detail=$dbcon->_fetch_array($dbcon->_query("select max(unique_counter), max(pageview) from wizcounter_main where no>1"));
  $count["max_hit"]=$detail[0];
  $count["max_view"]=$detail[1];
  // 최저 카운터 읽어오는 부분
  $detail=$dbcon->_fetch_array($dbcon->_query("select min(unique_counter), min(pageview) from wizcounter_main where no>1 and date<$today"));
  $count["min_hit"]=$detail[0];
  $count["min_view"]=$detail[1];

//-----------------------------------------------------------------------------
// 전체카운터 (1)
//-----------------------------------------------------------------------------
if($no=="1"):
?>
			<table class="table">
				<tr>
					<td>전체 방문자수 :
						<?php echo $count["total_hit"]?>
						<br />
						전체 페이지뷰 :
						<?php echo $count["total_view"]?>
					</td>
				</tr>
				<tr>
					<td> 오늘 방문자수 :
						<?php echo $count["today_hit"]?>
						<br />
						오늘 페이지뷰 :
						<?php echo $count["today_view"]?>
					</td>
				</tr>
				<tr>
					<td>어제 방문자수 :
						<?php echo $count["yesterday_hit"]?>
						<br />
						어제 페이지뷰 :
						<?php echo $count["yesterday_view"]?>
					</td>
				</tr>
				<tr>
					<td>최고 방문자수 :
						<?php echo $count["max_hit"]?>
						<br />
						최고 페이지뷰 :
						<?php echo $count["max_view"]?>
					</td>
				</tr>
				<tr>
					<td>최저 방문자수 :
						<?php echo $count["min_hit"]?>
						<br />
						최저 페이지뷰 :
						<?php echo $count["min_view"]?>
					</td>
				</tr>
			</table>
<?php
//-----------------------------------------------------------------------------
// 오늘 시간대별 카운터 (2)
//-----------------------------------------------------------------------------
elseif($no=="2"):
?>

			<ul class="list-group">
			  <li class="list-group-item active">
			    <?php echo $month?>월 <?php echo $day?>일 시간대별 고유 방문자 및 페이지뷰수
			  </li>
				<li class="list-group-item">
					고유방문자수 
			    	<span class="badge"><?php echo $count["today_hit"]?></span>
					
				</li>
				<li class="list-group-item">
					
					일 페이지뷰 <span class="badge"><?php echo $count["today_view"]?></span>
	
				</li>
			</ul>
			<table class="table">
				<col width="70px" />
				<col width="*" />
				<col width="120px" />
				<tbody>
<?php
  $max1=1;
  $max2=1;
  for($i=0;$i<24;$i++)
  {
   $time1=mktime($i,0,0,$month,$day,$year);
   $time2=mktime($i,59,59,$month,$day,$year);
   $sqlstr = "select distinct(ip) from wizcounter_referer where date>='$time1' and date<='$time2'";
   $dbcon->_query($sqlstr);
   $time_count1[$i]=$dbcon->_num_rows();
   
   $sqlstr = "select ip from wizcounter_referer where date>='$time1' and date<='$time2'";
   $dbcon->_query($sqlstr);
   $time_count2[$i]=$dbcon->_num_rows();
   
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }
 
  for($i=0;$i<24;$i++)
  {
   $per1=(int)($time_count1[$i]/$max1*100);
   $per2=(int)($time_count2[$i]/$max2*100);
   if($per1>100) $per1=99;
   if($per2>100) $per2=99;
?>
					<tr>
						<th>
							-<?php echo $i?>시 
						</th>
						<td><ul style="text-align:left">
								<li  ratio="<?php echo $per1?>" class="uniquebar" alt='<?php echo $i?>시 방문자 : <?php echo $time_count1[$i]?>'></li>
								<li  ratio="<?php echo $per2?>" class="pageviewbar" alt='<?php echo $i?>시 페이지뷰 : <?php echo $time_count2[$i]?>'></li>
							</ul></td>
						<th>Unique : <?php echo $time_count1[$i]?>
							<br />
							PageView : <?php echo $time_count2[$i]?>
						</th>
					</tr>
<?php
  } /* for($i=0;$i<24;$i++)문 닫음 */
?>
				</tbody>
			</table>
<?php
//-----------------------------------------------------------------------------
// 주간별 카운터 (3)
//-----------------------------------------------------------------------------
elseif($no=="3"):
$w = date(w, mktime(0,0,0,$month, $day, $year));
 $start_day=mktime(0,0,0,$month,$day-$w,$year);
 $last_day=mktime(0,0,-1,$month,$day+7-$w,$year);
 $detail=$dbcon->_fetch_array($dbcon->_query("select sum(unique_counter), sum(pageview) from wizcounter_main where date>=$start_day and date<=$last_day"));
 $count["week_hit"]=$detail[0];
 $count["week_view"]=$detail[1];
?>

			<ul class="list-group">
				<li class="list-group-item active">
					<? echo date("m월 d일", $start_day);?> ~ <? echo date("m월 d일", $last_day);?> 일 일자별 고유 방문자 및 페이지뷰수 
				</li>
				<li class="list-group-item">
					고유방문자수 
					<span class="badge"><?php echo $count["week_hit"]?></span>
				</li>
				<li class="list-group-item">
					일 페이지뷰 
					<span class="badge"><?php echo $count["week_view"]?></span>
				</li>
			</ul>
			<table class="table">
				<col width="150px" />
				<col width="*" />
				<col width="120px" />
				<tbody>
<?php
  $max1=1;
  $max2=1;
  for($i=0;$i<7;$i++)
  {
   $time=mktime(0,0,0,$month,$day-$w+$i,$year);
	$md[$i] = date("m월 d일", $time);
   $temp=$dbcon->_fetch_array($dbcon->_query("select unique_counter, pageview from wizcounter_main where date='$time'"));
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }
  $week=array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
  for($i=0;$i<7;$i++)
  {
   $per1=(int)($time_count1[$i]/$max1*100);
   $per2=(int)($time_count2[$i]/$max2*100);
   if($per1>100)$per1=100;
   if($per2>100)$per2=100;
?>
					<tr>
						<th>-
							<?php echo $week[$i]?>
							(
							<?php echo $md[$i]?>
							) 
						</th>
						<td><div>
								<ul style="text-align:left">
									<li ratio="<?php echo $per1?>" class="uniquebar" alt='<?php echo $week[$i]?> 방문자수 : <?php echo $time_count1[$i]?>'></li>
									<li ratio="<?php echo $per2?>"  class="pageviewbar" alt='<?php echo $week[$i]?> 페이지뷰 : <?php echo $time_count2[$i]?>'></li>
								</ul>
							</div></td>
						<th>&nbsp; Unique :
							<?php echo $time_count1[$i]?>
							<br />
							&nbsp; PageView :
							<?php echo $time_count2[$i]?>
						</th>
					</tr>
<?php
  }/* for($i=0;$i<7;$i++) */
?>
				</tbody>
			</table>
<?php
//-----------------------------------------------------------------------------
// 월간카운터 (4)
//-----------------------------------------------------------------------------
elseif($no=="4"):
  $total_month_counter=$dbcon->_fetch_array($dbcon->_query("select sum(unique_counter), sum(pageview) from wizcounter_main where date>='$month_start' and date<='$lastdate'"));
?>
			<ul class="list-group">
				<li class="list-group-item active">
					<?php echo $month?>월 일자별 고유 방문자 및 페이지뷰수 
				</li>
				<li class="list-group-item">
					월 방문자수 
					<span class="badge"><?php echo $total_month_counter[0]?></span>
				</li>
				<li class="list-group-item">
					월 페이지뷰 
					<span class="badge"><?php echo $total_month_counter[1]?></span>
				</li>
			</ul>
			<table class="table">
				<col width="70px" />
				<col width="*" />
				<col width="120px" />
				<tbody>
<?php
  // 이번달 카운터 (각각)
  $max=$dbcon->_fetch_array($dbcon->_query("select max(unique_counter), max(pageview) from wizcounter_main where date>='$month_start' and date<='$lastdate'"));
  $month_counter=$dbcon->_query("select date, unique_counter, pageview from wizcounter_main where date>='$month_start' and date<='$lastdate'"); 
  while($data=$dbcon->_fetch_array($month_counter)):
   $per1=(int)($data["unique_counter"]/$max[0]*100);
   $per2=(int)($data["pageview"]/$max[1]*100);
?>
					<tr>
						<th>-
							<?php echo date("d 일",$data[date])?>
						</th>
						<td><div>
								<ul style="text-align:left">
									<li ratio="<?php echo $per1?>" class="uniquebar" alt='Unique : <?php echo $data["unique_counter"]?>'></li>
									<li ratio="<?php echo $per2?>" class="pageviewbar" alt='PageView : <?php echo $data["pageview"]?>'></li>
								</ul>
							</div></td>
						<th>Unique :
							<?php echo $data["unique_counter"]?>
							<br />
							PageView :
							<?php echo $data["pageview"]?>
						</th>
					</tr>
<?php	 
  endwhile;
?>
				</tbody>
			</table>
<?php
//-----------------------------------------------------------------------------
// 년간카운터 (5)
//-----------------------------------------------------------------------------
elseif($no=="5"):
  $year_start=mktime(0,0,0,1,1,$year);
  $year_last=mktime(23,59,59,12,31,$year);
  $total_year_counter=$dbcon->_fetch_array($dbcon->_query("select sum(unique_counter), sum(pageview) from wizcounter_main where date>='$year_start' and date<='$year_last' and no <> 1"));
?>
			<ul class="list-group">
				<li class="list-group-item active">
					<?php echo $year?>년 월별 고유 방문자 및 페이지뷰수 
				</li>
				<li class="list-group-item">
					년 방문자수 
					<span class="badge"><?php echo $total_year_counter[0]?></span>
				</li>
				<li class="list-group-item">
					년 페이지뷰 
					<span class="badge"><?php echo $total_year_counter[1]?></span>
				</li>
			</ul>
			<table class="table">
				<col width="70px" />
				<col width="*" />
				<col width="120px" />
				<tbody>
<?php
  // 이번달 카운터 (각각)
$max1=1;
  $max2=1;
  for($i=0;$i<7;$i++)
  {
   $time=mktime(0,0,0,$month,$start_day+$i,$year);
   $temp=$dbcon->_fetch_array($dbcon->_query("select unique_counter, pageview from wizcounter_main where date='$time'"));
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }
  $max=1;
  $max2=1;
  for($i=0;$i<12;$i++)
  {
   $sdate=mktime(0,0,0,$i+1,1,$year);
   $edate=mktime(0,0,-1,$i+2,1,$year);
   $year_counter=$dbcon->_query("select sum(unique_counter), sum(pageview) from wizcounter_main where date>='$sdate' and date<='$edate'");
   $temp=$dbcon->_fetch_array($year_counter);
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }
  
  for($i=0;$i<12;$i++)
  {
   $per1=(int)($time_count1[$i]/$max1*100);
   $per2=(int)($time_count2[$i]/$max2*100);
   if($per1>100)$per1=99;
   if($per2>100)$per2=99;
   $j=$i+1;
?>
					<tr>
						<th>
							-<?php echo $j?>월 
						</th>
						<td><div>
								<ul style="text-align:left">
									<li ratio="<?php echo $per1?>" class="uniquebar" alt='<?php echo $week[$i]?> 방문자수 : <?php echo $time_count1[$i]?>'></li>
									<li ratio="<?php echo $per2?>" class="pageviewbar" alt='<?php echo $week[$i]?> 페이지뷰 : <?php echo $time_count2[$i]?>'></li>
								</ul>
							</div></td>
						<th>Unique :
							<?php echo $time_count1[$i]?>
							<br />
							PageView :
							<?php echo $time_count2[$i]?>
						</th>
					</tr>
<?php		 
  } /* for($i=0;$i<12;$i++) */
?>
				</tbody>
			</table>
<?php
//-----------------------------------------------------------------------------
// 접속자 방문경로?(6)
//-----------------------------------------------------------------------------
elseif($no=="6"):
?>
			<table class="table">
				<tr>
					<td>
<?php
	$whereis = "where date >= $fromtoday and date <= $totoday";
	$sqlstr = "select count(referer) as total, referer from wizcounter_referer $whereis group by referer order by total desc";			  
 	$ip=$dbcon->_query("$sqlstr");
  while($data=$dbcon->_fetch_array($ip))
  {
  $data["referer"] = urldecode($data["referer"]);
   if(strlen($data["referer"])>90) 
   {
    $temp=substr($data["referer"],0,90);
    $text=$temp."..."; 
   }
   else $text=$data[referer];
   //if(!eregi("Typing or Bookmark", $data[referer])) $data[referer]="<a href=$data[referer] target=_blank><font color='black'>$text</a>";
   if(!preg_match("/Typing or Bookmark/i", $data["referer"])) $data["referer"]="<a href=$data[referer] target=_blank><font color='black'>$text</a>";
   echo "&nbsp;&nbsp;&nbsp; - $data[referer] ($data[total])<br />";
  }
?></td>
				</tr>
			</table>
<?php
//-----------------------------------------------------------------------------
// 접속자 방문경로?(6)
//-----------------------------------------------------------------------------
elseif($no=="7"):
?>
			<table class="table">
				<tr>
					<td><?php
  $sqlqry=$dbcon->_query("select count(referer) as total, referer from wizcounter_referer where date > $month_start and date <='$today' group by referer order by total desc");
  $k=0;
  while($list = $dbcon->_fetch_array()):
	  $split_unique_referer = explode("/", $list["referer"]);
	  if($split_unique_referer[2])
	  $unique_referer[$k] = "http://".$split_unique_referer[2];
	  else $unique_referer[$k] = "Typing or Bookmark Moving On This Site";
	  $k++;
  endwhile;
/* 월간 경로중 unique 한 값을 구한다. */
if(is_array($unique_referer)){
  $unique_referer_value = array_unique($unique_referer);
  $k=0;
  for($i=0; $i < sizeof($unique_referer); $i++){
     if($unique_referer_value[$i]){
     $refer_value[$k] = $unique_referer_value[$i];
     $k++;
     }
  }
}

/* 아래는 실제 unique 한 방문 경로를 넣어서 실제 값을 도출 한다.*/
for($i=0; $i < sizeof($refer_value); $i++){

 
  $hit=$dbcon->get_one("select sum(hit) from wizcounter_referer where date > $month_start and date <='$today' and referer like '$refer_value[$i]%' order by hit desc");
  $countNo++;
  

   echo "&nbsp;&nbsp;&nbsp; - $refer_value[$i] ($hit)<br />";

  }

?></td>
				</tr>
			</table>
<?php
//-----------------------------------------------------------------------------
// 검색엔진별 방문자 분석(9)
//-----------------------------------------------------------------------------
elseif($no=="9"):
?>
			<table class="table">
				<tr>
					<th>검색엔진</th>
					<th>검색어(일부 검색어는 누락되어 표기 될 수 도 있습니다.)</th>
					<th>방문자수<br />
						unique(total) </th>
				</tr>
<?php
reset($engin);
while(list($key, $value) = each($engin)):
	$whereis = "where date >= $fromtoday and date <= $totoday and referer like '%$key%'";
	$groupby = "group by referer";
	$sqlstr = "select distinct(ip), referer  from wizcounter_referer $whereis $groupby";
	$sqlqry=$dbcon->_query($sqlstr);
		$unique_no=0;
		unset($serchingkeyword[$unique_no]);
		while($list = $dbcon->_fetch_array()):
			$referer = urldecode($list["referer"]);
			//echo "referer = $referer <br />";
			$tmpvalue = preg_match("/^.*?(.*)/i", $referer, $matches);
				$tmpArr = explode("&",  $matches[1]);
				while(list($key1, $value1) = each($tmpArr)):
					if(eregi($value."=",$value1)){
						$serchingkeyword[$unique_no] = str_replace($value."=","", $value1);
						break;
					}
				endwhile;
		$unique_no++;
	
		endwhile;
		
	$whereis = "where date >= $fromtoday and date <= $totoday and referer like '%$key%'";
	$sqlstr1 = "select referer  from wizcounter_referer $whereis";
	$sqlqry1=$dbcon->_query($sqlstr1);
	$total_no = $dbcon->_num_rows($sqlqry1);
?>
				<tr>
					<td><? echo $key; ?></td>
					<td><? 
						  while(list($key1, $value1) = @each($serchingkeyword)):
						if($value1)  echo urldecode($value1)."<br />"; 
						  endwhile;
						  ?>
					</td>
					<td><? echo $unique_no."(".$total_no.")"; ?></td>
				</tr>
<?php
endwhile;
?>
				<!-- <tr>
                          <td><? echo $key; ?></td>
                          <td><? echo urldecode($keyword); ?></td>
                          <td><? echo $total; ?></td>
                        </tr> -->
			</table>
<?php
/* 데이타베이스를 리?V시킨다. */
elseif($no=="8"):
	$substr="truncate table wizcounter_referer";
	$result2 = $dbcon->_query($substr);
endif;

//-----------------------------------------------------------------------------
//  하단부분
//-----------------------------------------------------------------------------
?>	
</div>