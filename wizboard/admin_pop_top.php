<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>관리자님을 환영합니다.[위즈보드 관리자모드]</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"];?>">
<link rel="stylesheet" href="../css/base.css" type="text/css">
<link rel="stylesheet" href="../css/admin.board.css" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
</head>
<body>
<script>
$(function(){
	$(".altern th:odd").addClass("bg3"); //basic이라는 클래스네임을 가진 요소의 tr 요소 중 홀수번째에 bg1클래스 부여
	$(".altern th:even").addClass("bg4");
	$(".list tr:odd").addClass("bg1");
	$(".list tr:even").addClass("bg2");
	
	//카테고리 이동
	$(".btn_cat_move").click(function(){
		var uid = $(this).parents("tr").attr("attr-cat-uid");
		var tcat = $(".tcat").eq($(".btn_cat_move").index(this)).val();
		$.post("../lib/ajax.admin.board.php", {BID:$("#BID").val(), GID:$("#GID").val(),uid:uid,tcat:tcat,query:"cat_move"}, function(data){
			alert('이동되었습니다.');
		});
	});
});


function mini_help_window_open( page, name, top, left, width, height )
{
        window.open( page, name,
        'toolbar=no, location=no, directories=no, status=no, ' +
        'menubar=no, scrollbars=yes, resizable=yes, width=' +
        width + ', height=' + height +
        ', top=' + top + ', left=' + left );
}

function CategoryManager(flag, uid){
	var f = document.catForm;
	var BID				= $("#BID").val();
	var GID				= $("#GID").val();
	var input_catname	= $("#input_catname").val();
	if(flag == "insert"){
		$.post("../lib/ajax.admin.board.php", {BID:BID, GID:GID,catname:input_catname, query:"cat_in"}, function(data){
			location.reload();
		});
	}else if(flag == "update"){
		f.query.value = flag;
		f.submit();
	}else if(flag == "delete"){//cat_del
		$.post("../lib/ajax.admin.board.php", {BID:BID, GID:GID,uid:uid, query:"cat_del"}, function(data){
			location.reload();
		});	
	}

}

function emp_manager(flag, uid){
	var f = document.empForm;
	if(flag == "update"){
		f.uid.value = uid;
		f.submit();
	}else if(flag == "delete"){
		location.href="<?php echo $PHP_SELF;?>?BID=<?php echo $BID;?>&GID=<?php echo $GID;?>&uid="+uid+"&query=emp_delete";
	}

}

function showhidden(v){
	if (v.style.display == "none"){
		v.style.display = "block";
	}else{
		v.style.display = "none";
	}
}


function setBoardcfg(v){
	var type = v.type;
	var key = v.name;
	var value = "";
	var BID				= $("#BID").val();
	var GID				= $("#GID").val();	
	switch(type){
		case "checkbox":
			if(v.checked == true) value = v.value;
			else value = "";
		break;
		case "radio":
			value = v.value;
		break;		
	
	}

	$.post("../lib/ajax.admin.board.php", {smode:"eachconfig",BID:BID,GID:GID,key:key,value:value}, function (data){
		//alert(data);
	});
}
</script>
<form action="<?php echo $PHP_SELF;?>" method="post">
	<input type="hidden" name="GID" value="<?php echo $GID;?>">
	테이블명 :
	<select name="BID" onChange="submit();">
<?php
$substr = "select BID from wizTable_Main where GID='".$GID."' order by BID asc";
$dbcon->_query($substr);
while($slist = $dbcon->_fetch_array()):
	$selected = $slist["BID"] == $BID?" selected":"";
	echo "<option value='".$slist["BID"]."'".$selected.">".$slist["BID"]."</option>\n";
endwhile;
?>
	</select>
</form>
