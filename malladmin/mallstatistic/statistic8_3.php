<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">월별 판매 통계</div>
	  <div class="panel-body">
		 기업회원은 통상5등급으로 분류 됩니다.<br />
									이곳의 판매금액은 배송비가 제외된 순수 금액입니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
					    <table class="table">
        
          <tr> 
            <td colspan="2">일반회원</td>
            <td colspan="2">기업회원</td>
            <td rowspan="2">총판매수량</td>
            <td rowspan="2">총판매금액</td>
            <td rowspan="2">총원가</td>
            <td rowspan="2">순수익</td>
          </tr>
          <tr> 
            <th>판매수량</th>
            <th>판매금액</th>
            <th>판매수량</th>
            <th>판매금액</th>
          </tr>
          <?
/* 기업회원의 데이타 추출 */
$sqlstr = "select m.mid from wizMembers m left join wizMembers_ind i on m.mid = i.id where m.mgrade = '5' order by m.uid desc";
$dbcon->_query($sqlstr);
unset($com_qty);
unset($com_mount);
unset($com_price);
unset($com_wonga);
while($list = $dbcon->_fetch_array()):
 $sqlsubstr = "select sum(BuyGoodsQty) as cqty, sum(BuyGoodsQty*BuyPrice) as cmount, sum(Buyprice) as cprice, sum(Buywonga) as cwonga from wizBuyersMore where BuyerID = '$list[ID]'";
 $sqlsubqry = $dbcon->_query($sqlsubstr);
 $sublist = $dbcon->_fetch_array($sqlsubqry);
 $com_qty += $sublist[cqty];
 $com_mount += $sublist[cmount];
 $com_price += $sublist[cprice];
 $com_wonga += $sublist[cwonga];
endwhile;

/* 총 판매량 구하기 */
$sqlstr = "select sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount, sum(BuyPrice) as twonga from wizBuyersMore";
$dbcon->_query($sqlstr);
/*	for($i=0; $i < 14; $i++){
	echo "\$result = ".$result*result1." <br />";
	$sumresult += $result;
	echo "\$sumresult = $sumresult <br />";
	
	}
*/
$list = $dbcon->_fetch_array();

		
/* 일반회원 구하기(총 판매량 -  기업회원 판매량) */
//echo "\$list[tqty] = $list[tqty] , \$com_qty = $com_qty <br />";
//echo "\$list[tmount] = $list[tmount] , \$com_mount = $com_mount <br />";
$gen_qty = $list[tqty] - $com_qty;
$gen_mount = $list[tmount] - $com_mount;
?>
          <tr> 
            <td> 
              <?=number_format($gen_qty)?>
              ea</td>
            <td> 
              <?=number_format($gen_mount)?>
              원 </td>
            <td>&nbsp; 
              <?=number_format($com_qty)?>
              ea</td>
            <td>&nbsp; 
              <?=number_format($com_mount)?>
              원 </td>
            <td> 
              <?=number_format($list[tqty])?>
              ea </td>
            <td> 
              <?=number_format($list[tmount])?>
              원 </td>
            <td> 
              <?=number_format($list[twonga])?>
              원 </td>
            <td> 
              <?=number_format($list[tmount] - $list[twonga])?>
              원 </td>
          </tr>
        
      </table>
      <br />
      <?
$ThisYear = date("Y");
if(!$SelectedYear) $SelectedYear = $ThisYear;
?>
      <table 
>
        
          <tr> 
            <td> <table 
>
                
                  <tr> 
                    <td>&nbsp; <table>
                        <form action="<?=$PHP_SELF?>">
                          <input type='hidden' name='menushow' value='<?=$menushow?>'>
                          <input type="hidden" name="theme" value="<?=$theme?>">
                          <input type="hidden" name="mid" value="<?=$mid?>">
                          <tr> 
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>
 <?
							//echo "adfasdf";
if ($SelectedYear) $tdate = mktime(0,0,0,1,1, $SelectedYear);
else $tdate = $WizApplicationStartDate;
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
        
