<?php
header("Content-Type: text/html; charset=euc-kr"); 
//이부분은 연동으로 인해 euc-kr로 코딩 되어야 함
include "../../../config/db_info.php";
include "../../../config/cfg.core.php";
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

$sqlstr = "select m.Name from wizCart c 
left join wizMall m on c.pid = m.UID 
where c.oid = ".$_COOKIE["CART_CODE"];
$sqlqry = $dbcon->_query($sqlstr);
$cnt=0;
while($list = $dbcon->get_rows()):
$goods_name[$cnt] = iconv("UTF-8", "EUC-KR", $list["Name"]);
$cnt++;
endwhile;
$show_goods_name = $goods_name[0];
if (count($goods_name) > 1){
	$showcount = count($goods_name) - 1;
	$show_goods_name .= "외 ".$showcount."종";
}

$sqlstr = "select b.* from wizBuyers b
left join wizMembers m on b.MemberID = m.mid 
left join wizMembers_ind i on b.MemberID = i.id
where b.OrderID = '".$_COOKIE["CART_CODE"]."'";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

$MxID = $cfg["pay"]["CARD_ID"];
$MxIssueNO=$cod; /* 주문번호 */
$Name = $CcNameOnCard=iconv("UTF-8", "EUC-KR", $list["SName"]); /* 주문자명 */
$CcProdName = $CcProdDesc=$show_goods_name; /* 상품명 */
$Amount=$list["AmountPg"] ; /* 결제금액 */
$OrderTelNo=$list["STel1"];
$Email=$list["SEmail"];
$deliverName=iconv("UTF-8", "EUC-KR", $list["RName"]);
$OrderAddr="(".$list["RZip"].") ".iconv("UTF-8", "EUC-KR", $list["RAddress1"])." ".iconv("UTF-8", "EUC-KR", $list["RAddress2"]);

switch($paytype){
	case "card":
		$Smode = "3001";
	break;
	case "hand":
		$Smode = "6101";
	break;	
	case "autobank":
		$Smode = "2500";
	break;	
	case "all":
		$Smode = "3001";
	break;		
	default:
		$Smode = "3001";
	break;
}
?>
<SCRIPT language="javascript">

    /**
        결제 요청 함수 (결제창 호출)
    */
    function reqPayment() {
       // setSmode(); // 예제 테스트를 위한 함수 (Smode_tmp->Smode)
		//alert(document.payform.Smode.value)
        if(document.payform.Smode.value!="0002" && document.payform.Smode.value!="0003") 
        { // 현금영수증 직접 전송은 팝업을 이용하지 않음
            TG_PAY = window.open("","TG_PAY", "resizable=no, width=390, height=360");
            //TG_PAY.focus();        
            document.payform.target="TG_PAY";
        }
		//alert(document.payform.target)
        document.payform.action="https://npg.tgcorp.com/dlp/start.jsp";
		document.payform.submit();
		//alert(document.payform.action)
    }
    
    /**
        거래시간은 편의상 구매자 PC 시간을 사용합니다.
        실제로는 쇼핑몰 서버의 시간을 사용해야 합니다.
    */
    function setTxTime() {
        var time = new Date();
        var year = time.getYear() + "";
        var month = time.getMonth()+1;
        var date = time.getDate();
        var hour = time.getHours();
        var min = time.getMinutes();
        var sec = time.getSeconds();
        if(month<10) month = "0" + month;
        if(date<10) date = "0" + date;
        if(hour<10) hour = "0" + hour;
        if(min<10) min = "0" + min;
        if(sec<10) sec = "0" + sec;       
        return year + month + date + hour + min + sec;
    }

    /**    
        거래번호(MxIssueNO), 거래일시(MxIssueDate) 생성 예제
        예제에서는 편의상 거래시간을 거래번호로 사용합니다.
        실제로는 쇼핑몰의 고유 주문번호를 사용해야 합니다. 
    */    
    function initValue() {
        var tmp = setTxTime();
       // document.payform.MxIssueNO.value = "TEST_"+tmp;
        document.payform.MxIssueDate.value = tmp;
    }

    /**
        예제 테스트를 위해, 선택한 결제 수단 값(Smode_tmp)을 Smode에 설정
        실제로, Smode1 ~ Smode8은 hidden으로 설정
    */
    function setSmode() {
        document.payform.Smode.value = document.payform.Smode_tmp.value;
        document.payform.Smode1.value = document.payform.Smode_tmp1.value;
        document.payform.Smode2.value = document.payform.Smode_tmp2.value;
        document.payform.Smode3.value = document.payform.Smode_tmp3.value;
        document.payform.Smode4.value = document.payform.Smode_tmp4.value;
        document.payform.Smode5.value = document.payform.Smode_tmp5.value;
        document.payform.Smode6.value = document.payform.Smode_tmp6.value;
        document.payform.Smode7.value = document.payform.Smode_tmp7.value;
        document.payform.Smode8.value = document.payform.Smode_tmp8.value;
    }

