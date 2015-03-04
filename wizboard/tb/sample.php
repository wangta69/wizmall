<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>" />
<title>Untitled Document</title>
</head>

<body>
<form action="./index.php" method="post">
<input type="hidden" name="url" id="url" value="http://mall.shop-wiz.com/wizboard.php?BID=board02&amp;GID=root&amp;mode=view&amp;UID=8">
<input type="hidden" name="blog_name" id="blog_name" value="블로그명">
<input type="hidden" name="smode" value="qin">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>엮인글(블로그)</td>
    <td><input name="tb_url" type="text" id="tb_url" value="http://mall.shop-wiz.com/wizboard/tb/index.php/root/board02/8" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>제목</td>
    <td><input name="title" type="text" id="title" value="제목" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>내url</td>
    <td>http://mall.shop-wiz.com/wizboard.php?BID=board02&GID=root&mode=view&adminmode=&optionmode=&amp;UID=8&cp=1&BOARD_NO=8&SEARCHTITLE=&searchkeyword=&category=</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>블로그명</td>
    <td>블로그명</td>
    <td>&nbsp;</td>
  </tr>    
  <tr>
    <td>내용</td>
    <td><textarea name="excerpt" cols="50" id="excerpt">내용1
내용2</textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
</table>
</form>
$title		= $_POST[&quot;title&quot;];<br />
$excerpt	= $_POST[&quot;excerpt&quot;];<br />
$url		= $_POST[&quot;url&quot;];<br />
$blog_name	= $_POST[&quot;blog_name&quot;];
</body>
</html>
