<?
/************************************************/
/**                                            **/
/**    프로그래명 : wizMailer For wizMall      **/
/**                                            **/
/**    수정자 : 폰돌                           **/
/**                                            **/
/**    수정일 : 2002.8.20                      **/
/**    두번째 수정일 : 2003. 05.13             **/
/************************************************/
/* 위즈몰용으로 기존 프로그램을 수정보완하였습니다.
현재 프로그램을 wizMember의 wizMembers DB와 호환되게 다시 수정 보완 배포합니다.
E-mail : master@shop-wiz.com
Url : http://www.shop-wiz.com
상업적 목적이 없는 한 수정 및 재 배포가 자유롭습니다. 
단, 수정시 상기를 표시해 주시면 감솨여....^^
Upgrade 2003.08.20 wizmall에 맞게 재구성
2003.10.10  성별 에러 발생되던 것을 수정 및 등급별 발송 선택
2004.09.17  버그 수정(wizSendmaillist )
 */
include ("../config/cfg.core.php");

$sqlstr = "select * from wizSendmaillist  where uid = '$uid'";
$sqlqry =  $dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
$list[comment] = nl2br(stripslashes($list[comment]));
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">메일발송내용</div>
	  <div class="panel-body">
		 발송되었던 메일 내용입니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>
     <table class="table">
        <tr>
          <td>보내는 분</td>
          <td>
            <?=$list["sendername "]?>
            (
            <?=$list["senderemail"]?>
            ) </td>
        </tr>
        <tr>
          <td>받는
            분</td>
          <td>
            <textarea name="textarea" cols="100" rows="5" wrap="physical" id="textarea"><?=$list["tomember"]?>
</textarea>>
            </td>
        </tr>
        <tr>
          <td>제목</td>
          <td>
            <?=$list["subject"]?>
            </td>
        </tr>
        <tr>
          <td>내 용</td>
          <td>
            <?=$list["body_txt"]?>
             </td>
        </tr>
      </table>
      <br />
       </td>
  </tr>
</table>
