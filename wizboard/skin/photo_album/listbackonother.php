<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<?
/* sorting 관련 order by 옵션 구하기 */
/* 사용예
echo "<a href='$PHP_SELF?$TransData&STitle=SUBJECT&SOrder=$SOrder&reverse=on';>제목</a>";
 */
/* 회원모드이면 로그인 상태와 회원등급을 책크하여 글을 읽을 수 있는 권한을 부여한다. */
include "./wizboard/func/GradePermission.php";

if($reverse == "on" && $SOrder == "asc"){
 $SOrder = "desc";
 $orderby = "ORDER BY $STitle $SOrder, FID DESC, THREAD ASC, UID DESC";
 }else if($reverse=="on"){ 
 $SOrder = "asc";
 $orderby = "ORDER BY $STitle $SOrder, FID DESC, THREAD ASC, UID DESC";
 }else if($STitle && $SOrder){
 $orderby = "ORDER BY $STitle $SOrder, FID DESC, THREAD ASC, UID DESC";
 }else $orderby = "ORDER BY FID DESC, THREAD ASC, UID DESC";
 
/* 검색 키워드 및 WHERE 구하기 */
$WHERE  = "WHERE UID <> ''";
if($category) $WHERE = "$WHERE and BID = '$category'";
if($SEARCHTITLE && $searchkeyword) $WHERE = "$WHERE and $SEARCHTITLE LIKE '%$searchkeyword%'";
if($search_term){//전송값은 유닉스타임으로 넘어옮
$today = time();
$boundary = $today - $search_term;
$WHERE = "$WHERE and W_DATE between '$today' and '$boundary'";
} 
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(UID) FROM $BOARD_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);

if(empty($cp) || $cp <= 0) $cp = 1;

$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO1=$TOTAL-($ListNo*($cp-1));
$SELECT_STR="SELECT * FROM $BOARD_NAME $WHERE $orderby LIMIT $START_NO, $ListNo";
$SELECT_QRY=$dbcon->_query($SELECT_STR);
$no=0;
while($LIST=@$dbcon->_fetch_array($SELECT_QRY)):
$LIST[SUBJECT]=stripslashes($LIST[SUBJECT]);
if($SubjectLength) $LIST[SUBJECT]=STR_CUTTING($LIST[SUBJECT], $SubjectLength);
if($NameLength) $LIST[NAME]=stripslashes($LIST[NAME]);
$LIST[NAME]=STR_CUTTING($LIST[NAME], $NameLength);
if ($LIST[SubjectType] != "html" && $LIST[SubjectType] != "br") 
{
	$LIST[SUBJECT] = eregi_replace(" ", "&nbsp;", $LIST[SUBJECT]);
	$LIST[SUBJECT] = eregi_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $LIST[SUBJECT]);
}
$Picture=split("\|",$LIST[UPDIR1]);
?>
<?
$display[$no] = "<a href='#' onClick=\"imageChange('$Picture[0]')\"><img src='./config/wizboard/table/$UpdirPath/updir/$Picture[0]' width='60' height='75' border='0'></a>";
$imgtxt1[$no] = "./config/wizboard/table/$UpdirPath/updir/$Picture[0]";
?>
<?
$no++;
$BOARD_NO1--;
endwhile;
?>

<script language="javascript">
<!--
var alpha = 2;
var index = 0;
var inter = 100;
var bf = 'f';
var imgtxt1 = new Array();
var subjecttxt1 = new Array();
var urltxt1 = new Array();
var rowurl1 = new Array();
var menttxt1 = new Array();
<?
for($i=0; $i<sizeof($imgtxt1); $i++){
echo "imgtxt1[$i]  = '$imgtxt1[$i]'\n";
}
?>

function ch_port() {
    inter = 100;
    if (alpha > 100) {
        alpha=96;
        bf = 'b';
        inter = 1000;
    } else if (alpha < 0) {
        inter = 300;
        bf = 'f';

        index++;
        //alert("총갯수:4");
        //alert(index);
        
        if (index >= <?=$i?>) {
            index = 0;
        } 
        iimage1.src = imgtxt1[index];
        //subject1.innerHTML = subjecttxt1[index];
        //url1.innerHTML = urltxt1[index];
       // ment1.innerHTML = menttxt1[index];


        alpha=4;
    } else {
        if (bf == 'f') {
            alpha+=4;
        } else {
            alpha-=4;
        }
   sector1.style.filter = 'alpha(Opacity:' + alpha + ')';
        
    }
   window.setTimeout("ch_port();", inter);
}
//-->
</script>
<script language="JavaScript">
<!--
function imageChange(imgname){
	iimage1.src='./config/wizboard/table/<?=$UpdirPath?>/updir/'+imgname;
//	sector1.filters.blendTrans.stop();
     window.clearTimeout("10000000000");
}
//-->
</script>
<table width="650" height="392" border="0" cellpadding="0" cellspacing="0" bgcolor="DDDFEC">
													<tr> 
														<td align="right" valign="middle"><table width="312" height="371" border="0" cellpadding="0" cellspacing="0">
																<tr> 
																	<td height="18">&nbsp;</td>
																</tr>
																<tr> 
																	<td height="285"><table width="100%" height="95" border="0" cellpadding="0" cellspacing="0">
																			<tr> 
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
																						<tr> 
																							<td align="center" bgcolor="#FFFFFF"><?=$display[0]?></td>
																						</tr>
																					</table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[1]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[2]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[3]?>
                      </td>
                    </tr>
                  </table></td>
																			</tr>
																		</table>
																		<table width="100%" height="95" border="0" cellpadding="0" cellspacing="0">
																			<tr> 
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[4]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[5]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[6]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[7]?>
                      </td>
                    </tr>
                  </table></td>
																			</tr>
																		</table>
																		<table width="100%" height="95" border="0" cellpadding="0" cellspacing="0">
																			<tr> 
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[8]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[9]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[10]?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF">
                        <?=$display[11]?>
                      </td>
                    </tr>
                  </table></td>
																			</tr>
																		</table></td>
																</tr>
																<tr> 
																	<td>&nbsp;</td>
																</tr>
																<tr> 
																	<td align="center"><?
include "./wizboard/skin_btnm/${BOTTOM_SKIN_TYPE}/index.php";
?></td>
																</tr>
															</table></td>
														<td width="314"><table width="301" border="0" cellspacing="0" cellpadding="0">
																<tr> 
																	<td colspan="3"><img src="./wizboard/skin/<?=$BOARD_SKIN_TYPE;?>/images/gall.gif" width="301" height="17"></td>
																</tr>
																<tr> 
																	<td width="27"><img src="./wizboard/skin/<?=$BOARD_SKIN_TYPE;?>/images/gall2.gif" width="27" height="334"></td>
																	<td width="257"><table width="257" height="334" border="0" cellpadding="0" cellspacing="0" id="sector1">
																			<tr> 
																				<td bgcolor="#FFFFFF"><img src="<?=$imgtxt1[0]?>" width="257" height="334" id="iimage1" ></td>
																			</tr>
																		</table></td>
																	<td width="17"><img src="./wizboard/skin/<?=$BOARD_SKIN_TYPE;?>/images/gall3.gif" width="17" height="334"></td>
																</tr>
																<tr> 
																	<td colspan="3"><img src="./wizboard/skin/<?=$BOARD_SKIN_TYPE;?>/images/gall1.gif" width="301" height="20"></td>
																</tr>
															</table></td>
													</tr>
												</table>

<script>
<!--
// 최초 로딩시 초기화 시킨다.
ch_port();
//-->
</script>												