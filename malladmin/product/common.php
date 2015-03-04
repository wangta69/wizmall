<?php
if ($common -> checsrfkey($csrf)) {
	if($action == 'qde') {   //삭제옵션시 실행
		foreach($multi as $key=>$value) $mall->deleteProduct($key);
	}else if($action == 'qup') {//가격변경
		foreach($multi as $key=>$value) $dbcon->_query("UPDATE wizMall SET Price='".$price[$key]."', Point='".$point[$key]."' WHERE UID=".$key);
	}else if($action == 'chinput') {//제고 입력
		$Iinputdate = time();
		foreach($multi as $key=>$value) {
			# 공급처의 아이디를 가져온다.
			$sqlstr = "select GetComp from wizMall where UID = ".$key;
			$Icomid = $dbcon->get_one($sqlstr);
			# 입하량을 wizInputer 테이블에 입력한다.
			$sqlstr = "insert into wizInputer(Icomid,Igoodscode,Iinputqty,Iinputdate)
			values('".$Icomid."','".$key."','".$qty[$key]."','".$Iinputdate."')";
			$dbcon->_query($sqlstr);
		}// while 문 닫음	
	}else if ($action == 'orderupdate') {    
		//print_r($display_order);
		while (list($key,$value) = each($display_order)) {
			$query = "update wizMall set OrderID = ".$key." where UID = ".$value;
			$dbcon->_query($query);
	    }  
	}else if($action == "searchpdin"){//상품찾기(팝업)
		$leng = count($SelectedLink);
		echo "<script>\n";
		echo "opener.document.writeForm.tmpSimilarPd.options.length = ".$leng.";\n";
		$i=0;
		while(list($key, $value) = each($SelectedLink)):
			echo "opener.document.writeForm.tmpSimilarPd.options[".$i."].text = '".$value."'; \n";
			echo "opener.document.writeForm.tmpSimilarPd.options[".$i."].value = '".$key."'; \n";
			$i++;
		endwhile;
		echo "self.close();\n";
		echo "</script>\n";
	}
}



//전체제품수 구하기
$sqlstr = "SELECT count(*) FROM wizMall m ".$whereis;
$REALTOTAL = $dbcon->get_one($sqlstr);
//echo $REALTOTAL;
// 옵션별 상품 검색
if(is_numeric($OptionList)){
	//$pos = $OptionList*2 + 1;
	//$whereis .=" and SUBSTRING(m.Regoption,".$pos.",1)= '1'";
	$whereis .=" and m.Regoption like '%|".$OptionList."|%'";
}

//카테고리별 상품 검색.
if ($category) {
	$catlen = strlen($category);
	switch(true){
		case ($catlen > 6):$whereis .= " and m.Category = '".$category."'";break;//소분류
		case ($catlen > 3):$whereis .= " and Right(m.Category, 6) = '".$category."'";break;//중분류
		default:$whereis .= " and Right(m.Category, 3) = '".$category."'";break;//대분류
	}
}

//키워드별 상품검색
if ($keyword) {
	$keyword = trim($keyword);
	$whereis .=" and  m.Name LIKE '%".$keyword."%' OR m.Description1 LIKE '%".$keyword."%' OR m.Model LIKE '%".$keyword."%'";
}

//상품정렬
if (!$orderby) {$orderby = "m.UID@DESC";}

//검색된 제품수 구하기
$sqlstr = "SELECT count(*) FROM wizMall m ".$whereis;
$TOTAL = $dbcon->get_one($sqlstr);
?>
<script>
$(function(){
	$(".btn_product_sel").click(function(){
		var flag = $(this).attr("flag");
		var msg;
		switch(flag){
			case "del":msg="삭제하는 제품은 DB에서 삭제되어 복구가 불가능합니다.\n정말로 삭제하시겠습니까?\n";break;
			case "chprice":msg="변경하신 모든 제품의 가격과 포인트가 변경됩니다. \n 정말로 변경하시겠습니까? \n";break;
			case "chinput":msg="변경하신 모든 제품의 입하량이 추가됩니다. \n 정말로 추가하시겠습니까? \n";break;
			case "chinput":msg="변경하신 모든 제품의 입하량이 추가됩니다.\n 정말로 추가하시겠습니까?\n";break;
		}
		
		if($(".chk_list:checked").length == 0){
            jAlert('하나 이상 선택해 주세요', '경고메시지');
        }else{
            jConfirm(msg, '', function(r) {
                if(r==true) {
					/*
					$("#mall_list").attr("action", "product/process.php");
					$("#mall_list").submit();
					*/
                   $.post("product/process.php",$("#mall_list").serialize(), function(data){
						//alert(data);
						//eval("var obj="+data);
						location.reload();
                    });//,"json"
					
                }
            });
        }
		
				
	});
});

function cmp(flag){
	var msg;
	switch(flag){
		//case "del":msg="삭제하는 제품은 DB에서 삭제되어 복구가 불가능합니다.\n정말로 삭제하시겠습니까?\n";break;
		case "chprice":msg="변경하신 모든 제품의 가격과 포인트가 변경됩니다. \n 정말로 변경하시겠습니까? \n";break;
		case "chinput":msg="변경하신 모든 제품의 입하량이 추가됩니다. \n 정말로 추가하시겠습니까? \n";break;
		case "chinput":msg="변경하신 모든 제품의 입하량이 추가됩니다.\n 정말로 추가하시겠습니까?\n";break;
	}
	var f = document.forms.mall_list;
	var i = 0;
	var chked = 0;
	for(i = 0; i < f.length; i++ ) {
		if(f[i].type == 'checkbox') {
			if(f[i].checked) {
				chked++;
			}
		}
	}
	if( chked < 1 ) {
		alert('한개이상 제품을 체크해주시기 바랍니다.');
		return false;
	}

	if (confirm(msg)) return true;
	return false;
}

function SortbyCat(cat){
	var f = document.SortForm;
	f.category.value = cat.value;
	f.submit();
}

function gotoWrite(uid){
	var f = document.SortForm
	f.theme.value = 'product/product1';
	f.uid.value = uid;
	//f.cp.value = <?=$cp?>;
	f.submit();
}


function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}


</script>