</SCRIPT>

<FORM NAME="payform" METHOD="post">

<!-- 
    #################### 서비스별 Smode 설명 ####################
    3001 : 신용카드 - dbpath 비정상 응답 시, '결과확인요망'으로 상태 저장
    3005 : 신용카드 - dbpath 비정상 응답 등, 결과 응답 메시지 무시
    3007 : 신용카드 - dbpath 비정상 응답 시, 자동 취소
    2500 : 금결원 계좌이체 - dbpath 비정상 응답 시, '결과확인요망'으로 상태 저장
    2501 : 금결원 계좌이체 - dbpath 비정상 응답 시, 자동 취소
    2201 : 핑거 계좌이체 - 신규 서비스 종료
    2401 : 뱅크타운 계좌이체 - 신규 서비스 종료
    6101 : 휴대폰결제 - 결제 금액의 이동 통신사 통신료 합산 과금 서비스
    8801 : ARS전화결제 - 결제 금액의 한국통신(KT) 통신료 합산 과금 서비스
    2601 : 가상계좌 - 가상계좌 번호 부여 및 자동 입금 통보 서비스
    5101 : 도서상품권 - 도서상품권 및 북 캐쉬를 이용한 지불 서비스
    5301 : 복합결제 - 신용카드와 도서상품권의 복합 결제
    0001 : 현금영수증 - 무통장 입금에 대한 현금 영수증 무료 발행 서비스(구매자 입력 방식)
    0002 : 현금영수증 - 무통장 입금에 대한 현금 영수증 무료 발행 서비스(업체 전송 방식)
    0003 : 현금영수증 - 현금 영수증 발급 취소
    #############################################################
-->

<!-- 자세한 설명은 매뉴얼을 참고 바랍니다. -->
<!-- 해당되는 결제 수단의 parameter를 다음과 같이 설정합니다. -->

<!-- 공통 parameter 설정 시작 -->

    <input type="hidden" name="MxID" value="<?=$MxID?>"> <!-- 가맹점 ID -->
    <input type="hidden" name="MxIssueNO" value="<?=$MxIssueNO?>"> <!-- 거래 번호(가맹점 생성) -->
    <input type="hidden" name="MxIssueDate" value="<?=date(Ymdhis);?>"> <!-- 거래 일자(가맹점 생성, YYYYMMDDhhmmss) -->
    <input type="hidden" name="Amount" value="<?=$Amount?>"> <!-- 거래 금액 -->    
    <input type="hidden" name="Currency" value="KRW"> <!-- 화폐 구분 -->
    <input type="hidden" name="CcMode" value="11"> <!-- 거래 모드(신용카드-'00':데모,'11':실거래 | 기타거래-'10':실거래) -->
    
    <input type="hidden" name="Smode" value="<?=$Smode?>"> <!-- 결제 수단 구분(위의 설명) -->
    <input type="hidden" name="CcProdDesc" value="<?=$CcProdDesc?>"> <!-- 상품명 -->
    <input type="hidden" name="CcNameOnCard" value="<?=$CcNameOnCard?>"> <!-- 구매자 성명 -->
    <input type="hidden" name="MSTR" value=""> <!-- 가맹점 return 값, DBPATH로 전달-->
    <input type="hidden" name="MSTR2" value=""> <!-- 가맹점 return 값, REDIRPATH로 전달-->
    
    <input type="hidden" name="URL" value="npg.tgcorp.com"> <!-- 가맹점 서버 URL('http://' 제외) -->
    <input type="hidden" name="DBPATH" value="./dbpath.php"> <!-- 결과 저장 파일 경로 -->
    <input type="hidden" name="REDIRPATH" value="./redirpath.php"> <!-- 결과 화면 파일 경로 -->
    <input type="hidden" name="connectionType" value="http"> <!-- 가맹점 서버 프로토콜(http, https) -->
    
    <input type="hidden" name="bannerImage" value=""> <!-- 결제 창 로고 이미지(82 X 43) 경로 -->
    <input type="hidden" name="signType" value="1"> <!-- 암호화 결정(1:비암호화, 2:암호화-JSP만 해당) -->
    <input type="hidden" name="dbpathType" value=""> <!-- 소켓방식 사용여부('tls':사용) -->
    <input type="hidden" name="tgssl_ip" value=""> <!-- 소켓방식 사용시, 서버 IP -->
    <input type="hidden" name="tgssl_port" value=""> <!-- 소켓방식 사용시, 서버 Port -->
        
    <input type="hidden" name="Smode1" value=""> <!-- 결제 창에 타 결제 수단 이동 버튼 추가 -->
    <input type="hidden" name="Smode2" value="">
    <input type="hidden" name="Smode3" value="">
    <input type="hidden" name="Smode4" value="">
    <input type="hidden" name="Smode5" value="">
    <input type="hidden" name="Smode6" value="">
    <input type="hidden" name="Smode7" value="">
    <input type="hidden" name="Smode8" value="">

