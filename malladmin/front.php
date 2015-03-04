<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***
 */

$Today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

## 구매정보
$WHEREIS = "WHERE BuyDate >= '" . $Today . "' AND OrderStatus < 50";
$COUNT_ARRAY = $dbcon -> _fetch_array($dbcon -> _query("SELECT count(*),SUM(TotalAmount) FROM wizBuyers " . $WHEREIS));
$TODAY_ORDER_NUM = $COUNT_ARRAY[0];
$TODAY_ORDER_MONEY = $COUNT_ARRAY[1];
$LIST_QUERY = "SELECT * FROM wizBuyers " . $WHEREIS . " ORDER BY UID DESC LIMIT 5";
$TABLE_DATA = $dbcon -> _query($LIST_QUERY);

## 회원등록정보
$MWHEREIS = "WHERE m.mregdate  >='" . $Today . "'";
$COUNT_ARRAY = $dbcon -> _fetch_array($dbcon -> _query("SELECT count(*) FROM wizMembers m " . $MWHEREIS));
$TODAY_MEMBER_NUM = $COUNT_ARRAY[0];
$MEMBER_QUERY = "SELECT m.mid, m.mname, i.gender, i.jumin1, i.jumin2, i.address1 FROM wizMembers m left join wizMembers_ind i on m.mid = i.id " . $MWHEREIS . " ORDER BY m.uid DESC LIMIT 5";
$MEMBER_DATA = $dbcon -> _query($MEMBER_QUERY);

## 상품 조회 및 구매순위
$BUY_COUNT_ARRAY = $dbcon -> _fetch_array($dbcon -> _query("SELECT SUM(OutPut),sum(Hit) FROM wizMall"));
$TOTAL_BUY_NUM = $BUY_COUNT_ARRAY[0];
$TOTAL_HIT_NUM = $BUY_COUNT_ARRAY[1];
if ($TOTAL_BUY_NUM && $TOTAL_HIT_NUM) {
    $HIT_BUY_PER = intval(($TOTAL_BUY_NUM / $TOTAL_HIT_NUM) * 100);
} else {
    $HIT_BUY_PER = 0;
}
$BUY_MONEY_ARRAY = $dbcon -> _fetch_array($dbcon -> _query("SELECT SUM(TotalAmount) FROM wizBuyers WHERE OrderStatus=50"));
$TOTAL_BUY_MONEY = $BUY_MONEY_ARRAY[0];

$ATOTAL_QUERY = $dbcon -> _query("SELECT count(*) FROM wizBuyers WHERE OrderStatus=50");
$ATOTAL_ARRAY = $dbcon -> _fetch_array($ATOTAL_QUERY);
$TOTAL_DATA_NUM = $ATOTAL_ARRAY[0];
?>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			관리자님 환영합니다.
		</div>
		<div class="panel-body">
			아래 총건수 및 매출내역은 거래완료를 기준으로 디스플레이 됩니다.
		</div>
	</div>

	<span class="b">총 거래건수</span> : <?php echo number_format($ATOTAL_ARRAY[0]); ?>
	건 |
	<span class="b">총매출액</span> : <?php echo number_format($BUY_MONEY_ARRAY[0]); ?>
	원 ( 금일 총거래건수: <?php echo number_format($TODAY_ORDER_NUM); ?>
	건  |
	금일매출 : <?php echo number_format($TODAY_ORDER_MONEY); ?>
	원)
	<br />
	<span class="b">접속건에 따른 판매성공률</span> :
	<?php echo $HIT_BUY_PER; ?>
	% ( 총 조회 :
	<?php echo number_format($TOTAL_HIT_NUM); ?>
	건|
	총 판매량 : <?php echo number_format($TOTAL_BUY_NUM); ?>
	EA)

	<div class="b orange" style="padding-top:20px">
		오늘( <? echo date("Y년 m월 d일")?> )의 주문리스트 TOP 5
	</div>

	<table class="table">
<?php
$i = 0;
while( $LLIST = $dbcon->_fetch_array( $TABLE_DATA ) ) :
    $UID = $LLIST["UID"];
    $RAddress1 = explode(" ", $LLIST["RAddress1"]);
    $PayMethod = $LLIST["PayMethod"];
    $TotalAmount = $LLIST["TotalAmount"];
    $Co_Uid = $LLIST["OrderID"];
    $i++;
?>
		<tr>
		<td><a href='#' onClick="javascript:window.open('./order/order1_1.php?uid=<?php echo $UID ?>', 'cartform','width=670,height=600,statusbar=no,scrollbars=yes,toolbar=no')">
		<?php echo $Co_Uid; ?>
		</a></td>
		<td><?php echo number_format($TotalAmount); ?>원
		</td>
		<td><?php echo ($PayMethod)?$PaySortArr[$PayMethod]:"온라인결제";?>
		</td>
		<td><?php echo $RAddress1[0]; ?></td>
		<td>
			<?php echo date("H시i분", $LLIST["BuyDate"]) ?>
		</td>
		</tr>
		<?php endwhile; ?>
		<?php if (!$UID) :?>
		<tr>
			<td  colspan=5 >-금일 주문내역이 없습니다. -</td>
		</tr>
		<?php endif; ?>
	</table>
	<table class="table">
		<tr>
			<td>금일 총주문 :
			<?php echo number_format($TODAY_ORDER_NUM); ?>
			건 | 주문총액 :
			<?php echo number_format($TODAY_ORDER_MONEY); ?>
			원 </td>
			<td><span class="button bull"><a href="./main.php?menushow=<?php echo $menushow ?>&theme=order/order1">more</a></span></td>
		</tr>
	</table>

	<div class="b orange">
		오늘( <?php echo date("Y년 m월 d일"); ?> )의 가입회원리스트 TOP 5
	</div>
	<table class="table">
<?php
$i = 0;
while( $list = $dbcon->_fetch_array( $MEMBER_DATA ) ) :
    $ZONE	= explode(" ", $list["address1"]);
    $name	= $list["mname"];
    $id		= $list["mid"];
    $gender	= $list["gender"];
    $jumin1	= $list["jumin1"];
    $jumin2	= $list["jumin2"];

if($gender){
    if($list["gender"] == "1"){
        $gender = "남";
    }else if($list["gender"] == "2"){
        $gender = "여";
    }
}else if($jumin2){
    switch(substr($jumin2, 0, 1)){
        case "1":
        case "3":
            $gender = "남";
        break;
        case "2":
        case "4":
            $gender = "여";
        break;
    }
}

		?>
		<tr>
		<td>
		    <a href="javascript:window.open('./member/member1_1.php?id=<?php echo $id ?>', 'regisform','width=650,height=750,statusbar=no,scrollbars=yes,toolbar=no')"><? echo $name . " (" . $id . ")"; ?></a>
		</td>
		<td><?php echo $gender; ?><
		/td>
		<td><?php echo $ZONE[0]; ?>
		</td>
		</tr>
		<?php
        $i++;
        endwhile;
        if (!$i):
		?>
		<tr>
			<td colspan="3">- 금일 회원가입자가 없습니다. - </td>
		</tr>
		<?php
        endif;
		?>
	</table>
	<table class="table">
		<tr>
			<td>금일 총가입자 :
			<?php echo number_format($TODAY_MEMBER_NUM) ?>
			명</td>
			<td><span class="button bull"><a href="./main.php?menushow=<?php echo $menushow ?>&theme=member/member1">more</a></span></td>
		</tr>
	</table>
</div>