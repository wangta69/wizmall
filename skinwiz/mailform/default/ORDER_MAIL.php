<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>주문확인메일</title>
<link href='{url}/css/body.css' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin='5' topmargin='5' marginwidth='0' marginheight='0'>
<!-- Body Start -->
<table width='653' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='650' background='{url}/images/body.gif'><table width='650' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td height='50'><table width='650' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td width='2'><img src='{url}/images/img_top_l.gif' width='2' height='50'></td>
                <td background='{url}/images/bg_top.gif'><img src='{url}/images/img_order.gif' width='650' height='118'></td>
                <td width='2'><img src='{url}/images/img_top_r.gif' width='2' height='50'></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align='center'><table width='600' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td height='80' colspan='2' bgcolor='#F1F1F1'><table width='565' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='43'>&nbsp;</td>
                      <td class='company'>안녕하세요. <strong>{username}</strong> 고객님<br>
                        <br>
                        저희 {admin.title} 을 이용해 주셔서 대단히 감사합니다.<br>
                        고객님께서 주문하신 내역을 확인해 드립니다.</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan='2'>&nbsp;</td>
              </tr>
              <tr>
                <td colspan='2'>{ORDERLIST}
                  <table width='600' border='0' cellpadding='0' cellspacing='0' class='company'>
                    <tr>
                      <td height='3' colspan='3' bgcolor='#83A1C7'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>주문번호&nbsp; 
                        &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'><font color='618DC4'><strong>{orderid}</strong></font></td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>받으시는분&nbsp; 
                        &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'>{rname}</td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>연락처&nbsp; 
                        &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'>&nbsp;{rtel1}</td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>받으실 
                        분 주소&nbsp; &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'>{raddress}</td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>결재방법&nbsp; 
                        &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'>{paymethod}</td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td width='200' height='27' align='right' bgcolor='#f3f3f3'><font color='#144179'>구매일&nbsp; 
                        &nbsp; &nbsp; </font></td>
                      <td width='1' height='27'><img src='{url}/images/img_a.gif' width='12' height='27'></td>
                      <td width='399' height='27'>{buydate}</td>
                    </tr>
                    <tr>
                      <td height='1' colspan='3' bgcolor='#cfcfcf'></td>
                    </tr>
                    <tr>
                      <td height='3' colspan='3' bgcolor='#83A1C7'></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan='2'>&nbsp;</td>
              </tr>
              <tr>
                <td height='76' colspan='2' align='center' background='{url}/images/bg_b.gif'><table width='565' height='50' border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                      <td width='180' height='64'><img src='{url}/images/img_b.gif' width='190' height='50'></td>
                      <td width='49' class='company'> 비회원 <br>
                        회원<br>
                        <br>
                      </td>
                      <td width='336' class='company'>: 주문번호를 통해 직접 조회하실 수 있습니다.<br>
                        : 로그인하신후 주문번호를 클릭하시면 자세한 내역을 <br>
                        &nbsp; 조회 하실 수 있습니다.</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan='2'>&nbsp;</td>
              </tr>
              <tr align='center'>
                <td width='300'><form action='{homeurl}/wizmember/LOG_CHECK.php' target='_blank'>
                    <input type=hidden name='goto' value='order'>
                    <table width='290' border='0' cellspacing='0' cellpadding='0'>
                      <tr>
                        <td height='27' bgcolor='#D8D8D8' class='company'>&nbsp; <font color='#000000'><strong>회원로그인</strong> 조회</font></td>
                      </tr>
                      <tr>
                        <td height='60' align='center' bgcolor='#F6F6F6'><table width='257' border='0' cellpadding='0' cellspacing='0' class='company'>
                            <tr>
                              <td width='57'>아이디</td>
                              <td width='10'>:</td>
                              <td width='122'><input name='wizmemberID' type='text' size='17'></td>
                              <td width='60' rowspan='2' align='center'><input type=image src='{url}/images/but_s.gif' width='36' height='36'></td>
                            </tr>
                            <tr>
                              <td>비밀번호</td>
                              <td>:</td>
                              <td><input name='wizmemberPWD' type='text' size='17'></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </form></td>
                <td width='300'><form action='{homeurl}/wizmember.php' target='_blank'>
                    <INPUT TYPE='hidden' NAME='query' VALUE='non_member_order'>
                    <table width='290' border='0' cellspacing='0' cellpadding='0'>
                      <tr>
                        <td height='27' bgcolor='#D8D8D8' class='company'>&nbsp; <font color='#000000'><strong>주문번호로</strong> 조회 (비회원)</font></td>
                      </tr>
                      <tr>
                        <td height='60' align='center' bgcolor='#F6F6F6'><table width='246' border='0' cellpadding='0' cellspacing='0' class='company'>
                            <tr>
                              <td width='57'>주문번호</td>
                              <td width='10'>:</td>
                              <td width='122'><input name='OrderID' type='text' size='17' value='{orderid}'>
                              </td>
                              <td width='60' align='center'><input type='image' img src='{url}/images/but_s.gif' width='36' height='36'></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height='65' align='right'><table width='450' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td width='425' align='right' class='company'>{admin.title}을 이용해주셔서 
                  감사합니다.<br></td>
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
<!-- Body End -->
</body>
</html>
