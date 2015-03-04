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
$result = $board->getboardlist();
$cnt=0;
while($dbcon->_data_seek($result,$cnt)):
	$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata.="&search_term=".$search_term."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".urlencode($searchkeyword);
	$getdata = $common->getencode($getdata);
	
	$filepath = "./config/wizboard/table/$UpdirPath/updir/".$list["UPDIR1"][0];
	if (is_file($filepath)){
		list($imgwidth, $imgheight, $imgtype, $imgattr) = getimagesize($filepath);
		if($imgwidth > $imgheight){
			$width = "60";
			$bigwidth = "257";
			$height = "40";
			$bigheight = "164";
		}else{
			$width = "60";
			$bigwidth = "257";
			$height = "75";
			$bigheight = "334";
		} 
	}

	$display[$cnt] = "<a href=\"javascript:slidepause('$cnt')\"><img src='".$filepath."' width='$width' height='$height' border='0'></a>";
	$imgtxt1[$cnt] = $filepath;
	$imgwidth1[$cnt] = $bigwidth;
	$imgheight1[$cnt] = $bigheight;
	$img[$cnt] = trim($list["UPDIR1"][0]);
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */

endif;
?>

<script language="javascript">
<!--
var imgs = new Array();
var imgswidth = new Array();
var imgsheight = new Array();
<?
for($i=0; $i<sizeof($imgtxt1); $i++){
echo "imgs[$i] = '$imgtxt1[$i]'\n";
echo "imgswidth[$i] = '$imgwidth1[$i]'\n";
echo "imgsheight[$i] = '$imgheight1[$i]'\n";
}
?>

var sliding = 0;

function init()
{
	if ( sliding != 1 ) return;
	slideplay();
}


if ( imgs.length > 0 )
{
	var imgpreload = new Array();
	var imgpreloadwidth = new Array();
	var imgpreloadheight = new Array();
	for ( i=0; i<=imgs.length-1;i++)
	{
		imgpreload[i] = new Image();
		//imgpreloadwidth[i] = new Image();
		//imgpreloadheight[i] = new Image();
		imgpreload[i].src = imgs[i];
		imgpreload[i].width = imgswidth[i];
		imgpreload[i].height = imgsheight[i];
	}

	var changetime = 2500;
	var curimg = -1;
	var playing = 0;
	sliding = 1;
}

function imgchange(imgsrc)
{
	eval('slideimg.filters.blendTrans.stop();');
	eval('slideimg.style.filter="blendTrans(duration=1.5)"');
	eval('slideimg.filters.blendTrans.Apply();');
	eval('slideimg.src='+imgsrc+'.src;');
	eval('slideimg.width='+imgsrc+'.width;');
	eval('slideimg.height='+imgsrc+'.height;');
	eval('slideimg.filters.blendTrans.Play();');
}

function imgmsg(i)
{
	if ( i == "" ) return;
	eval('slideimg.filters.blendTrans.stop();');
	eval('slideimg.style.filter="blendTrans(duration=1.5)"');
	eval('slideimg.filters.blendTrans.Apply();');
	slideimg.src=i;
	eval('slideimg.filters.blendTrans.Play();');
	slidepause();
}



function slideshowstart()
{
	if ( playing == 1 )
	{
		if ( curimg == imgs.length -1 ) curimg = 0;
		else curimg++;
		imgchange('imgpreload[curimg]');
		setTimeout("slideshowstart()",2500);
	}
}

function slideplay()
{
	if ( sliding != 1 ) return;
	if ( playing == 1 ) return;
	playing = 1;
	//setTimeout("slideshowstart()",0);
	slideshowstart();
}

function slidepause(n)
{
	if ( n )
	{
		curimg = n;
		imgchange('imgpreload[curimg]');
	}
	if ( sliding != 1 ) return;
	playing = 0;
}

function slidenext()
{
	if ( curimg == imgs.length -1 ) curimg = -1;
	curimg = curimg + 2;
	slidepause(curimg);
}

function slideprev()
{
	if ( curimg == 0 ) curimg = imgs.length;
	slidepause(curimg);
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
																							<td align="center" bgcolor="#FFFFFF"><? if($display[0]) echo $display[0]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?></td>
																						</tr>
																					</table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[1]) echo $display[1]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[2]) echo $display[2]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[3]) echo $display[3]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
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
                        <? if($display[4]) echo $display[4]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[5]) echo $display[5]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[6]) echo $display[6]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[7]) echo $display[7]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
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
                        <? if($display[8]) echo $display[8]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[9]) echo $display[9]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="EFEFEF"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[10]) echo $display[10]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
                      </td>
                    </tr>
                  </table></td>
																				<td width="78" align="center" bgcolor="F7F7F7"><table width="60" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFFFF"> 
                        <? if($display[11]) echo $display[11]; else echo "<img src='./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"]."/images/blankimg.gif' width='60' height='75' border='0'>";?>
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
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?></td>
																</tr>
															</table></td>
														<td width="314"><table width="301" border="0" cellspacing="0" cellpadding="0">
																<tr> 
																	<td colspan="3"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/gall.gif" width="301" height="17"></td>
																</tr>
																<tr> 
																	<td width="27"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/gall2.gif" width="27" height="334"></td>
																	<td width="257"><table width="257" height="334" border="0" cellpadding="0" cellspacing="0">
																			<tr> 
																				<td bgcolor="#FFFFFF"><? if($img[0]): ?><img src="<?=$imgtxt1[0]?>" width="257" height="334" name="slideimg" style="filter:blendTrans(duration=1.5);"><? endif; ?></td>
																			</tr>
																		</table></td>
																	<td width="17"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/gall3.gif" width="17" height="334"></td>
																</tr>
																<tr> 
																	<td colspan="3"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/gall1.gif" width="301" height="20"></td>
																</tr>
															</table></td>
													</tr>
												</table>												
<script language="JavaScript">
<!--
init();
//-->
</script>											