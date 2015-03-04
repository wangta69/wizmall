<?

//제작자 : 폰돌

//Email : master@shop-wiz.com

//Url : http://www.shop-wiz.com

//최초 제작일 : 2003-05-05

//접속자수 : 로그인 된 회원을 기준으로 산정한다.

//./member/login_user 폴더밑의 로긴회원 기준

//현재 접속자수는 wizmall 사용시 인클루드 되는 디렉토리를 기준으로 만듦

$open_dir = opendir("./config/member/login_user");

unset($joincount);

        while($opendir = readdir($open_dir)) {

                if(($opendir != ".") && ($opendir != "..")) {

                 $joincount++;

                }

        }

closedir($open_dir);



//현재 접속자수 : $joincount



// 아래카운트는 반드시 wizcount를 세팅후 사용가능합니다.

  //전체 카운터 읽어오는 부분

  $total=$dbcon->get_row("select unique_counter, pageview from counter_main where no=1");

  $count[total_hit]=$total["unique_counter"];

  $count[total_view]=$total["pageview"];







  // 오늘 카운터 읽어오는 부분

  $detail=$dbcon->get_row("select unique_counter, pageview from counter_main where date='$today'");

  $count[today_hit]=$total["unique_counter"];

  $count[today_view]=$total["pageview"];



//오늘 방문자수 : number_format($count[today_view])

//총 방문자수 : number_format($count[total_view])?

  

?>



