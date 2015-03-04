<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include ("./USER_CHECK.php");
?>
<table class="table_outline">
  <tr>
    <td><fieldset class="desc">
						<legend>주소록 가져오기</legend>
						<div class="notice">[note]</div>
						<div class="comment">  </div>
						</fieldset>
						<p></p>	
						<table>

  <tr>
    <td>

<?

$addrfn = $HTTP_COOKIE_VARS[WIZMAIL_USER_ID] . ".csv";

/* CSV -> DB */
if(($dbupdate == "Y") and (file_exists("./maildata/$addrfn")) and (md5($key) == $key2))
{
	$file = fopen("./maildata/$addrfn", "r");
	$temp = fgets($file, 10000);

	$sql_delete = "delete from wizMailAddressBook where userid='$IUID'";
	$dbcon->_query($sql_delete);

	$date = time();
	$count = 0;
	while($temp = fgets($file, 10000))
	{
		$dat_temp = explode(",", $temp, 14);

		if(strlen(trim($dat_temp[0])) > 1)
		{
			if(strlen(trim($dat_temp[10])) > 1)
				$phone = trim($dat_temp[10]);
			else
				$phone = "1";

			/* 최대값 구하기 */
			$SQL = "select max(idx) as cnt from wizMailAddressBook where userid='$HTTP_COOKIE_VARS[WIZMAIL_USER_ID]'";
			$idx = $dbcon->get_one($SQL);
			$idx = $idx + 1;

			/* 쿼리문 조합 */
			$SQL = "insert into wizMailAddressBook values ";
			$SQL .= "($idx, ";
			$SQL .= "'$HTTP_COOKIE_VARS[WIZMAIL_USER_ID]', ";
			$SQL .= "'". strtoupper(trim($dat_temp[0])) ."', ";
			$SQL .= "'". strtoupper(trim($dat_temp[1])) ."', ";
			$SQL .= "'". trim($dat_temp[2]) ."', ";
			$SQL .= "'". trim($dat_temp[3]) ."', ";
			$SQL .= "'". trim($dat_temp[4]) ."', ";
			$SQL .= "'". trim($dat_temp[5]) ."', ";
			$SQL .= "'". trim($dat_temp[6]) ."', ";
			$SQL .= "'". trim($dat_temp[7]) ."', ";
			$SQL .= "'". trim($dat_temp[8]) ."', ";
			$SQL .= "'". trim($dat_temp[9]) ."', ";
			$SQL .= "'". trim($dat_temp[11]) ."', ";
			$SQL .= "'". trim($dat_temp[12]) ."', ";
			$SQL .= "'". trim($dat_temp[13]) ."', ";
			$SQL .= "'', ";
			$SQL .= "'$date', ";
			$SQL .= "'0', ";
			$SQL .= "'". $phone ."')";
			$dbcon->_query($SQL);
		}

		$count++;
	}

	fclose($file);
	unlink("./maildata/$addrfn");
}

/* CSV 파일 업로드 */
if(strlen($csvfn_name) > 3) 
{
	$datafolder = "./maildata/" . $addrfn;
	copy($csvfn, $datafolder);
	unlink($csvfn);

	$csv_upload = "Y";
}
?>
<table>
  <tr>
    <td colspan='2'>
<table>
  <tr> 
    <td colspan='2'>
	  <table>
        <tr> 
                      <td>&nbsp;</td>
<?

if($csv_upload == "Y")
	echo("<td>CSV --> DB</td>");
else
	echo("<td>PC --> SERVER</td>");

?>
        </tr>
      </table>
	</td>
  </tr>
  <tr> 
    <td colspan='2'> 
	  <table>
<?		

if($csv_upload != "Y"):
?>
        <tr> 
                      <td>&nbsp;&nbsp; CSV 파일</td>
<form method='post' action='<?=$PHP_SELF?>' name='addrbook' ENCTYPE='MULTIPART/FORM-DATA'>
<input type="hidden" name="menushow" value="<?=$menushow?>">
<input type="hidden" name="theme" value="<?=$theme?>">
          <td>&nbsp;<input type='file' name='csvfn' maxlength='10' class='input' onblur="this.style.backgroundColor='#F7F7F7'" onfocus="this.style.backgroundColor='#E2F5FF'"></td>
</form>
        </tr>
<? endif; ?>		
        <tr><td></td></tr>
	  </table>
<?

if(($csv_upload == "Y") and (file_exists("./maildata/$addrfn")))
{
	$file = fopen("./maildata/$addrfn", "r");
	$temp = fgets($file, 10000);

?>
	  <table class="table">
        <tr> 
          <td>이름</td>
          <td>그룹</td>
		  <td>전자우편</td>
		  <td>회사</td>
		  <td>부서</td>
		  <td>집전화</td>
		  <td>사무실전화</td>
		  <td>핸드폰</td>
        </tr>
<?		

$count = 0;
while($temp = fgets($file, 10000))
{
	$dat_temp = explode(",", $temp, 14);

?>
        <tr> 
          <td><?=$dat_temp[0]?></td>
          <td><?=$dat_temp[1]?></td>
		  <td><?=$dat_temp[2]?></td>
		  <td><?=$dat_temp[3]?></td>
		  <td><?=$dat_temp[4]?></td>
		  <td><?=$dat_temp[6]?></td>
		  <td><?=$dat_temp[7]?></td>
		  <td><?=$dat_temp[8]?></td>
        </tr>
<?		
	$count++;
}
fclose($file);
?>
      </table>
<?
}
?>
	</td>
  </tr>
  <tr> 
    <td colspan='2'>
<?

$key = time();
$key2 = md5($key);

if($csv_upload == "Y"):
?>
<a href="javascript:if(confirm('\n주소록을 업데이트합니다.\n\n업데이트 작업을 계속 진행하실려면 확인을 누르세요\n\n')){location.href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&dbupdate=Y&key=<?=$key?>&key2=<?=$key2?>';}"><img src='img/button12.gif' width="46"></a>
<?
else:
?>
<a href='javascript:document.addrbook.submit();'><img src='img/button12.gif' width="46"></a>
<?
endif;
?>
	</td>
  </tr>
</table>
	</td>
  </tr>
</table>
<?
mysql_close($DB_CONNECT);
?>
	</td>
  </tr>
</table>
</td>
  </tr>
</table>