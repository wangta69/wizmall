<?
	include "../../../lib/cfg.common.php";
	include "../../../config/db_info.php";
	include "../../../lib/class.database.php";
	$dbcon	= new database($cfg["sql"]);
	include "../../../lib/class.cart.php";
	$cart	= new cart();


    /* 
    DBPATH 페이지는 결제가 완료되면, 결과를 전송 받아서 주문 DB에 저장 합니다.
    결제 완료와 동시에 DBPATH로 결과를 전송하고, DBPATH로 부터 return 메시지가
    확인이 되면, 결제 진행 중이던 결제 창은 최종 결제 완료 페이지를 출력합니다.
    따라서, DBPATH가 비 정상적인 경우에는 결제 지연의 원인이 될 수 있습니다.
    */
    /* 
    아래와 같은 값이 POST 방식으로 전송됩니다. 자세한 설명은 매뉴얼을 참고바랍니다.

    $MxIssueNO  // 거래 번호 (결제 요청시 사용값)
    $MxIssueDate  // 거래 일시 (결제 요청시 사용값) 
    $Amount  // 거래 금액
    $MSTR  // 가맹점 return 값
    $ReplyCode  // 결과 코드
    $ReplyMessage  // 결과 메시지
    $Smode  // 결제 수단 구분 코드
    $CcCode  // 카드 코드 (신용카드인 경우)
    $Installment  // 할부 개월수 (신용카드인 경우)
    $BkCode  // 은행코드 (뱅크타운 계좌이체인 경우)
    $MxHASH  // 결과 검증값(데이터 조작 여부 확인)
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
    
    /* 
    결제 정보의 위/변조 여부를 확인하기 위해, 
    주요 결제 정보를 MD5 암호화 알고리즘으로 HASH 처리한 MxHASH 값을 받아
    동일한 규칙으로 DBPATH에서 생성한 값(output)과 비교합니다.
    */
    $mxid  = $cfg["pay"]["CARD_ID"];  // 가맹점 ID (고정 값)
    $mxotp = $cfg["pay"]["CARD_PASS"];  // 접근키 (고정 값)
    $currency = "KRW";  // 화폐코드 (고정 값)
    $mxissueno = $MxIssueNO;  // 거래 번호 (결과로 전송받은 값)
    $mxissuedate = $MxIssueDate;  // 거래 일시 (결과로 전송받은 값)
    $amount = "";  // 가맹점 주문 DB에 기록되어 있는 거래금액

    /*
    반드시 가맹점 주문 DB에서 거래금액(amount) 값을 가져와야 합니다.
    예) query = "select amount01 from 주문테이블 where 거래번호='"+MxIssueNO+"', and 거래일시='"+MxIssueDate;
        amount = amount01;         
    */
    /*
    MD5 알고리즘을 이용한 HASH 값 생성
    */
    $output = md5($mxid.$mxotp.$mxissueno.$mxissuedate.$amount.$currency);

    $isOK = 0;
	$returnMsg = "ACK=400FAIL";

    /*
    MxHASH 값과 output 생성 값을 비교해서 일치하는 경우에만 결과 저장
    */
    if($MxHASH!=null && $MxHASH==$output) {  // 일치하는 경우
        if($ReplyCode=="00003000" ||   // 결제 성공이면
			($Smode=="2601" && $ReplyCode=="00004000")) {  // ※ 가상계좌 발급성공 = "00004000"
			$cart->payresult_location($mxissueno, true);
			$returnMsg = "ACK=200OKOK";   // DB 저장 성공이면
           // else $returnMsg = "ACK=400FAIL";  // DB 저장 실패이면
        } else {  // 결제 실패인 경우
            /* 
            이 부분에서 주문 DB에 결과를 저장하는 소스 코딩 필요
            예) $isOK = (DB 업데이트 결과); 
            */          

            if($isOK==1) $returnMsg = "ACK=200OKOK";   // DB 저장 성공이면
            else $returnMsg = "ACK=400FAIL";  // DB 저장 실패이면
        }       
    } else {  // 결제 정보가 일치하지 않는 경우 : 데이타 조작의 가능성이 있으므로, 결제 취소
        $returnMsg = "ACK=400FAIL";
    }
?>

<? echo $returnMsg; ?> <? //return 메시지('ACK=200OKOK' or 'ACK=400FAIL')를 출력해야 정상 처리됩니다. ?>
