<?
	include "../../../lib/cfg.common.php";
	include "../../../config/db_info.php";
	include "../../../lib/class.database.php";
	$dbcon	= new database($cfg["sql"]);
	include "../../../lib/class.cart.php";
	$cart	= new cart();
	
    /* 
    REDIRPATH 페이지는 결제가 완료되고, DBPATH 페이지의 결과 저장까지 완료된 후,
    결제 창을 종료하면 redirection 되는 구매자 결제정보 확인 페이지 입니다.
    */
    /* 
    아래와 같은 값이 GET 방식으로 전송됩니다. 자세한 설명은 매뉴얼을 참고바랍니다.
    
    $MxIssueNO  // 거래 번호 (결제 요청시 사용값)
    $MxIssueDate  // 거래 일시 (결제 요청시 사용값) 
    $Amount  // 거래 금액
    $MSTR2  // 가맹점 return 값
    $ReplyCode  // 결과 코드
    $ReplyMessage  // 결과 메시지
    $Smode  // 결제 수단 구분 코드
    $CcCode  // 카드 코드 (신용카드인 경우)
    $Installment  // 할부 개월수 (신용카드인 경우)
    $BkCode  // 은행코드 (뱅크타운 계좌이체인 경우)
    */
    
    if (phpversion() >= 4.2) { // POST, GET 방식에 관계 없이 사용하기 위해서
        if (count($_POST)) extract($_POST, EXTR_PREFIX_SAME, 'VARS_');
        if (count($_GET)) extract($_GET, EXTR_PREFIX_SAME, '_GET');
    }

    $Sname = "신용카드"; 
    if($Smode!=null) {
        if($Smode=="3001"||$Smode=="3005"||$Smode=="3007") $Sname = "신용카드";
        else if($Smode=="2500"||$Smode=="2501") $Sname = "계좌이체";  // 금결원
        else if($Smode=="2201"||$Smode=="2401") $Sname = "계좌이체";  // 핑거, 뱅크타운
        else if($Smode=="6101") $Sname = "휴대폰결제";
        else if($Smode=="8801") $Sname = "ARS전화결제";
        else if($Smode=="2601") $Sname = "가상계좌";
        else if($Smode=="5101") $Sname = "도서상품권";
        else if($Smode=="5301") $Sname = "복합결제";
        else if($Smode=="0001") $Sname = "현금영수증";
    }  


//include "../../../config/db_info.php";
//include "../../../lib/class.database.php";
//$dbcon	= new database($cfg["sql"]);

$sqlstr = "select * from wizBuyers where OrderID = '$MxIssueNO'";
$sqlqry = $dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
if($ReplyCode!=null && ($ReplyCode=="00003000" || ($Smode=="2601" && $ReplyCode=="00004000"))) { 
		$cart->payresult_location($MxIssueNO, true);
} else {
	$cart->payresult_location($OrderNo, false);
}
?>
							
