<?
//  ###################################################################################
// 
//    return.php
// 
//    Copyright (c) 2005  BANKWELL Co. LTD.
//    All rights reserved.
// 
//    PG�翡�� ���� ����� �޾� DB�� �����ϴ� ���
// 
//  ###################################################################################
// 
//  [ return.php�� ȣ���Ҷ� ���ڷ� �Ѿ���� ������� ]
// 
//   1. ShopCode     : �ش� ���θ� ��ȣ(PG�翡�� �ο����� �ڵ�)
//   2. ReplyCode    : �����ڵ�� '0000'�̸� ���� �׿ܴ� ����ó���Ѵ�.
//   3. ScrMessage   : ����޽���
//   4. OrderDate    : �ŷ���û����(YYYYMMDD)
//   5. OrderTime    : �ŷ���û�ð�(HHMMSS)
//   6. SequenceNo   : �ŷ���û��ȣ
//   7. OrderNo      : �ֹ���ȣ
//   8. Installment  : �Һΰ���
//   9. AcquireCode  : ���Ի��ڵ�
//  10. AcquireName  : ���Ի��̸�
//  11. ApprovalNo   : ���ι�ȣ
//  12. ApprovalTime : �����Ͻ�(YYYYMMDDHHMM000)
//  13. CardIssuer   : ī��߱޻��̸�
//  14. tran_date    : PG���� �ŷ�����(YYYYMMDD)
//  15. tran_seq     : PG���� �ŷ���ȣ
//  16. Reserved1    : FILLER
//  17. Reserved1    : FILLER
//  18. �׿� �Ʒ��� �ּ�ó�� ����ڰ� ������ ���ڸ� ������ �ִ�.
//  ###################################################################################

// test.html ���� ����ڰ� �ѱ䰪�ޱ�.
// �ֹ��ڸ� 	: $order_name
// ��ǰ�� 		: $order_bname
// �ݾ� 		: $order_amount
// �ֹ���Email 	: $order_email
// �ֹ�����ȭ 	: $order_tel
// �ֹ����ڵ��� : $order_hp
// �����θ� 	: $rev_name
// ������Email 	: $rev_email
// ��������ȭ 	: $rev_tel
// �������ڵ��� : $rev_hp
// ������ּ� 	: $zip1 . "-" . $zip2 . "  " . $addr
// �޼��� 		: $message
// ��������		: $MsgTypeCode

// return.php�������� 1���� �������δ� ���������� 
// http://������������/modules/return.php�� ȣ�� ������ ȭ�鿡 0000�̶߸� 1�������δ� ������.
// �̰��� �ּ��� ������ ������ ��� ����ŵ� �˴ϴ�.
	include "../../../lib/cfg.common.php";
	include "../../../config/db_info.php";
	include "../../../lib/class.database.php";
	$dbcon	= new database($cfg["sql"]);
	include "../../../lib/class.cart.php";
	$cart	= new cart();
	$cart->dbcon = $dbcon;
	
	if ($ReplyCode == "0000"){ //���� ������ ó�� �۾�
		$cart->payresult($OrderNo);
		// �̰��� ������ ���̽� �۾��� �Ͻø� �˴ϴ�.	
	}
	
	// ���� �۾��� ������ ���ε� ������ �ѱ�� �۾��� �Ͻ��ʿ䰡 �����ϴ�.(�޴�������)
	
	// �Ʒ� print������ �մ��� ������ !!!
	print $ReplyCode;
?>





<script language="javascript">
	function ok() 
	{
opener.location.replace('/');
			self.close();
	}
	</script>

<body leftmargin="10" topmargin="10">
<head><title>�������� !!!</title></head>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD  style='padding:30 0 0 25' >
			<table border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="ababab" >
			<tr>
				<td>
					<table border="0" cellpadding="5" cellspacing="1" width="100%">
					<tr bgcolor="#FFCC4A">
						<td align="center" colspan="2"><b>�����Ͻ� �����Դϴ�.</b></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">�ֹ��ڸ�</td>
						<td><?=$receipttoname?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">�� ǰ ��</td>
						<td><?=$goodname?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">�� ��</td>
						<td><?=$unitprice?>��</td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">�ֹ���ȣ</td>
						<td><?=$OrderNo?></td>
					</tr>


<?if($paymethod=="7"){?>

					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">������¹�ȣ</td>
						<td>��������:<?=$bankaccount?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">�Աݰ�������</td>
						<td><?=$bankexpyear?>��<?=$bankexpmonth?>��<?=$bankexpday?>��</td>
					</tr>
					<tr bgcolor="ffffff">
						<td colspan=2 align="center" bgcolor="efefef">�Ա��� Ȯ�εǽø� ��۵˴ϴ�
					</tr>

<?}else{?>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">ī����ι�ȣ</td>
						<td><?=$cardauthcode?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td colspan=2 align="center" bgcolor="efefef">������ �Ϸ�Ǿ����ϴ�
					</tr>

<?}?>
					</table>
				</td>
			</tr>
	<tr>
		<td height="30" align="center" bgcolor="ffffff">
			<span onClick="javascript:ok();" style="cursor:hand;">Ȯ��</span>
		</td>
	</tr>
	</table>
	</body>	