<?
/*
$MSqlstr = "SELECT UID,ID,Grade,Address1,Address2,Tel1,Name FROM wizMembers WHERE ID = '$mid'";
$MSqlqry = $dbcon->_query($MSqlstr);
$Mlist = $dbcon->_fetch_array( $MSqlqry );
$sqlstr = "select CompName, CompChaName, CompChaTel, CompAddress1, CompAddress2 from wizCom where CompID = '$mid'"; 
$dbcon->_query($sqlstr);
$CompList =  $dbcon->_fetch_array();
*
/* 만약 기업회원과 일반회원과의 가격 차등일 경우 BuyPrice --> ByuPrice1 */
/* 선택 년을 구한다. */
$StartYear = mktime(0,0,0,0,0,$SelectedYear);
$EndYear = mktime(0,0,0,0,0,$SelectedYear+1);
//$sqlstr = "select sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount from wizBuyersMore where BuyerID = '$mid' and BuyDate < '$EndYear' and BuyDate >= '$StartYear'";
/* 전체 매출량 구하기 */
$sqlstr = "select sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount from wizBuyersMore where BuyDate between '$StartYear' and '$EndYear'";
$dbcon->_query($sqlstr);
$MoreList = $dbcon->_fetch_array();
$TotalQtyofTheYear = $MoreList[tqty];
$TotalAmoutofTheYear = $MoreList[tmount];
//echo "\$sqlstr = $sqlstr <br />";
//echo "\$TotalQtyofTheYear =$TotalQtyofTheYear <br />";
//echo "\$TotalAmoutofTheYear =$TotalAmoutofTheYear <br />";
?>
<?
 // 이번달 카운터 (각각)
  for($i=0;$i<12;$i++)
  {
$j=$i+1;  
/* 각달의 토탈 구매량과 금액을 구한다. */
$StartMonth = mktime(0,0,0,$j,0,$SelectedYear);
$EndMonth = mktime(0,0,0,$j+1,0,$SelectedYear);
/* 전체 토탈 구하기 */
$sqlstr = "select sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount, sum(Buywonga) as twonga from wizBuyersMore where BuyDate between '$StartMonth' and '$EndMonth'";
$dbcon->_query($sqlstr);
$MoreList = $dbcon->_fetch_array();
$TotalQtyofTheMonth = $MoreList[tqty];
$TotalAmoutofTheMonth = $MoreList[tmount];
$TotalWongaofTheMonth = $MoreList[twonga];
  
if($TotalAmoutofTheMonth && $TotalAmoutofTheYear) $per1=(int)($TotalAmoutofTheMonth/$TotalAmoutofTheYear*100+1);
else unset($per1);
//echo "TotalAmoutofTheMonth = $TotalAmoutofTheMonth, TotalAmoutofTheYear = $TotalAmoutofTheYear <br />";
if($TotalQtyofTheMonth && $TotalQtyofTheYear) $per2=(int)($TotalQtyofTheMonth/$TotalQtyofTheYear*100+1);
else unset($per2);
   if($per1>100)$per1=99;
   if($per2>100)$per2=99;
   //echo "per1 = $per1 , per2 =$per2 <br />";
   //$j=$i+1;
   
/* 기업회원 토탈 구하기 */   

$sqlstr = "select m.mid from wizMembers m left join wizMembers_ind i on m.mid = i.id where m.mgrade = '5' order by m.uid desc";
$dbcon->_query($sqlstr);
unset($com_qty);
unset($com_mount);
unset($com_price);
unset($com_wonga);
while($list = $dbcon->_fetch_array()):
 $sqlsubstr = "select sum(BuyGoodsQty) as cqty, sum(BuyGoodsQty*BuyPrice) as cmount, sum(Buyprice) as cprice, sum(Buywonga) as cwonga from wizBuyersMore where BuyerID = '$list[ID]' and BuyDate between '$StartMonth' and '$EndMonth'";
 $sqlsubqry = $dbcon->_query($sqlsubstr);
 $sublist = $dbcon->_fetch_array($sqlsubqry);
 $com_qty += $sublist[cqty];
 $com_mount += $sublist[cmount];
 $com_price += $sublist[cprice];
 $com_wonga += $sublist[cwonga];
endwhile;

if($com_mount && $TotalAmoutofTheYear) $percom1=(int)($com_mount/$TotalAmoutofTheYear*100+1);
else unset($percom1);
if($com_qty && $TotalQtyofTheYear) $percom2=(int)($com_qty/$TotalQtyofTheYear*100+1);
else unset($percom2);
   if($percom1>100) $percom1=99;
   if($percom2>100) $percom2=99;
  // $j=$i+1;
   
/* 일반회원 구하기(총 판매량 -  기업회원 판매량) */
$gen_qty = $TotalQtyofTheMonth - $com_qty;
$gen_mount = $TotalAmoutofTheMonth - $com_mount;  
$gen_wonga = $TotalWongaofTheMonth - $com_wonga;  
//echo "\$gen_mount = $gen_mount <br />";
if($gen_mount && $TotalAmoutofTheYear) $pergen1=(int)($gen_mount/$TotalAmoutofTheYear*100+1);
else unset($pergen1);
if($gen_qty && $TotalQtyofTheYear) $pergen2=(int)($gen_qty/$TotalQtyofTheYear*100+1);
else unset($pergen2);
   if($pergen1>100) $pergen1=99;
   if($pergen2>100) $pergen2=99;
   //$j=$i+1;
   //echo "per1 = $per1 , percom1 = $percom1 , pergen1 =$pergen1 <br />";
?>
          <tr> 
            <td>- 
              <?=$j?>
              월 </td>
            <td width="53%"> <table>
                <tr> 
                  <td><table>
                      <tr> 
                        <td><img src="img/blue.gif" width="<?=$per1?>%" height="5"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><table>
                      <tr> 
                        <td><img src="img/blue.gif" width="<?=$percom1?>%" height="5"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><table>
                      <tr> 
                        <td><img src="img/blue.gif" width="<?=$pergen1?>%" height="5"></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
            <td><table>
                <tr> 
                  <td>전체(총매출액: 
                    <?=number_format($TotalAmoutofTheMonth);?>
                    , 총수익: 
                    <?=number_format($TotalAmoutofTheMonth - $TotalQtyofTheMonth*$TotalWongaofTheMonth);?>
                    )</td>
                </tr>
                <tr> 
                  <td>기업회원(총매출액:
                    <?=number_format($com_mount);?>
                    , 총수익:<?=number_format($com_mount - $com_qty*$com_wonga);?>)</td>
                </tr>
                <tr> 
                  <td>일반회원(총매출액:
                    <?=number_format($gen_mount);?>
                    , 총수익:<?=number_format($gen_mount - $gen_qty*$gen_wonga);?>)</td>
                </tr>
              </table>
            </td>
          </tr>
          <?		 
  } /* for($i=0;$i<12;$i++) */
?>
        
      </table></td>
  </tr>
</table>
