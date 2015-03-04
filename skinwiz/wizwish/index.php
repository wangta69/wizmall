<?
include "../../lib/inc.depth2.php";

$WISH_CUT = 10;
if (!$cfg["member"]) {
	echo "<script>
	window.alert('로그인후 이용 가능합니다.');
	history.go(-1);
	</script>";
	exit;
}
$mid = $cfg["member"]["mid"];

if ($query == 'multi_wish') {

	while(list($key, $value) = each($mall_chk)){
		$WISH_ARRAY = file("../../config/wizmember_tmp/wiz_wish/".$mid);
		if (sizeof($WISH_ARRAY) > $WISH_CUT) {
			echo "<script>
			window.alert('\\n\\nWISH LIST 에는 최대 ${WISH_CUT}개까지만 저장이 가능합니다. \\n\\n고객님의 WISH LIST를 정리하신후 담아주세요.\\n\\n');
			</script>";
			echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
			exit;
		}
		
		$fp = fopen("../../config/wizmember_tmp/wiz_wish/".$mid, "w");
		$file = $key."|".time();
		fwrite($fp, "$file\n");
		for($i = 0; $i < sizeof($WISH_ARRAY); $i++){
			$file_uid = explode("|",$WISH_ARRAY[$i]);
			if($key != chop($file_uid[0])) {
				fwrite($fp, chop($WISH_ARRAY[$i])."\n");
				$a++;
			}
		}
		fclose($fp);	
	}
		$WISH_NUM = $a + 1;
		echo "<script>
		window.alert('\\n\\n선택하신 제품을 WISH LIST 에 담았습니다.    \\n\\n현재 고객님의 WISH LIST에는 ${WISH_NUM}개의 제품이 담겨있습니다.\\n\\n');
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
		exit;
} else if ($action != 'wish_remove') {//제품을 위시 리스트에 담기
	if (!file_exists("../../config/wizmember_tmp/wiz_wish/".$mid)) {
		$fp = fopen("../../config/wizmember_tmp/wiz_wish/".$mid, "w");
		$file = $uid."|".time();
		fwrite($fp, "$file\n");
		fclose($fp);
		echo "<script>
		window.alert('\\n\\n선택하신 제품을 WISH LIST 에 담았습니다.    \\n\\n현재 고객님의 WISH LIST에는 1개의 제품이 담겨있습니다.\\n\\n');
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
		exit;
	}
	else {
		$WISH_ARRAY = file("../../config/wizmember_tmp/wiz_wish/".$mid);
		if (sizeof($WISH_ARRAY) > $WISH_CUT) {
			echo "<script>
			window.alert('\\n\\nWISH LIST 에는 최대 ${WISH_CUT}개까지만 저장이 가능합니다. \\n\\n고객님의 WISH LIST를 정리하신후 담아주세요.\\n\\n');
			</script>";
			echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
			exit;
		}

		$fp = fopen("../../config/wizmember_tmp/wiz_wish/".$mid, "w");
		$file = $uid."|".time();
		fwrite($fp, "$file\n");
		for($i = 0; $i < sizeof($WISH_ARRAY); $i++){
			$file_uid = explode("|",$WISH_ARRAY[$i]);
			if($uid != chop($file_uid[0])) {
				fwrite($fp, chop($WISH_ARRAY[$i])."\n");
				$a++;
			}
		}
		fclose($fp);
		$WISH_NUM = $a + 1;

		echo "<script>
		window.alert('\\n\\n선택하신 제품을 WISH LIST 에 담았습니다.    \\n\\n현재 고객님의 WISH LIST에는 ${WISH_NUM}개의 제품이 담겨있습니다.\\n\\n');
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
		exit;
	}
}else { //action = 'wish_remove'
		$WISH_ARRAY = file("../../config/wizmember_tmp/wiz_wish/".$mid);
		$fp = fopen("../../config/wizmember_tmp/wiz_wish/".$mid, "w");
		for($i = 0; $i < sizeof($WISH_ARRAY); $i++){
			$file_uid = explode("|",$WISH_ARRAY[$i]);
			if ($uid != chop($file_uid[0])) {
				fwrite($fp, chop($WISH_ARRAY[$i])."\n");
			}
		}
		fclose($fp);

		echo "<script>
		window.alert('\\n\\n선택하신 제품을 WISH LIST 에서 삭제하였습니다   \\n\\n');
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=../../wizmember.php?query=wish'>";
		exit;
}
?>