<!-- 공통 parameter 설정 끝 --> 
<!-- 신용카드 parameter 설정 시작 -->

    <input type="hidden" name="PID" value=""> <!-- 사용자 주민등록번호('-' 생략) 7012121234567-->
    <input type="hidden" name="PhoneNO" value=""> <!-- 사용자 전화번호 01012341234-->
    <input type="hidden" name="Country" value="KR"> <!-- 배송지 국가코드('KR') -->
    <input type="hidden" name="ZipCode" value=""> <!-- 배송지 우편번호 123-456-->
    <input type="hidden" name="Addr" value=""> <!-- 배송지 주소(한글 32자까지) 서울시 강남구 대치동-->
    <input type="hidden" name="AddrExt" value=""> <!-- 배송지 상세주소(한글 32자까지) 1-1번지-->
    <input type="hidden" name="Install" value=""> <!-- 할부개월(기본:전체개월, 예-'0:2:3':3개월까지) -->

    <input type="hidden" name="email" value=""> <!-- 결제 결과를 전달받을 사용자 email 주소 -->
    <input type="hidden" name="BillType" value="00"> <!-- 출력 영수증 구분('00':과세, '10':비과세) -->
    <input type="hidden" name="InstallType" value="00"> <!-- 가맹점 할부 수수료 부담('00':미부담, '01':부담) -->
    
<!-- 신용카드 parameter 설정 끝 --> 
<!-- 계좌이체(금결원) parameter 설정 시작 -->

    <input type="hidden" name="CcProdName" value="<?=$CcProdName?>"> <!-- 간략한 상품 정보(한글 5자까지) -->
    <input type="hidden" name="Name" value="<?=$Name?>"> <!-- 송금인 성명(한글 5자까지) --> 

    <!-- 아래는 신용카드와 중복 : 신용카드 사용하지 않는 경우에만 아래 사용 -->
    <!--<input type="hidden" name="email" value="">--> <!-- 결제 결과를 전달받을 사용자 email 주소 -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- 출력 영수증 구분('00':과세, '10':비과세) -->

<!-- 계좌이체(금결원) parameter 설정 끝 --> 
<!-- 뱅크타운, 핑거 계좌이체 설명은 생략합니다. --> 

<!-- 휴대폰결제 parameter 설정 시작 -->

    <input type="hidden" name="ItemType" value="Amount"> <!-- 핸드폰 결제 고정값 -->
    <input type="hidden" name="ItemCount" value="1"> <!-- 핸드폰 결제 고정값 -->
    <input type="hidden" name="ItemInfo" value="1|<?=$Amount?>|1|12S0Hz0000|<?=$MxID?>"> <!-- 종류|금액|1|상품코드|가맹점 -->

<!-- 휴대폰결제 parameter 설정 끝 -->
<!-- ARS전화결제 parameter 설정 시작 -->

    <input type=hidden name="TxType" value="03"> <!-- '03' 고정 -->
    <input type=hidden name="TxItemType" value="01"> <!-- '01':디지털, '02':실물 -->
    <input type=hidden name="TxItemCount" value="1"> <!-- 상품의 개수 -->
    <input type=hidden name="TxItemUnitAmount" value="<?=$Amount?>"> <!-- 상품의 단가-->
    <input type=hidden name="TxItemName" value="<?=$CcProdDesc?>"> <!-- 상품의 이름-->
    <input type=hidden name="TxItemInfo" value=""> <!-- 상품에 대한 정보, 설명-->

    <input type=hidden name="PUID" value="user_id"> <!-- 사용자 ID-->
    <input type=hidden name="PUIP" value="user_ip"> <!-- 사용자 IP-->
    <input type=hidden name="Method" value="Request"> <!-- 결제 방법('Request' 고정) -->
    <input type=hidden name="charge_id_sel" value="KT"> <!-- ISP 종류('KT' 고정) -->