<HTML>
<HEAD>
<TITLE>:::::TGCORP 결과 확인:::::</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; <?=$cfg["common"]["lan"]?>"/>
<STYLE type="text/css">
    BODY { 
        scrollbar-3dlight-color:#888888;
        scrollbar-arrow-color:#888888;
        scrollbar-track-color:#FFFFFF;
        scrollbar-darkshadow-color:#888888;
        scrollbar-face-color:#FFFFFF;
        scrollbar-highlight-color:#FFFFFF;
        scrollbar-shadow-color:#FFFFFF
    }
    BODY { font-family:돋움; font-size:9pt;color:#000000; text-decoration:none;}
    TD { font-family:돋움; font-size:9pt;color:#000000; text-decoration:none;}
</STYLE>
</HEAD>
    
<BODY BGCOLOR="#FFFFFF" LEFTMARGIN="10" TOPMARGIN="10" MARGINWIDTH="0" MARGINHEIGHT="0">

<TABLE border="0" align="center" cellpadding="0" cellspacing="0">
<TR>
    <TD width=9 height=7 ><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_t_left.gif"></TD>
    <TD width="600" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_t_center.gif"></TD>
    <TD><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_t_right.gif"></TD>
</TR>
<TR>
    <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_m_left.gif"></TD>
    <TD bgcolor="#FFFFFF" align="center" width="600">
        <TABLE width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
            <TR>
                <TD><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/top_banner.gif"></TD>
            </TR>
            <TR>
                <TD height="20">&nbsp;</TD>
            </TR>
            <TR>
                <TD bgcolor="#FFFFFF" align="center" valign="top">
                    <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                        <TR>
                            <TD align="right" height="30"><b>결제 요청 결과</b> (<? echo $Sname; ?>) : </TD>
                            <? if($ReplyCode!=null && ($ReplyCode=="00003000" ||
                                    ($Smode=="2601" && $ReplyCode=="00004000"))) { ?>
                            <!-- ※ 가상계좌 발급성공 = "00004000" -->
                            <TD align="left" height="30">&nbsp;결제 성공했습니다.</TD>
                            <? } else { ?>
                            <TD align="left" height="30">&nbsp;결제 실패했습니다.</TD>
                            <? } ?>
                        </TR>
                    </TABLE>
                </TD>
            </TR>
            <TR>
                <TD height="20">&nbsp;</TD>
            </TR>
            <TR>
                <TD width="100%" bgcolor="#FFFFFF" align="center" valign="top">
                    <TABLE align="center" border="0" cellspacing="0" cellpadding="0">
                        <TR>
                            <TD width="20"><TD>
                            <TD width="560">
                                <TABLE align="center" border="0" cellspacing="0" cellpadding="0">
                                    <TR>
                                        <TD width="7" height="7"><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_t_left.gif"></TD>
                                        <TD width="546" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_t_center.gif"></TD>
                                        <TD width="7" height="7"><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_t_right.gif"></TD>
                                    </TR>
                                    <TR>
                                        <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_m_left.gif"></TD>
                                        <TD width="546" align="center">
                                            <!--결제 내역-->
                                            <TABLE width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                                                <TR> 
                                                    <TD colspan="2" align="center" height="30" bgcolor="#F7D9FF">
                                                    <IMG ALIGN="absmiddle" SRC="http://npg.tgcorp.com/dlp/nondlp/cpguide/icon_member_02.gif">
                                                    <FONT style="color:black;">&nbsp;결제 정보 확인</FONT>
                                                    </TD>
                                                </TR>
                                                <TR>
                                                    <TD width="45%" align="right" height="20">거래번호 : </TD>
                                                    <TD width="55%" align="left" height="20">&nbsp;<? if($MxIssueNO!=null) echo $MxIssueNO; ?></TD>
                                                </TR>
                                                <TR><TD height="1" colspan="2" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/bg_dot.gif"></TD></TR>
                                                <TR>
                                                    <TD width="45%" align="right" height="20">거래일자 : </TD>
                                                    <TD width="55%" align="left" height="20">&nbsp<? if($MxIssueDate!=null) echo $MxIssueDate; ?></TD>
                                                </TR>
                                                <TR><TD height="1" colspan="2" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/bg_dot.gif"></TD></TR>
                                                <TR>
                                                    <TD width="45%" align="right" height="20">결제금액 : </TD>
                                                    <TD width="55%" align="left" height="20">&nbsp;<? if($Amount!=null) echo $Amount; ?> 원</TD>
                                                </TR>
                                                <TR><TD height="1" colspan="2" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/bg_dot.gif"></TD></TR>
                                                <TR>
                                                    <TD width="45%" align="right" height="20">결과코드 : </TD>
                                                    <TD width="55%" align="left" height="20">&nbsp;<? if($ReplyCode!=null) echo $ReplyCode; ?></TD>
                                                </TR>
                                                <TR><TD height="1" colspan="2" background="http://npg.tgcorp.com/dlp/nondlp/cpguide/bg_dot.gif"></TD></TR>
                                                <TR>
                                                    <TD width="45%" align="right" height="20">결과메시지 : </TD>
                                                    <TD width="55%" align="left" height="20">&nbsp;<? if($ReplyMessage!=null) echo $ReplyMessage; ?></TD>
                                                </TR>
                                            </TABLE>
                                        </TD>
                                        <!--결제 내역 끝-->
                                        <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_m_right.gif"></TD>
                                    </TR>
                                    <TR>
                                        <TD width="7" height="7"><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_b_left.gif"></TD>
                                        <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_b_center.gif"></TD>
                                        <TD width="7" height="7"><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/inline_b_right.gif"></TD>
                                    </TR>
                                </TABLE>
                            </TD>
                            <TD width="20">&nbsp;</TD>
                        </TR>
                    </TABLE>
                </TD>
            </TR>
            <TR><TD>&nbsp;</TD></TR>
            <TR>
                <TD height="46" align="center" valign="middle">
                <a href="index.html"><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/btn_payresult.gif" border="0"></a>
                </TD>
            </TR>
            <TR><TD>&nbsp;</TD></TR>
            <TR>
                <TD><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/allright.gif"></TD>
            </TR>
        </TABLE>
    </TD>
    <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_m_right.gif"></TD>
</TR>
<TR>
    <TD width=9 height=10><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_b_left.gif"></TD>
    <TD background="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_b_center.gif"></TD>
    <TD><img src="http://npg.tgcorp.com/dlp/nondlp/cpguide/line_b_right.gif"></TD>
</TR>
</TABLE>
</BODY>
</HTML>
