<?
$ListNo = 10;
$PageNo = 10;
$Todaydate = time();
/* �˻� Ű���� �� WHERE ���ϱ� */
$whereis = "WHERE UID <> ''";

//if($pollquery == "ing") $whereis .=" and FromDay <= '$Todaydate' and ToDay >= '$Todaydate'";
//else if($pollquery == "end") $whereis .=" and ToDay < '$Todaydate'";
if($SEARCHTITLE && $searchkeyword){
$whereis .= " AND $SEARCHTITLE LIKE '%$searchkeyword%'";
}

/* �� ���� ���ϱ� */
$TOTAL = $dbcon->get_one("SELECT count(UID) FROM $BOARD_NAME $whereis");

for($i=0; $i<3; $i++){
//global $BOARD_NAME, $Todaydate;
	if($i==0) $totalwhere = "";
	else if($i==1) $totalwhere = "where FromDay <= '$Todaydate' and ToDay >= '$Todaydate'";
	else if($i==2) $totalwhere = "where ToDay < '$Todaydate'";
	$total[$i] = $dbcon->get_one("select count(*) from $BOARD_NAME $totalwhere");
}	
if(empty($cp) || $cp <= 0) $cp = 1;
?>
                 
<table width="608" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" colspan="8">&nbsp;</td>
  </tr>
  <tr> 
    <td width="62"><img src="../../../images/board/tit_no.gif" width="62" height="21"></td>
    <td width="6"></td>
    <td width="309" colspan="2"><img src="../../../images/board/tit_tit.gif" width="309" height="21"></td>
    <td width="6"></td>
    <td width="109"><img src="../../../images/board/tit_poll_start.gif" width="109" height="21"></td>
    <td width="6"></td>
    <td width="110"><img src="../../../images/board/tit_poll_end.gif" width="110" height="21"></td>
  </tr>
  <tr> 
    <td height="4" colspan="8" bgcolor="#FFFFFF"></td>
  </tr>
  <tr > 
    <td height="8" colspan="8"></td>
  </tr>
  <? 
$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));

$cnt=0;
$orderby = "ORDER BY UID DESC ";
$dbcon->get_select('*',$BOARD_NAME,$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
$today = time();
// ����� | ������
$FromDay = date("Y.m.d",$List[FromDay]);
$ToDay = date("Y.m.d",$List[ToDay]);
// �� ��ǥ��
$Vote = explode("|",$List[Vote]);
$total_vote = "0";
for($i=0; $i<count($Vote)-1; $i++) $total_vote += $Vote[$i];

?>
  <tr onmouseOver="this.style.backgroundColor='#E6E4DF'" onmouseOut="this.style.backgroundColor='#F3F1EC'"> 
    <td width="62" height="25" align="center">10</td>
    <td width="6"></td>
    <td width="12" ></td>
    <td width="297" ><a href="<?=$PHP_SELF?>?uid=<?=$List[UID]?>&mode=view" class="list"><?=$List[Subject]?></a></td>
    <td width="6"></td>
    <td width="109" align="center"> <?=date("Y-m-d",$List[FromDay])?></td>
    <td width="6"></td>
    <td width="110" align="center"><?=date("Y-m-d",$List[ToDay])?></td>
  </tr>
  <tr > 
    <td height="3" colspan="8" background="../../../images/board/line.gif" ></td>
  </tr>
  <?
$cnt++;
$BOARD_NO--;
endwhile;
if(!$cnt):/* �Խù��� �������� ���� ��� */
?>
  <tr onmouseOver="this.style.backgroundColor='#E6E4DF'" onmouseOut="this.style.backgroundColor='#F3F1EC'"> 
    <td height="25" colspan="8" align="center">��ϵ� ��ǥ�� ����ϴ�.</td>
  </tr>
  <tr > 
    <td height="3" colspan="8" background="../../../images/board/line.gif" ></td>
  </tr>
  <?
endif;
?>
  <tr align="center"> 
    <td height="50" colspan="8"> 
      <!-- ������num -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="center" style="padding-right:5px;"><?
/* ������ ��ȣ ����Ʈ �κ� */
/* PREVIOUS or First �κ� */
$page_arg1 = $PHP_SELF."?SEARCHTITLE=$SEARCHTITLE&searchkeyword=$searchkeyword";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>