<!-- ARS전화결제 parameter 설정 끝 -->
<!-- 가상계좌 parameter 설정 시작 -->

    <input type="hidden" name="CcUserMPhone" value=""> <!--01012341234 사용자 휴대폰 번호('-' 생략) -->
    <input type="hidden" name="Email" value=""> <!-- 구매자 입금안내 메일 주소 -->   

<!-- 가상계좌 parameter 설정 끝 -->
<!-- 도서상품권 parameter 설정 시작 -->

    <!-- 아래는 ARS전화결제와 중복 : ARS전화결제 사용하지 않는 경우에만 아래 사용 -->
    <!--<input type="hidden" name="PUID" value="">--> <!-- 사용자 ID-->
    <!--<input type="hidden" name="PUIP" value="">--> <!-- 사용자 IP-->

    <!-- 아래는 신용카드와 중복 : 신용카드 사용하지 않는 경우에만 아래 사용 -->
    <!--<input type="hidden" name="email" value="">--> <!-- 결제 결과를 전달받을 사용자 email 주소 -->

<!-- 도서상품권 parameter 설정 끝 -->
<!-- 현금영수증 (구매자 결제 창 입력 방식) parameter 설정 시작 -->

    <!-- 아래는 BillType 신용카드와 중복 : 신용카드 사용하지 않는 경우에만 아래 사용 -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- 영수증 구분('00':과세, '10':비과세) -->
    <!-- 아래는 부가세 별도 지정시에 사용 -->
    <!--<input type="hidden" name="VAT" value="0">--> <!-- 현금 영수증 부가세 금액 (미 지정 시 자동 계산) -->    

<!-- 현금영수증 parameter 설정 끝 -->    
<!-- 현금영수증 (업체 관리자 웹 전송 방식) parameter 설정 시작 -->

    <!-- 아래는 BillType 신용카드와 중복 : 신용카드 사용하지 않는 경우에만 아래 사용 -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- 영수증 구분('00':과세, '10':비과세) -->
    <input type="hidden" name="ReqType" value="0"> <!--  용도 구분 (0:소득공제 용, 1:비용처리 용)  -->
    <input type="hidden" name="PIDS" value=""> <!--  본인정보:주민번호/사업자번호/전화번호 등 ('-'생략) 13byte 01012341234-->
    <input type="hidden" name="UserName" value=""> <!--  발급 대상자 이름 30byte 홍길동-->
    <input type="hidden" name="UserEMail" value=""> <!--  발급 대상자 email 32byte gildong@tgcorp.com-->
    <input type="hidden" name="UserPhone" value=""> <!--  발급 대상자 연락처 ('-'생략) 15byte 01012341234-->
    <!-- 아래는 부가세 별도 지정시에 사용 -->
    <!--<input type="hidden" name="VAT" value="0">--> <!-- 현금 영수증 부가세 금액 (미 지정 시 자동 계산) -->
<input type="hidden" name="Smode_tmp" value="3001">
<input type="hidden" name="Smode_tmp1" value="3001">
<input type="hidden" name="Smode_tmp2" value="3001">
<input type="hidden" name="Smode_tmp3" value="3001">
<input type="hidden" name="Smode_tmp4" value="3001">
<input type="hidden" name="Smode_tmp5" value="3001">
<input type="hidden" name="Smode_tmp6" value="3001">
<input type="hidden" name="Smode_tmp7" value="3001">
<input type="hidden" name="Smode_tmp8" value="3001">
<!-- 3001 :신용카드 (3001)
3005 : 신용카드 (3005)
3007 : 신용카드 (3007)
2500 : 계좌이체(금결원) (2500)
2501 : 계좌이체(금결원) (2501)
2201 : 계좌이체(핑거) (2201)
2401 : 계좌이체(뱅크타운) (2401)
2601 : 가상계좌  (2601)
6101 : 휴대폰결제 (6101)
8801 : ARS전화결제 (8801)
5101 : 도서상품권 (5101)
5301 : 복합결제 (5301)
0001 : 현금영수증 (0001)                                    
0002 : 현금영수증 전송(0002)
0003 : 현금영수증 취소(0003)
 --> 
<!-- 현금영수증 parameter 설정 끝 -->   
</FORM>
<script language="javascript">
<!--
initValue()//기초값을 가져온다.
reqPayment();//폼을 send시킨다.
//-->
</script>
</BODY>
</HTML>
