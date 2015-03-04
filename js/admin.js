function floatingLayerBack() {
	var bodyWidth = $("body").outerWidth();
	var bodyHeight = $("body").outerHeight();
	
	$("body").append('<div id="layerBack" style="display:none"></div>');
	
	$("#layerBack").css({
		opacity: (30 / 100),
		filter: 'alpha(opacity=' + 30 + ')', 
		position: 'absolute',
		zIndex: 1000,
		top: '0px',
		left: '0px',
		width: '100%',
		height: $(document).height(),
		background: "#000"
	}).show();
}
/*
function gotoPage(cp){
	$("#cp").val(cp);
	$("#listForm").submit();
}

*/
$(function(){
/* function start */		   
	$(document).on("click", "#layerBack", function(){
		$("#layerBack").hide();
		$("#dynamicPop").hide();
	}); 
	

	$(".altern th:odd").addClass("bg3"); //basic이라는 클래스네임을 가진 요소의 tr 요소 중 홀수번째에 bg1클래스 부여
	$(".altern th:even").addClass("bg4");
	$(".list tr:odd").addClass("bg1");
	$(".list tr:even").addClass("bg2");


	$("#aboutpopup").click(function(){
		var position = $(this).position();
		var left = position.left-315;
		var top = position.top+54;	
		//floatingLayerBack();
		$("#dynamicPop").css({"position":"absolute", "left" : left+"px", "top" : top+"px", "z-index":"2000"}).toggle().draggable().load('./about/about.php');
		//
		});
			
	$(document).on("click", ".aboutpopupclose", function(){
		$("#layerBack").hide();
		$("#dynamicPop").hide();
		//
		});
	
	//$("#setuccmpath").click(function(){
	// $(".wp_sendmail").live("click", function(){
// function End //			   
});


function wizwindow(url,name,flag){
	var newwin = window.open(url,name,flag);
	if(newwin){
		newwin.focus();
	}else{
		alert('팝업창이 차단되어 있습니다.\n\n해제해 주세요');	
	}
}

// 회원정보창 오픈
function getuserInfo(id){
	wizwindow('./member/member1_1.php?id='+id, 'regisform','width=650,height=650,statusbar=no,scrollbars=yes,toolbar=no');
}


// 회원포인트 정보창 오픈
function getpointInfo(id, ispop){
	if (ispop){
		wizwindow('../member/member1_2.php?id='+id, 'pointinfo','width=650,height=650,statusbar=no,scrollbars=yes,toolbar=no');
	}else{
		wizwindow('./member/member1_2.php?id='+id, 'pointinfo','width=650,height=650,statusbar=no,scrollbars=yes,toolbar=no');
	}
}

function openorderwindow(uid){	
	wizwindow('./order/order1_1.php?uid='+uid, 'cartform','width=620,height=700,statusbar=no,scrollbars=yes,toolbar=no')
}

// 회원검색창(현재는 쿠폰발급하기에서 처리)
function memberSearch(){
	url = "./member/member_search.php";
	wizwindow(url,'SearchMember','width=600, height=600');
}

// 회원에게 쪽지 보내기
function memberSearch(id){
	url = "./member/messanger.php?id="+id;
	wizwindow(url,'MessangerWindow','width=500,height=500,statusbar=no,scrollbars=yes,toolbar=no');
}

//상단 네비게이션 색상변경
function chColor(v, color){
	v.style.background = color;
	
}