<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../common/header_pop.php";

if (!strcmp($query,"qin") && $common -> checsrfkey($csrf)) :
/* 회원기본정보 변경 시작 */
$senddate = time();
$flag1 = "2";//2가 쪽지 모드
$sqlstr = "insert into wizmemo (senderid,receiverid,subject,texttype,content,senddate,receivedate,flag1) values ('admin','$receiverid','$subject','$texttype','$content','$senddate','$receivedate','$flag1')";
$dbcon->_query($sqlstr);
echo "<script >alert('정상적으로 발송되었습니다.');self.close();</script>";
exit;
endif;
?>
<?
include "../common/header_html.php";
?>
<script>
$(function(){
	$(".btn_submit").click(function(){
		$("#s_form").submit();
	});
});
</script>
<body>
<div> 
  <form id="s_form" action='<?php echo $PHP_SELF;?>' method="post">
  	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
    <input type="hidden" name="query" value="qin">
    <table class="table_popmain">
      <tr> 
        <td colspan=2>쪽지보내기</td>
      </tr>
      <tr> 
        <th>* 수신자 </th>
        <td> <input name="receiverid" type="text"  id="receiverid" value="<?php echo $id?>" size="15" readonly></td>
      </tr>
      <tr> 
        <th>* 제목 </th>
        <td> <input name="subject" type="text" id="subject" size="50">        </td>
      </tr>
      <tr> 
        <td colspan="2"><textarea name="content" id="content" style="height:150px" class="w100p"></textarea></td>
      </tr>
    </table>
    <br />
		<div class="agn_c">
			<span class="button bull btn_submit"><a>보내기</a></span>
			<span class="button bull"><a href='javascript:self.close();'>창닫기</a></span>
		</div>
  </form>
</div>
</body>
</html>
