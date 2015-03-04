<?php
  // 사용자 IP 얻어옴
  $user_ip=$REMOTE_ADDR;
  $referer=$HTTP_REFERER;
  if(!$referer) $referer="Typing or Bookmark Moving On This Site";

  // 오늘의 날자 구함
  $today=mktime(0,0,0,date("m"),date("d"),date("Y"));
  $yesterday=mktime(0,0,0,date("m"),date("d"),date("Y"))-60*60*24;
  $tomorrow=mktime(23,59,59,date("m"),date("d"),date("Y"));
  $time=time();

//------------------- 카운터 값 읽어오는 부분 ----------------------------------------------------------------------

  // 전체
  $total=$dbcon->get_row("select unique_counter, pageview from wizcounter_main where no=1"); 
  $count["total_hit"]		=$total["unique_counter"];
  $count["total_view"]	=$total["pageview"];


  // 오늘 카운터 읽어오는 부분
  $detail=$dbcon->get_row("select unique_counter, pageview from wizcounter_main where date='$today'");  
  $count["today_hit"]		=$detail["unique_counter"];
  $count["today_view"]	=$detail["pageview"];


  // 어제 카운터 읽어오는 부분
  $detail=$dbcon->get_row("select unique_counter, pageview from wizcounter_main where date='$yesterday'");
  $count["yesterday_hit"]		=$detail["unique_counter"];
  $count["yesterday_view"]	=$detail["pageview"];


  // 최고 카운터 읽어오는 부분
  $detail=$dbcon->get_row("select max(unique_counter), max(pageview) from wizcounter_main where no>1");
  $count["max_hit"]	=$detail["unique_counter"];
  $count["max_view"]	=$detail["pageview"];


  // 최저 카운터 읽어오는 부분
  $detail=$dbcon->get_row("select min(unique_counter), min(pageview) from wizcounter_main where no>1 and date < $today");
  $count["min_hit"]	=$detail["unique_counter"];
  $count["min_view"]	=$detail["pageview"];