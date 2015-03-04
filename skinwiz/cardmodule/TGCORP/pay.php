<?php
header("Content-Type: text/html; charset=euc-kr"); 
//�̺κ��� �������� ���� euc-kr�� �ڵ� �Ǿ�� ��
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
	$show_goods_name .= "�� ".$showcount."��";
}

$sqlstr = "select b.* from wizBuyers b
left join wizMembers m on b.MemberID = m.mid 
left join wizMembers_ind i on b.MemberID = i.id
where b.OrderID = '".$_COOKIE["CART_CODE"]."'";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

$MxID = $cfg["pay"]["CARD_ID"];
$MxIssueNO=$cod; /* �ֹ���ȣ */
$Name = $CcNameOnCard=iconv("UTF-8", "EUC-KR", $list["SName"]); /* �ֹ��ڸ� */
$CcProdName = $CcProdDesc=$show_goods_name; /* ��ǰ�� */
$Amount=$list["AmountPg"] ; /* �����ݾ� */
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
        ���� ��û �Լ� (����â ȣ��)
    */
    function reqPayment() {
       // setSmode(); // ���� �׽�Ʈ�� ���� �Լ� (Smode_tmp->Smode)
		//alert(document.payform.Smode.value)
        if(document.payform.Smode.value!="0002" && document.payform.Smode.value!="0003") 
        { // ���ݿ����� ���� ������ �˾��� �̿����� ����
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
        �ŷ��ð��� ���ǻ� ������ PC �ð��� ����մϴ�.
        �����δ� ���θ� ������ �ð��� ����ؾ� �մϴ�.
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
        �ŷ���ȣ(MxIssueNO), �ŷ��Ͻ�(MxIssueDate) ���� ����
        ���������� ���ǻ� �ŷ��ð��� �ŷ���ȣ�� ����մϴ�.
        �����δ� ���θ��� ���� �ֹ���ȣ�� ����ؾ� �մϴ�. 
    */    
    function initValue() {
        var tmp = setTxTime();
       // document.payform.MxIssueNO.value = "TEST_"+tmp;
        document.payform.MxIssueDate.value = tmp;
    }

    /**
        ���� �׽�Ʈ�� ����, ������ ���� ���� ��(Smode_tmp)�� Smode�� ����
        ������, Smode1 ~ Smode8�� hidden���� ����
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
    #################### ���񽺺� Smode ���� ####################
    3001 : �ſ�ī�� - dbpath ������ ���� ��, '���Ȯ�ο��'���� ���� ����
    3005 : �ſ�ī�� - dbpath ������ ���� ��, ��� ���� �޽��� ����
    3007 : �ſ�ī�� - dbpath ������ ���� ��, �ڵ� ���
    2500 : �ݰ�� ������ü - dbpath ������ ���� ��, '���Ȯ�ο��'���� ���� ����
    2501 : �ݰ�� ������ü - dbpath ������ ���� ��, �ڵ� ���
    2201 : �ΰ� ������ü - �ű� ���� ����
    2401 : ��ũŸ�� ������ü - �ű� ���� ����
    6101 : �޴������� - ���� �ݾ��� �̵� ��Ż� ��ŷ� �ջ� ���� ����
    8801 : ARS��ȭ���� - ���� �ݾ��� �ѱ����(KT) ��ŷ� �ջ� ���� ����
    2601 : ������� - ������� ��ȣ �ο� �� �ڵ� �Ա� �뺸 ����
    5101 : ������ǰ�� - ������ǰ�� �� �� ĳ���� �̿��� ���� ����
    5301 : ���հ��� - �ſ�ī��� ������ǰ���� ���� ����
    0001 : ���ݿ����� - ������ �Աݿ� ���� ���� ������ ���� ���� ����(������ �Է� ���)
    0002 : ���ݿ����� - ������ �Աݿ� ���� ���� ������ ���� ���� ����(��ü ���� ���)
    0003 : ���ݿ����� - ���� ������ �߱� ���
    #############################################################
-->

<!-- �ڼ��� ������ �Ŵ����� ���� �ٶ��ϴ�. -->
<!-- �ش�Ǵ� ���� ������ parameter�� ������ ���� �����մϴ�. -->

<!-- ���� parameter ���� ���� -->

    <input type="hidden" name="MxID" value="<?=$MxID?>"> <!-- ������ ID -->
    <input type="hidden" name="MxIssueNO" value="<?=$MxIssueNO?>"> <!-- �ŷ� ��ȣ(������ ����) -->
    <input type="hidden" name="MxIssueDate" value="<?=date(Ymdhis);?>"> <!-- �ŷ� ����(������ ����, YYYYMMDDhhmmss) -->
    <input type="hidden" name="Amount" value="<?=$Amount?>"> <!-- �ŷ� �ݾ� -->    
    <input type="hidden" name="Currency" value="KRW"> <!-- ȭ�� ���� -->
    <input type="hidden" name="CcMode" value="11"> <!-- �ŷ� ���(�ſ�ī��-'00':����,'11':�ǰŷ� | ��Ÿ�ŷ�-'10':�ǰŷ�) -->
    
    <input type="hidden" name="Smode" value="<?=$Smode?>"> <!-- ���� ���� ����(���� ����) -->
    <input type="hidden" name="CcProdDesc" value="<?=$CcProdDesc?>"> <!-- ��ǰ�� -->
    <input type="hidden" name="CcNameOnCard" value="<?=$CcNameOnCard?>"> <!-- ������ ���� -->
    <input type="hidden" name="MSTR" value=""> <!-- ������ return ��, DBPATH�� ����-->
    <input type="hidden" name="MSTR2" value=""> <!-- ������ return ��, REDIRPATH�� ����-->
    
    <input type="hidden" name="URL" value="npg.tgcorp.com"> <!-- ������ ���� URL('http://' ����) -->
    <input type="hidden" name="DBPATH" value="./dbpath.php"> <!-- ��� ���� ���� ��� -->
    <input type="hidden" name="REDIRPATH" value="./redirpath.php"> <!-- ��� ȭ�� ���� ��� -->
    <input type="hidden" name="connectionType" value="http"> <!-- ������ ���� ��������(http, https) -->
    
    <input type="hidden" name="bannerImage" value=""> <!-- ���� â �ΰ� �̹���(82 X 43) ��� -->
    <input type="hidden" name="signType" value="1"> <!-- ��ȣȭ ����(1:���ȣȭ, 2:��ȣȭ-JSP�� �ش�) -->
    <input type="hidden" name="dbpathType" value=""> <!-- ���Ϲ�� ��뿩��('tls':���) -->
    <input type="hidden" name="tgssl_ip" value=""> <!-- ���Ϲ�� ����, ���� IP -->
    <input type="hidden" name="tgssl_port" value=""> <!-- ���Ϲ�� ����, ���� Port -->
        
    <input type="hidden" name="Smode1" value=""> <!-- ���� â�� Ÿ ���� ���� �̵� ��ư �߰� -->
    <input type="hidden" name="Smode2" value="">
    <input type="hidden" name="Smode3" value="">
    <input type="hidden" name="Smode4" value="">
    <input type="hidden" name="Smode5" value="">
    <input type="hidden" name="Smode6" value="">
    <input type="hidden" name="Smode7" value="">
    <input type="hidden" name="Smode8" value="">

<!-- ���� parameter ���� �� --> 
<!-- �ſ�ī�� parameter ���� ���� -->

    <input type="hidden" name="PID" value=""> <!-- ����� �ֹε�Ϲ�ȣ('-' ����) 7012121234567-->
    <input type="hidden" name="PhoneNO" value=""> <!-- ����� ��ȭ��ȣ 01012341234-->
    <input type="hidden" name="Country" value="KR"> <!-- ����� �����ڵ�('KR') -->
    <input type="hidden" name="ZipCode" value=""> <!-- ����� �����ȣ 123-456-->
    <input type="hidden" name="Addr" value=""> <!-- ����� �ּ�(�ѱ� 32�ڱ���) ����� ������ ��ġ��-->
    <input type="hidden" name="AddrExt" value=""> <!-- ����� ���ּ�(�ѱ� 32�ڱ���) 1-1����-->
    <input type="hidden" name="Install" value=""> <!-- �Һΰ���(�⺻:��ü����, ��-'0:2:3':3��������) -->

    <input type="hidden" name="email" value=""> <!-- ���� ����� ���޹��� ����� email �ּ� -->
    <input type="hidden" name="BillType" value="00"> <!-- ��� ������ ����('00':����, '10':�����) -->
    <input type="hidden" name="InstallType" value="00"> <!-- ������ �Һ� ������ �δ�('00':�̺δ�, '01':�δ�) -->
    
<!-- �ſ�ī�� parameter ���� �� --> 
<!-- ������ü(�ݰ��) parameter ���� ���� -->

    <input type="hidden" name="CcProdName" value="<?=$CcProdName?>"> <!-- ������ ��ǰ ����(�ѱ� 5�ڱ���) -->
    <input type="hidden" name="Name" value="<?=$Name?>"> <!-- �۱��� ����(�ѱ� 5�ڱ���) --> 

    <!-- �Ʒ��� �ſ�ī��� �ߺ� : �ſ�ī�� ������� �ʴ� ��쿡�� �Ʒ� ��� -->
    <!--<input type="hidden" name="email" value="">--> <!-- ���� ����� ���޹��� ����� email �ּ� -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- ��� ������ ����('00':����, '10':�����) -->

<!-- ������ü(�ݰ��) parameter ���� �� --> 
<!-- ��ũŸ��, �ΰ� ������ü ������ �����մϴ�. --> 

<!-- �޴������� parameter ���� ���� -->

    <input type="hidden" name="ItemType" value="Amount"> <!-- �ڵ��� ���� ������ -->
    <input type="hidden" name="ItemCount" value="1"> <!-- �ڵ��� ���� ������ -->
    <input type="hidden" name="ItemInfo" value="1|<?=$Amount?>|1|12S0Hz0000|<?=$MxID?>"> <!-- ����|�ݾ�|1|��ǰ�ڵ�|������ -->

<!-- �޴������� parameter ���� �� -->
<!-- ARS��ȭ���� parameter ���� ���� -->

    <input type=hidden name="TxType" value="03"> <!-- '03' ���� -->
    <input type=hidden name="TxItemType" value="01"> <!-- '01':������, '02':�ǹ� -->
    <input type=hidden name="TxItemCount" value="1"> <!-- ��ǰ�� ���� -->
    <input type=hidden name="TxItemUnitAmount" value="<?=$Amount?>"> <!-- ��ǰ�� �ܰ�-->
    <input type=hidden name="TxItemName" value="<?=$CcProdDesc?>"> <!-- ��ǰ�� �̸�-->
    <input type=hidden name="TxItemInfo" value=""> <!-- ��ǰ�� ���� ����, ����-->

    <input type=hidden name="PUID" value="user_id"> <!-- ����� ID-->
    <input type=hidden name="PUIP" value="user_ip"> <!-- ����� IP-->
    <input type=hidden name="Method" value="Request"> <!-- ���� ���('Request' ����) -->
    <input type=hidden name="charge_id_sel" value="KT"> <!-- ISP ����('KT' ����) -->

<!-- ARS��ȭ���� parameter ���� �� -->
<!-- ������� parameter ���� ���� -->

    <input type="hidden" name="CcUserMPhone" value=""> <!--01012341234 ����� �޴��� ��ȣ('-' ����) -->
    <input type="hidden" name="Email" value=""> <!-- ������ �Աݾȳ� ���� �ּ� -->   

<!-- ������� parameter ���� �� -->
<!-- ������ǰ�� parameter ���� ���� -->

    <!-- �Ʒ��� ARS��ȭ������ �ߺ� : ARS��ȭ���� ������� �ʴ� ��쿡�� �Ʒ� ��� -->
    <!--<input type="hidden" name="PUID" value="">--> <!-- ����� ID-->
    <!--<input type="hidden" name="PUIP" value="">--> <!-- ����� IP-->

    <!-- �Ʒ��� �ſ�ī��� �ߺ� : �ſ�ī�� ������� �ʴ� ��쿡�� �Ʒ� ��� -->
    <!--<input type="hidden" name="email" value="">--> <!-- ���� ����� ���޹��� ����� email �ּ� -->

<!-- ������ǰ�� parameter ���� �� -->
<!-- ���ݿ����� (������ ���� â �Է� ���) parameter ���� ���� -->

    <!-- �Ʒ��� BillType �ſ�ī��� �ߺ� : �ſ�ī�� ������� �ʴ� ��쿡�� �Ʒ� ��� -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- ������ ����('00':����, '10':�����) -->
    <!-- �Ʒ��� �ΰ��� ���� �����ÿ� ��� -->
    <!--<input type="hidden" name="VAT" value="0">--> <!-- ���� ������ �ΰ��� �ݾ� (�� ���� �� �ڵ� ���) -->    

<!-- ���ݿ����� parameter ���� �� -->    
<!-- ���ݿ����� (��ü ������ �� ���� ���) parameter ���� ���� -->

    <!-- �Ʒ��� BillType �ſ�ī��� �ߺ� : �ſ�ī�� ������� �ʴ� ��쿡�� �Ʒ� ��� -->
    <!--<input type="hidden" name="BillType" value="00">--> <!-- ������ ����('00':����, '10':�����) -->
    <input type="hidden" name="ReqType" value="0"> <!--  �뵵 ���� (0:�ҵ���� ��, 1:���ó�� ��)  -->
    <input type="hidden" name="PIDS" value=""> <!--  ��������:�ֹι�ȣ/����ڹ�ȣ/��ȭ��ȣ �� ('-'����) 13byte 01012341234-->
    <input type="hidden" name="UserName" value=""> <!--  �߱� ����� �̸� 30byte ȫ�浿-->
    <input type="hidden" name="UserEMail" value=""> <!--  �߱� ����� email 32byte gildong@tgcorp.com-->
    <input type="hidden" name="UserPhone" value=""> <!--  �߱� ����� ����ó ('-'����) 15byte 01012341234-->
    <!-- �Ʒ��� �ΰ��� ���� �����ÿ� ��� -->
    <!--<input type="hidden" name="VAT" value="0">--> <!-- ���� ������ �ΰ��� �ݾ� (�� ���� �� �ڵ� ���) -->
<input type="hidden" name="Smode_tmp" value="3001">
<input type="hidden" name="Smode_tmp1" value="3001">
<input type="hidden" name="Smode_tmp2" value="3001">
<input type="hidden" name="Smode_tmp3" value="3001">
<input type="hidden" name="Smode_tmp4" value="3001">
<input type="hidden" name="Smode_tmp5" value="3001">
<input type="hidden" name="Smode_tmp6" value="3001">
<input type="hidden" name="Smode_tmp7" value="3001">
<input type="hidden" name="Smode_tmp8" value="3001">
<!-- 3001 :�ſ�ī�� (3001)
3005 : �ſ�ī�� (3005)
3007 : �ſ�ī�� (3007)
2500 : ������ü(�ݰ��) (2500)
2501 : ������ü(�ݰ��) (2501)
2201 : ������ü(�ΰ�) (2201)
2401 : ������ü(��ũŸ��) (2401)
2601 : �������  (2601)
6101 : �޴������� (6101)
8801 : ARS��ȭ���� (8801)
5101 : ������ǰ�� (5101)
5301 : ���հ��� (5301)
0001 : ���ݿ����� (0001)                                    
0002 : ���ݿ����� ����(0002)
0003 : ���ݿ����� ���(0003)
 --> 
<!-- ���ݿ����� parameter ���� �� -->   
</FORM>
<script language="javascript">
<!--
initValue()//���ʰ��� �����´�.
reqPayment();//���� send��Ų��.
//-->
</script>
</BODY>
</HTML>
