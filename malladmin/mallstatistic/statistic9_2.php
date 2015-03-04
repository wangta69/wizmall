<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***
*/

if (!strcmp($action,"save")) :
$Cdate = time();
$sqlstr = "insert into wizdailyaccount (CMID,Ccredititem,Ccreditprice,Cincomprice,Cdate)
 values('$mid','$Ccredititem','$Ccreditprice','$Cincomprice','$Cdate')";
$dbcon->_query($sqlstr);

echo "<script  language='javascript'>
window.alert('\\n\\n 성공적으로 저장되었습니다.\\n\\n');
opener.location.replace('./main.php?menushow=$menushow&theme=statistic9_1&mid=$mid');
self.close();
</script>";
exit;
endif;
?>
<?
/* 회원정보가져오기 */
$sqlstr = "SELECT CompName, CompNum FROM wizCom where CompID = '$mid'";
$sqlqry= $dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array( );
?>
<html>
<head><title>장부 쓰기 페이지</title>
<style>
<!--
A:link {text-decoration:none; color:black;}
A:visited {text-decoration:none; color:black;}
A:hover {  color:#081E8A;}
p,br,body,td {color:black; font-size:9pt; line-height:140%;}
-->
</style>
<link rel="stylesheet" href="../common/admin.css" type="text/css">
</head>
<body>
    <div align=center>
<form action='<?=$PHP_SELF;?>' method="post"> 
<input type="hidden" name='action' value='save'> 
<input type="hidden" name='mid' value='<?=$mid?>'>
    <table>
      <tr> 
        <td colspan=4>&nbsp; 미수관리 
          페이징빈다.</td>
      </tr>
      <tr> 
        <td>* 회원코드(아이디)</td>
        <td colspan=3> &nbsp;
          <?=$mid?>
        </td>
      </tr>
      <tr> 
        <td>* 상호</td>
        <td colspan="3"> &nbsp;
          <?=$list[CompName]?>
        </td>
      </tr>
      <tr> 
        <td>* 사업자등록(허가)번호</td>
        <td colspan="3">&nbsp;
          <?=$list[CompNum]?>
        </td>
      </tr>
      <tr> 
        <td>* 내역</td>
        <td colspan=3>&nbsp;
          <input type="text" name="Ccredititem" size="20"></td>
      </tr>
      <tr> 
        <td>* 매출액</td>
        <td colspan=3>&nbsp;
          <input type="text" name="Ccreditprice" size="20"></td>
      </tr>
      <tr> 
        <td>* 입금액</td>
        <td colspan=3>&nbsp;
          <input type="text" name="Cincomprice" size="20"></td>
      </tr>
    </table>
    <br />
<table>
  <tr> 
        <td colspan="2"><input type="image" src="img/dung.gif" width="53" >
          &nbsp; &nbsp; <img src="img/order_icon4.gif" width="66"  onclick='javascript:top.close();' style="cursor:pointer"> 
        </td>
  </tr>

</table> </form></div>
</body>
</html>