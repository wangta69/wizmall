<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>아이디패스워드찾기</title>
<link href='{url}/css/body.css' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin='5' topmargin='5' marginwidth='0' marginheight='0'>
<table width='653' border='0' cellspacing='0' cellpadding='0'>
  <tr> 
    <td width='650' background='{url}/images/body.gif'><table width='650' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td height='50'><table width='650' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td width='2'><img src='{url}/images/img_top_l.gif' width='2' height='50'></td>
                <td background='{url}/images/bg_top.gif'>&nbsp;</td>
                <td width='2'><img src='{url}/images/img_top_r.gif' width='2' height='50'></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><img src='{url}/images/but_id.gif' width='650' height='118'></td>
        </tr>
        <tr>
          <td align='center'><table width='600' border='0' cellspacing='0' cellpadding='0'>
              <tr height='4'> 
                <td height='4' colspan='3' bgcolor='EAEAEA'></td>
              </tr>
              <tr> 
                <td width='30' height='210'>&nbsp;</td>
                <td class='company'><table width='530' border='0' cellpadding='0' cellspacing='0' class='company'>
                    <tr> 
                      <td height='120'><strong>개인정보</strong> 안내입니다.<br> <br>
                        고객님께서 검색하신 성함과 주민등록번호등이 일치하여 개인정보를 발송하여 드리니,<br>
                        홈페이지에서 접속하셔서 가급적 비밀번호를 변경하여 주시기 바랍니다.</td>
                    </tr>
                    <tr> 
                      <td height='100' align='center' valign='top'> 
                        <table width='329' border='0' cellpadding='0' cellspacing='0' class='company'>
                          <tr> 
                            <td height='3' colspan='3' bgcolor='#93C191'></td>
                          </tr>
                          <tr> 
                            <td width='120' height='27' align='right' bgcolor='#f3f3f3'><font color='#006600'>회원 
                              ID &nbsp; &nbsp; &nbsp; </font></td>
                            <td width='12' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                            <td width='157' height='27'><font color='#006600'><strong>{userid}</strong></font></td>
                          </tr>
                          <tr> 
                            <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                          </tr>
                          <tr> 
                            <td width='120' height='27' align='right' bgcolor='#f3f3f3'><font color='#006600'>임시비밀번호 
                              &nbsp; &nbsp; &nbsp; </font></td>
                            <td width='12' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                            <td width='157' height='27'>{userpwd}</td>
                          </tr>
                          <tr> 
                            <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                          </tr>
                          <tr> 
                            <td height='3' colspan='3' bgcolor='#93C191'></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width='30' class='company'>&nbsp;</td>

              </tr>
              <tr height='1'> 
                <td width='30' height='1'></td>
                <td height='1' background='{url}/images/bg_jumsun.gif'></td>
                <td width='30' height='1'></td>
              </tr>
              <tr> 
                <td width='30'>&nbsp;</td>
                <td><table width='257' border='0' cellspacing='0' cellpadding='0'>
                    <tr> 
                      <td width='122'><a href='{homeurl}' target="_blank"><img src='{url}/images/but_shopping.gif' width='122' height='48' border='0'></a></td>
                      <td align='right'><a href='{homeurl}/wizmember.php?query=info' target="_blank"><img src='{url}/images/but_info.gif' width='105' height='48' border='0'></a></td>
                    </tr>
                  </table></td>
                <td width='30'>&nbsp;</td>
              </tr>
              <tr height='4'> 
                <td height='4' colspan='3' bgcolor='EAEAEA'></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height='65' align='right'><table width='245' border='0' cellspacing='0' cellpadding='0'>
              <tr> 
                <td class='company'>{admin.title}<br>
                  {admin.name}</td>
                <td width='25'>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height='88' align='center' background='{url}/images/bg_bottom.gif' class='company'>공정거래위원회 
            고시 제2000-1호에 따른 안내 사업자번호 : {admin.companynum}<br>
            주소 :{admin.companyaddress}상호 : {admin.companyname} 대표자명 : {admin.companyceo}<br>
            쇼핑몰명:{admin.title} ☎ 연락처 : {admin.companytel}, 팩스번호: {admin.companyfax}</td>
        </tr>
      </table></td>
    <td width='3' valign='top' bgcolor='E4E4E4'><img src='{url}/images/img_r.gif' width='3' height='4'></td>
  </tr>
  <tr bgcolor='E4E4E4'> 
    <td height='3' colspan='2' valign='top'><img src='{url}/images/img_l.gif' width='3' height='3'></td>
  </tr>
</table>
</body>
