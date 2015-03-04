<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.webpiad.co.kr
Email : master@webpiad.co.kr
*** Updating List ***
*/

include "../../../lib/cfg.common.php";
include "../../config/cfg.core.php";
include "../../../config/db_info.php";
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<style type="text/css">
<!--
a:link {  font-family: "굴림", "굴림체"; font-size: 9pt; color: 5D5D5D; text-decoration: none}
a:visited {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #999999; text-decoration: none}
a:active {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #0099CC; text-decoration: underline}
a:hover {  font-family: "굴림", "굴림체"; font-size: 9pt; color: 038CC0; text-decoration: underline}

.txt {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #333333; line-height: 15pt}
.text1{ font-family: "굴림"; font-size: 8pt; color: #666666; line-height: 14px}
.text2 { font-family: "굴림"; font-size: 9pt; color: #333333; padding-left: 5pt}
.text3 {
	font-family: "굴림";
	font-size: 10pt;
	color: #CCCCCC;
	padding-left: 5pt;
	font-weight: bolder;
}
BODY, TEXTAREA,TABLE, TR, TD, INPUT{font-size:12px; font-family:굴림;}
a:link,a:visited {color: #666666; text-decoration: none}
a.com:hover {color: #B47F0C; text-decoration: underline}
-->
</style>
<script language="JavaScript">
<!--
function ChangeImage(ImgName) { 
PathImg = "../../../wizstock/"+ImgName;
    if(ImgName != ""){
    document.all.GoodsBigPic.filters.blendTrans.stop();
    document.all.GoodsBigPic.filters.blendTrans.Apply();
    document.all.GoodsBigPic.src=PathImg;
    document.all.GoodsBigPic.filters.blendTrans.Play();
        }  
		
document['GoodsBigPic'].src = PathImg; 
}
-->
</script>
</head>
<?
/* Get a information of a piece of First Image */ 
$sqlstr="SELECT * FROM wizMall WHERE UID = '$no'";
$dbcon->_query($sqlstr);
$list = $dbcon->_get_row();
$Picture = explode("|", $list[Picture]);
?>
<body>
<table>
  <tr> 
    <td> 
      <table>
        <tr> 
          <td> 
            <table>
			              <tr> 
                <td>
<table>
                    <tr> 
                      <td></td>
                      <td><?=$cfg["admin"]["HOME_URL"]?></td>
                      <td></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td><a href="javascript:window.close();"> 
                  <img name="GoodsBigPic" src='../../../wizstock/<?=$Picture[1]?>' style="filter:blendTrans(duration=0.5)"></a></td>
              </tr>
            </table>
          </td>
          <td></td>
          <td> 
            <table>
              <tr> 
                <td><br />
                  <table>
                    <tr> 
                      <td> <table>
                          <tr> 
                            <td>
                              <?=$list[Name]?>
                               </td>
                          </tr>
<?if($list[Model]):?>						  
                          <tr> 
                            <td>모델명 | 
                              <?=$list[Model]?>
                            </td>
                          </tr>
<? endif;?><?if($list[Brand]):?>						  
                          <tr> 
                            <td>제조사 | 
                              <?=$list[Brand]?>
                            </td>
                          </tr>
<? endif;?><?if($list[Point]):?>						  
                          <tr> 
                            <td>적립포인트 | 
                              <?=number_format($list[Point])?>
                            </td>
                          </tr>
<? endif; ?>						  
                          <tr> 
                            <td> 가격 | \ 
                              <?=number_format($list[Price])?>
                              </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td background="images/pro_line.gif"></td>
                    </tr>
                    <tr> 
                      <td> <table>
                          <tr> 
                            <?
$NO=0;
for($i=1; $i < sizeof($Picture)-1; $i++){
?>
                            <td> <table width="61">
                                <tr> 
                                  <td><img src="../../../wizstock/<?=$Picture[$i]?>" onMouseOver="ChangeImage('<?=$Picture[$i]?>')"></td>
                                </tr>
                              </table></td>
                            <?
// && $NO != $Total
if(!($i%3)) ECHO"</tr><tr>";
}
?>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td></td>
                    </tr>
                    <tr> 
                      <td>이미지위에 마우스 커서를 올려두시면 확대이미지를 보실수 
                        있습니다.</td>
                    </tr>
                    <tr> 
                      <td><a href="javascript:window.close();"><img src="./picviewimages/close_btn.gif" width="47" height="21" hspace="5"></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
</body>
</html>