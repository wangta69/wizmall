<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "./mallstatistic/common.php";
$ThisYear = date("Y");
//echo "SelectedYear = $SelectedYear <br />";
if(!$SelectedYear) $SelectedYear = $ThisYear;
$tdate = mktime(0,0,0,1,1,$SelectedYear);
?>
<script  language="javascript" src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
    $(".uniquebar").chart({ height:5,bgcolor:"blue"});
});
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">제품별 월간 판매 통계<</div>
	  <div class="panel-body">
		 제품별 월간 판매 통계를 보실 수 있습니다
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>
      <table class="table">
        <tr>
          <td>제품명/제조사</td>
          <td>가격/포인트</td>
          <td>조회량</td>
          <td>판매량</td>
          <td>입고량에따른 판매율</td>
        </tr>
        <tr>
          <td colspan=7 height=1></td>
        </tr>
<?php
$sqlstr = "SELECT UID, Name, Model, Picture,Category, Price, Point, Hit, Output FROM wizMall m where m.UID = '$gid'";
$list = $dbcon->get_row($sqlstr);
	$UID		= $list["UID"];
	$Name		= stripslashes($list["Name"]);
	$Model		= stripslashes($list["Model"]);
	$Picture	= explode("|",$list["Picture"]); 
	$Category	= $list["Category"]; 
	$Price		= $list["Price"];
	$Point		= $list["Point"];
	$Hit		= $list["Hit"];
	$Output		= $list["Output"];

	$input		= $sta->get_pd_in($UID);##입고량 가져오기
	if(!$input)  $input  = 0.1;
	$out_per	= (int)(($Output/$input)*100);
	$out_graph	= $out_per > 100 ? 100 : $out_per;
?>
        <tr>
          <td><table>
              <tr>
                <td><a href="../wizmart.php?code=<?=$Category?>&query=view&no=<?=$UID?>" target=_blank><img src="<?=$common->getpdimgpath($Category, $Picture[0], "../")?>" height='50' ></a></td>
                <td><?=$Name?></td>
              </tr>
            </table></td>
          <td><font 
                  >
            <?=$Price?>
            원<br />
            <?=$Point?>
            포인트 </td>
          <td>
            <?=$Hit?>
            회</td>
          <td>
            <?=$Output?>
            EA</td>
          <td>
      <div ratio="<?php echo $out_graph;?>" class="uniquebar" alt='Unique : <?=$data["unique_counter"]?>'></div>        
              판매비율(
            <?=number_format($out_per);?>
            %) <br />
            (입고:
            <?=number_format($input)?>
            , 판매량 :
            <?=number_format($Output)?>
            ) </td>
        </tr>
      </table>
      <br />
      <table>
        <tr>
          <td><table>
              <tr>
                <td>&nbsp;
                  <table>
                    <form action="<?=$PHP_SELF?>">
                      <input type='hidden' name='menushow' value='<?=$menushow?>'>
                      <input type="hidden" name="theme" value="<?=$theme?>">
                      <input type="hidden" name="gid" value="<?=$gid?>">
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
<?php
							//echo "adfasdf";
$common->startyear = date("Y", $WizApplicationStartDate);
$common->getSelectDate($tdate);
?>
                          <select name="SelectedYear" onChange="submit();">
                            <?=$common->rtn_year ?>
                          </select>
                          년도 </td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="table">
<?php
/* 선택 년을 구한다. */
$StartYear = mktime(0,0,0,1,1,$SelectedYear);
$EndYear = mktime(0,0,-1,1,1,$SelectedYear+1);


## 년별 총 판매량과 금액을 구한다.
$list = $sta->get_pd_sale($gid, $StartYear, $EndYear);
$TotalQtyofTheYear = $list[tqty];
$TotalAmoutofTheYear = $list[tmount];
//echo "TotalQtyofTheYear =  $TotalQtyofTheYear , TotalAmoutofTheYear = $TotalAmoutofTheYear <br />";
## 년별 총 구매량(입고량)을 구한다.
$TotalInputofTheYear = $sta->get_pd_in($gid, $StartYear, $EndYear); 
//echo "TotalInputofTheYear = $TotalInputofTheYear <br />";

 // 이번달 카운터 (각각)
for($i=0;$i<12;$i++){

	$StartMonth = mktime(0,0,0,$j+1,1,$SelectedYear);
	$EndMonth = mktime(0,0,-1,$i+2,1,$SelectedYear);
	
	## 각달의 토탈 구매량과 금액을 구한다.
	$list = $list = $sta->get_pd_sale($gid, $StartMonth, $EndMonth);
	$TotalQtyofTheMonth = $list[tqty];
	$TotalAmoutofTheMonth = $list[tmount];
	
	## 각 달의 제품 입력량을 구한다.
	$TotalInputofTheMonth = $sta->get_pd_in($gid, $StartMonth, $EndMonth); 

/* 월별 제품의 입고량과 판매량을 계산한다. */
//if($TotalAmoutofTheMonth && $TotalAmoutofTheYear) $per1=(int)($TotalAmoutofTheMonth/$TotalAmoutofTheYear*100+1);
//else unset($per1);
	if($TotalInputofTheMonth && $TotalInputofTheYear) $per1=(int)($TotalInputofTheMonth/$TotalInputofTheYear*100+1);
	else unset($per1);
	if($TotalQtyofTheMonth && $TotalQtyofTheYear) $per2=(int)($TotalQtyofTheMonth/$TotalQtyofTheYear*100+1);
	else unset($per2);
	if($per1>100)$per1=99;
	if($per2>100)$per2=99;
	$j=$i+1;
?>
        <tr>
          <td>-
            <?=$j?>
            월 </td>
          <td><table>
              <tr>
                <td><img src="img/blue.gif" width="<?=$per1?>%" height="5"></td>
                <td width="120">입고량 :
                  <?=number_format($TotalInputofTheMonth)?>
                  ea</td>
              </tr>
            </table>
            <table>
              <tr>
                <td><img src="img/blue.gif" width="<?=$per2?>%" height="5"></td>
                <td>판매량 :
                  <?=number_format($TotalQtyofTheMonth)?>
                  ea</td>
              </tr>
            </table></td>
          <td>&nbsp; 판매 금액 :
            <?=number_format($TotalAmoutofTheMonth);?>
          </td>
        </tr>
<?php		 
  } /* for($i=0;$i<12;$i++) */
?>
      </table></td>
  </tr>
</table>
