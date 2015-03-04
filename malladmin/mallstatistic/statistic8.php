<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
/*
if ($sort) {
        $cat_query = $sort;
        if ($sort1) {$cat_query = $cat_query.">".$sort1;}
        if ($sort2) {$cat_query = $cat_query.">".$sort2;}
        $WHERE = "WHERE Category LIKE '$cat_query%'"; $WHERE1 = "AND Category LIKE '$cat_query%'";
}
*/

$listNo = "15";
$PageNo = "20";

/* 전체 토탈 */
$sqlstr = "SELECT distinct(MemberID) FROM wizBuyers";
$dbcon->_query($sqlstr) ;
$total = $dbcon->_num_rows();

/* 기업회원 토탈 */
$sqlstr = "SELECT distinct(b.MemberID) FROM wizBuyers b left join wizMembers m on m.mid = b.MemberID where m.mgrade = '5'";
$dbcon->_query($sqlstr);
$comtotal = $dbcon->_num_rows();

/* 일반회원 토탈 */
$gentotal = $total - $comtotal;

if($sort_grade == 10) $TOTAL = $gentotal;
else if($sort_grade == 5) $TOTAL = $comtotal;
else $TOTAL = $total;
//echo "\$TOTAL = $TOTAL <br />";

if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $listNo;

?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">고객별 판매 분석</div>
	  <div class="panel-body">
		 상기자료는 판매 완료를 시점으로 작성된 자료이므로 현재 주문상태인 제품은 통계에 포함되지 않았습니다.<br />
                  판매에 대한 상세 내역을 원하실 경우 판매수량을 클릭하시면 됩니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table 
>
        <tr>
          <td><table 
>
              <tr>
                <td>&nbsp;
                  <table>
                    <form action='<?=$PHP_SELF?>' method="post">
                      <input type="hidden" name=cp value='<?=$cp?>'>
                      <input type='hidden' name='menushow' value='<?=$menushow?>'>
                      <input type="hidden" name="theme" value='<?=$theme?>'>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><select style="width: 100px" onChange=this.form.submit() name="sort_grade">
                            <option value=''>회원별 정렬</option>
                            <option value=''<?if($sort_grade==''){ECHO" SELECTED";}?>>전체보기</option>
                            <option value='10'<?if($sort_grade=='10'){ECHO" SELECTED";}?>>일반회원</option>
                            <option value='5'<?if($sort_grade=='5'){ECHO" SELECTED";}?>>기업회원</option>
                          </select>
                        </td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="table">
        <tr>
          <td colspan="2">일반회원</td>
          <td colspan="2">기업회원</td>
          <td rowspan="2">총판매수량</td>
          <td rowspan="2">총판매금액</td>
          <td rowspan="2">총원가</td>
          <td rowspan="2">순수익</td>
          <td rowspan="2">월별통계</td>
        </tr>
        <tr>
          <td>판매수량</td>
          <td>판매금액</td>
          <td>판매수량</td>
          <td>판매금액</td>
        </tr>
        <?
		  
"select sum(qty) as cqty, sum(tprice) as cmount, sum(Buyprice) as cprice, sum(Buywonga) as cwonga from wizCart where BuyerID = '$list[ID]'";		  
		  
/* 기업회원의 데이타 추출 */
$sqlstr = "select m.mid from wizMembers m where m.mgrade = '5' order by m.UID desc";
$dbcon->_query($sqlstr) or dberror($sqlstr);
unset($com_qty);
unset($com_mount);
unset($com_price);
unset($com_wonga);
while($list = $dbcon->_fetch_array()):
 $sqlsubstr = "select sum(BuyGoodsQty) as cqty, sum(BuyGoodsQty*BuyPrice) as cmount, sum(Buyprice) as cprice, sum(Buywonga) as cwonga from wizCart where BuyerID = '$list[ID]'";
 $sqlsubqry = $dbcon->_query($sqlsubstr) or dberror($sqlsubstr);
 $sublist = $dbcon->_fetch_array($sqlsubqry);
 $com_qty += $sublist[cqty];
 $com_mount += $sublist[cmount];
 $com_price += $sublist[cprice];
 $com_wonga += $sublist[cwonga];
endwhile;

/* 총 판매량 구하기 */
$sqlstr = "select sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount, sum(BuyPrice) as twonga from wizCart";
$dbcon->_query($sqlstr) or dberror($sqlstr);
$list = $dbcon->_fetch_array();

