  <form name="BOARD_WRITE_FORM" id="board_write_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="blank" value="">
    <!-- mysql에서 언어가 kr 이 아닌경우 modify시 맨처음 hidden값이 사라지는 알지못할 버그발생땜에 -->
    <input type="hidden" id="reple_hidden_bid" name="BID" value="">
    <input type="hidden" id="reple_hidden_gid" name="GID" value="">
    <input type="hidden" id="reple_hidden_mode" name="mode" value="reply">
    <input type="hidden" id="reple_hidden_bmode" name="bmode" value="reply">
    <input type="hidden" id="reple_hidden_adminmode" name="adminmode" value=">
    <input type="hidden" id="reple_hidden_optionmode" name="optionmode" value="">
    <input type="hidden" id="reple_hidden_uid" name="UID" value="">
	<input type="hidden" name="flag" value="list_only">
	 
    <input type="hidden" id="reple_hidden_CATEGORY" name="CATEGORY" value="">
    <input type="hidden" id="reple_hidden_ID" name="ID" value="">
    <input type="hidden" id="reple_hidden_spamfree" name="spamfree" value="">
     <input type="hidden" name="SUBJECT" value="한줄쓰기" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <col width="*" />
    <col width="1px" />
    <col width="100px" />
      <tr>
        <td class="agn_l"><textarea name="CONTENTS" rows="3" id="CONTENTS" checkenable msg="내용을 입력하세요" class="board_text"  style="width:98%;" /></textarea></td>
        <td align="center"></td>
        <td align="center"><span id="htmlSaveBtn"><span></td>
      </tr>


    </table>
  </form>