/* 일반회원 구하기(총 판매량 -  기업회원 판매량) */
$gen_qty = $list[tqty] - $com_qty;
$gen_mount = $list[tmount] - $com_mount;
?>
        <tr>
          <td><?=number_format($gen_qty)?>
            ea</td>
          <td><?=number_format($gen_mount)?>
            원 </td>
          <td>&nbsp;
            <?=number_format($com_qty)?>
            ea</td>
          <td>&nbsp;
            <?=number_format($com_mount)?>
            원 </td>
          <td><?=number_format($list[tqty])?>
            ea </td>
          <td><?=number_format($list[tmount])?>
            원 </td>
          <td><?=number_format($list[twonga])?>
            원 </td>
          <td><?=number_format($list[tmount] - $list[twonga])?>
            원 </td>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=statistic8_3">보기</a></td>
        </tr>
      </table>
      <br />
      <table class="table">
        <tr>
          <th>거래처명</th>
          <th>판매수량</th>
          <th>총판매금액</th>
          <th>총원가</th>
          <th>순수익</th>
          <th>주 소</th>
          <th>상세통계</th>
          <th>월별통계</th>
        </tr>
        <?
//$sqlstr = "select distinct(BuyerID) from wizCart limit $START_NO, $listNo";

//$sqlstr = "select distinct(b.BuyerID) from wizCart b, wizMembers m $whereis limit $START_NO, $listNo";
//echo "\$sqlstr = $sqlstr <br />";
if($sort_grade == 10){ 
$whereis = "where m.Grade > '5' and (b.BuyerID = m.ID or b.BuyerID = '비회원')";
}else if($sort_grade == 5){
$whereis = "where m.Grade <= '5' and b.BuyerID = m.ID";
}
else unset($whereis);

$mainsqlstr = "select distinct(b.BuyerID) from wizCart b, wizMembers m $whereis limit $START_NO, $listNo";
//echo "\$mainsqlstr = $mainsqlstr <br />";
$dbcon->_query($mainsqlstr) or dberror($mainsqlstr);
while($list = $dbcon->_fetch_array()):
//echo "\$list [BuyerID]= $list[BuyerID] <br />";

	if($list[BuyerID] != "비회원"):
	$msqlstr = "SELECT UID, ID, Grade, Address1, Address2, Tel1, Name FROM wizMembers m where m.ID = '$list[BuyerID]'";
//echo "\$msqlstr = $msqlstr <br />";
	$msqlqry = $dbcon->_query($msqlstr, $DB_CONNECT) or dberror($msqlstr);
	$mlist = $dbcon->_fetch_array($msqlqry);
//echo "\$mlist[Name] = $mlist[Name] <br />";
	else : 
	unset($mlist); 
	$mlist[Name] = "비회원";
    endif;
	
	
	$bsqlstr = "select BuyerID, sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount, sum(BuyGoodsQty*BuyWonga) as Wonga from wizCart where BuyerID = '$list[BuyerID]' GROUP BY BuyerID";
	//$bsqlstr = "select BuyerID, sum(BuyGoodsQty) as tqty, sum(BuyGoodsQty*BuyPrice) as tmount, sum(BuyGoodsQty*BuyWonga) as Wonga from wizCart GROUP BY BuyerID";
    $bsqlqry = $dbcon->_query($bsqlstr) or dberror($bsqlstr);
    $MoreList = $dbcon->_fetch_array($bsqlqry);
	unset($list[BuyerID]);
	if($MoreList[tqty]):
	
?>
        <tr>
          <td>&nbsp; <?echo "$mlist[Name]"; ?> </td>
          <td> <a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=statistic8_1&mid=<?=$mlist[ID]?>">
            <?=number_format($MoreList[tqty])?>
            </a></td>
          <td>
            <?=number_format($MoreList[tmount])?>
            </td>
          <td>
            <?=number_format($MoreList[Wonga])?>
            </td>
          <td>
            <?=number_format($MoreList[tmount] - $MoreList[Wonga])?>
            </td>
          <td><?=$mlist[Address1]?>
            &nbsp;
            <?=$mlist[Address2]?>
          </td>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=statistic8_1&mid=<?=$mlist[ID]?>">보기</a></td>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=statistic8_2&mid=<?=$mlist[ID]?>">보기</a></td>
        </tr>
        <?
		endif;		  
endwhile;	
?>
        <tr>
          <td colspan=8><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=$theme&sort_grade=$sort_grade";
$page_arg2 = array("listno"=>$listNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
            &nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
