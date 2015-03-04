//_timestamp = Math.round(+new Date()/1000);

$(function(){
	$("#btn_comment_write").click(function(){
		if(!$("#commnet_user_id").val()){
			alert("로그인해주시기 바랍니다.");
		}else if(!$("#comment_user_contents").val()){
			alert("내용을 입력해주세요.");
		}else{
			$("#comment_user_spamfree").val(_timestamp);
			$("#userCommentFrm").submit();
		}
	});
	
	/**
	 * 커맨트 등록
	 * 2depth gallery에 적용
	 */
	$(document).on("submit", "#comment_write_form", function(e){
		
		//e.preventDefault();
		//$("#comment_write_form").submit();
		
		if($('#comment_write_form').formvalidate()){
			$("#comment_spam_free").val(_timestamp);
			if(	!$("#hiddenIframe").length)  $("body").append('<iframe name="hiddenIframe" id="hiddenIframe" width="200px" height="200px" style="display:none"></iframe>');
			$("#comment_write_form").attr("target", "hiddenIframe");
			$("#comment_write_form").attr("action", "./lib/ajax.board.php");
			$("#hiddenIframe").load(function(data) {
				console.log(data);
				var result = $("#hiddenIframe").get(0).contentWindow.result
				if(result == "0"){
					roadCommentList();
				}
                   //console.log(this);
             });
		}else e.preventDefault();
	});

	$(".boardviewcontents a").click(function(e){
		e.preventDefault();
		var href = $(this).attr("href");
		var target = $(this).attr("target");
		if(confirm(href +"로 이동하시겠습니까?")){
			if(typeof(target) == "undefined"){
				location.href=href;
			}else{
				window.open(href, "boardlinkpop", "");
			}
			
		}
		
	});
});


/**
 * ajax로 comment 리스트 불러오기
 * @param cp
 */
function roadCommentList(cp){
	var url = "./wizboard/skin/"+_skin_type+"/sub_list.php";
	$.post(url,{BID:_bid, GID:_gid, UID:_uid, cp:cp}, function(data){
		$("#HTMLGalleryList").html(data);
	});
}

/**
 * 커멘트 삭제
 * @param uid : reply UID
 */
function deleteComment(uid){
	var url = "./lib/ajax.board.php";
	$.post(url,{smode:"delete_reple", BID:_bid, GID:_gid, UID:_uid, CUID:uid}, function(data){
		roadCommentList(1);
	});
}

/**
 * 커멘트 수정 정보 가져오기
 * @param uid : reply UID
 * repleMod 사용 ?
 */
function roadCommentModifyValue(uid){
	
}

function repleMod(uid){//리플정보를 불러와 수정모드로 변경한다.
    $.post("./lib/ajax.board.php", {smode:"getreple",bid:_bid,gid:_gid, uid:uid}, function (data){
        var result=data.split("|");
        if(document.getElementById("RPLCONTENTS")) document.getElementById("RPLCONTENTS").value = result[1];
        document.COMMENT.REPLE_MODE.value="update";
        document.COMMENT.RUID.value=uid;
        
    });
}


function gotob(mode, uid){
	$("#boardForm #mode").val(mode);
    $("#boardForm #UID").val(uid);
    $("#boardForm").submit(); 
}

/**
 * 게시물 등록
 * @param f
 * @returns {Boolean}
 */
function board_write_fnc(f){
	if($("#sethtmleditor").val() == "1") oEditors.getById["CONTENTS"].exec("UPDATE_CONTENTS_FIELD", []); //smart Editor 에 대한 보강

	if(f.spamfree.value){
		alert('데이타가 전송중입니다.');
		return false;	
	}else if(autoCheckForm(f)){
		//첨부된 파일 정보를 바꾼다.	
		if(f.multi_file_list != undefined){
			var multi_file_len = f.multi_file_list.length;
			var TmpMultiFileValue = '';		
			var tmparr = "";
			for(var i=0; i < multi_file_len; i++){
				if(f.multi_file_list.options[i]) TmpMultiFileValue += f.multi_file_list.options[i].value + '|';
			}
			f.MultiFileValue.value = TmpMultiFileValue;
		}
			
		f.spamfree.value=_timestamp;
		$("#WRITE_FORM_TRANSFER_DIV").show();
		$("#WRITE_FORM_DIV").hide();
		return true;
    }else return false;
}

//구버젼의 comment_write 신버젼으로는 $("#comment_write_form").submit를 사용
function comment_write_fnc(f){
	if(f.spamfree.value){
		alert('데이타가 전송중입니다.\n그대로 기다리시거나 새로고침을 하여 주시기 바랍니다.');
		return false;	
	}else if(f.ismember.value == "true" && f.ID.value == ""){
		alert('회원전용입니다.\n로그인후 이용해주세요');
        return false;        
	}else if(autoCheckForm(f)){
		f.spamfree.value=_timestamp;
		return true;
    }else return false;
}





function tb_box(v){//트랙백관련 박스 숨기고 보이게 하기
	if(v.checked) $("#tb_url_box").show();
	else $("#tb_url_box").hide();
}

function DELETE_THIS(UID,cp,BID,GID,adminmode,optionmode){
    window.open("./wizboard/delete.php?UID="+UID+"&cp="+cp+"&BID="+BID+"&GID="+GID+"&adminmode="+adminmode+"&optionmode="+optionmode,"","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350")
}

function down(updir, uid){
    file_url = "./wizboard/download.php?filename="+updir+"&UID="+uid+"&BID="+_bid+"&GID="+_gid;
    location.href=file_url;
}

function printThis(){
	window.open('./wizboard/skin/'+_skin_type+'/print.php?UID='+_uid+'&BID='+_bid+'&GID='+_gid,'printer','resizable=yes,width=630,height=650');
}

function sendmail(bid,uid){
    file_url = "./wizboard/sendemail.php?UID="+uid+"&BID="+_bid+"&GID="+_gid;
    window.open(file_url,'printer','resizable=yes,width=400,height=460');
}


function closeImgLayer(){
	imgLayer.style.display = "none";
}

function openImgLayer(src){
	imgLayer.style.posLeft = event.clientX
    imgLayer.style.posTop = event.clientY
	imgLayer.style.display = "block";
	popLayerImg.src = src;
}




function orderby(v){
	var f = document.board_search;
    f.oderflag.value = v.value;
    f.submit();
}

// gamech 용 시작
function orderby1(v){           
	var f = document.board_search;
    f.oderflag.value = v.value;
    if(v.value == "GETPOINT@desc" || v.value == "RECCOUNT@desc" || v.value == "RPLCOUNT@desc" || v.value == "COUNT@desc" )
    {
    	f.search_term.value = 60*60*24*30*3;
    }
    else
    {
    	f.search_term.value = "";
    } 
    f.submit();
}


function lv_select(lv){           
	location.href="./wizboard.php?BID="+_bid+"&GID="+_gid+"&SEARCHTITLE=GETPOINT&optionmode="+lv;
}
// gamech 용 끝


function boardSearch(f, type){
	if(type == undefined) type = "";
    switch(type)
    {
    	case 1:
        	

        //검색필드가 책크박스로서 멀티 구현시
        // 이경우는 <input type=hidden name=SEARCHTITLE value=>  으로 처리 되어 있어야함
        	var cnt = 0;
            var stitle = "";
           	var currEl;
           
            for(i = 0; i < f.elements.length; i++)
            { 
            	currEl = f.elements[i];
                
                if(currEl.type != undefined){
                    if(currEl.type.toLowerCase() == "checkbox" && currEl.checked == true){ 
                        stitle += currEl.value + "+";
                        cnt++;
                    }
                }
            }
            if (cnt == 0)
            {
            	alert('한개이상의 검색필드를 선택해 주세요');
                return false;
            }
            else
            {
            	f.SEARCHTITLE.value = stitle;
            	return true;
            }
        break;
    	default:
        	if(autoCheckForm(f))
            {
            	return true;
            }
            else
            {
            	return false;
            }
        break;
    }

} 

function ShowPopLayer(aEvent,LayName)
{
	// 사용법 ShowPopLayer(event,'레이어 ID')"
	var x = window.event ? window.event.clientX + document.documentElement.scrollLeft : aEvent.pageX;
	var y = window.event ? window.event.clientY + document.documentElement.scrollTop : aEvent.pageY;
	if (LayName) document.getElementById(LayName).style.top=y+"px";
	if (LayName) document.getElementById(LayName).style.left=x+"px";
	if (LayName) document.getElementById(LayName).style.display="block";
}

//community 스킨용
function add_file()
{
	if(document.BOARD_WRITE_FORM["multi_file_list"].length == 10)
	{
		window.alert("파일은 10개 만 첨부가능 합니다.");
		return false;
	}
	var ref = "./wizboard/fileprocess_editor.php?bid="+_bid+"&gid="+_gid;
	newWindow = window.open(ref,"add_files",'width=312, height=157,left=300,top=250, toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, scrollbars=no, copyhistory=no');
}

function del_file()
{
	var file_name = "";
	var file_ok = 0;
	var obj = document.BOARD_WRITE_FORM["multi_file_list"];
	for(i=0;i<obj.options.length;i++)
	{
		if(obj.options[i].selected == true)
		{
			file_name += obj.options[i].value + ",";
			file_ok++;
		}
	}
	if(file_ok==0)
	{
		window.alert("파일을 선택하세요.");
		return false;
	}
	var ref = "./wizboard/fileprocess_editor.php?bid="+_bid+"&gid="+_gid+"&smode=moveout&file_name="+file_name;
	for(i=0 ; i<obj.length ; i++)
	{
		if(obj.options[i].selected)
		{
			obj.options[i] = null;
			i--;
		}
	}
	newWindow = wizwindow(ref,'del_files','width=312, height=157,left=300,top=250, toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, scrollbars=no, copyhistory=no');
}


function file_up_move(frm)
{
	var file_ok = 0;
	var text;
	var value;
	var obj;
	var text_a = new Array();
	var value_a = new Array();
	obj = frm["multi_file_list"];
	for(i=0 ; i < obj.length ; i++)
	{
		text_a[i] = obj.options[i].text;
		value_a[i] = obj.options[i].value;
		if(obj.options[i].selected)
		{
			if(i==0)
			{
				window.alert(obj.options[i].text+"파일을 올릴수 없습니다.");
				obj.options[i].selected = false;
				return false;
			}
			var checkidx = i-1;
			text = obj.options[i].text;
			value = obj.options[i].value;
			text_a[i] = obj.options[i-1].text;
			value_a[i] = obj.options[i-1].value;
			text_a[i-1] = text;
			value_a[i-1] = value;
			file_ok++;
		}
	}
	if(file_ok==0)
	{
		window.alert("파일을 선택하세요.");
		return false;
	}
	for(i=0 ; i < obj.length ; i++)
	{
		var up_option = new Option(text_a[i],value_a[i]);
		obj.options[i] = up_option;
	}
	obj.options[checkidx].selected = true;
	return true;
}



function file_down_move(frm)
{
	var file_ok = 0;
	var text;
	var value;
	var obj;
	var text_a = new Array();
	var value_a = new Array();
	obj = frm["multi_file_list"];
	for(i=obj.length-1 ; i >= 0 ; i--)
	{
		text_a[i] = obj.options[i].text;
		value_a[i] = obj.options[i].value;
		if(obj.options[i].selected)
		{
			if(i == obj.length-1)
			{
				window.alert(obj.options[i].text+" 파일을 내릴수 없습니다.");
				obj.options[i].selected = false;
				return false;
			}
			var checkidx = i+1;
			text = obj.options[i].text;
			value = obj.options[i].value;
			text_a[i] = obj.options[i+1].text;
			value_a[i] = obj.options[i+1].value;
			text_a[i+1] = text;
			value_a[i+1] = value;
			file_ok++;
		}
	}
	if(file_ok==0)
	{
		window.alert("파일을 선택하세요.");
		return false;
	}
	for(i=0 ; i < obj.length ; i++)
	{
		var up_option = new Option(text_a[i],value_a[i]);
		obj.options[i] = up_option;
	}
	obj.options[checkidx].selected = true;
	return true;
}

//ajax 관련 시작


//투표시작
function Vote(uid,flag)
{
	//flag : g : Good, b : Bad
	//Vote('uid','g')
	if(flag == 'g') var Ctext = '추천';
	else var Ctext = '비추천';

	if(confirm('해당글을 ' + Ctext + ' 하시겠습니까?'))
	{
		xmlHttpPost('./lib/ajax.vote.php', 'uid='+uid+'&flag='+flag+'&gid='+_gid+'&bid='+_bid, 'ch_replecnt');
	}
}

function ch_replecnt(pdata)
{
	eval(pdata);
	var result = result;
	var msg = msg;
    var targetDiv = targetDiv;
    
	if(result == false){
    	alert(msg);
    }else{
    	if(targetDiv != undefined){
            var str = document.getElementById(targetDiv);
            str.innerHTML = parseInt(str.innerHTML) + 1;
        }
	}
    
}

//리플에서의 투표시작
function voteReple(uid,flag)
{
	if(flag == 'g') var Ctext = '추천';
	else var Ctext = '비추천';

	if(confirm('해당글을 ' + Ctext + ' 하시겠습니까?'))
	{
		xmlHttpPost('./lib/ajax.replevote.php', 'uid='+uid+'&flag='+flag+'&gid='+_gid+'&bid='+_bid, 'ch_replecnt1');
	}
}

function ch_replecnt1(pdata)
{
	// targtDiv = g_vote(추천) or b_vote(비추천)
	eval(pdata);
	var result = result;
	var msg = msg;
    var targetDiv = targetDiv;
    
	if(result == false){
    	alert(msg);
    }else{
    	var str = document.getElementById(targetDiv);
		str.innerHTML = parseInt(str.innerHTML) + 1;
	}
    
}



//리스트 가져오기(대박/추천 게시물)
function GetList(spage, listno, flag,targetDiv)
{
	//flag = lv30 : 대박 게시물, rec : 추천게시물
   // document.getElementById("msgstr").innerHTML = 'spage='+spage+'&listno='+listno+'&flag='+flag+'&targetDiv='+targetDiv+'&gid='+_gid+'&bid='+_bid;
	xmlHttpPost('./lib/ajax.getlist1.php', 'spage='+spage+'&listno='+listno+'&flag='+flag+'&targetDiv='+targetDiv+'&gid='+_gid+'&bid='+_bid, 'DisplayList');
}

function DisplayList(pdata)
{
	eval(pdata);
	var arData = a;
   
	var NeedDiv = NeedDiv;
	var str = document.getElementById(NeedDiv);
	while(str.childNodes.length)
	{
		str.removeChild(str.childNodes[0]);
	}
	for (var i=0; i<arData.length; i++)
	{
		var cNode = document.createElement('li');
		if (i==arData.length-2) cNode.className = 'endline';
		else if (i==arData.length-1) cNode.className = '';
		else cNode.className = 'middleline';
		cNode.innerHTML=arData[i];
		str.appendChild(cNode);
	}
   
}

function GetListGallery(spage, listno, flag,targetDiv)
{
	xmlHttpPost('../lib/ajax.getlist.gall1.php', 'spage='+spage+'&listno='+listno+'&flag='+flag+'&targetDiv='+targetDiv+'&gid='+_gid+'&bid='+_bid, 'DisplayListGallery');
}

function DisplayListGallery(pdata)
{
	eval(pdata);
	var arData = a;
	var NeedDiv = NeedDiv;
	var str = document.getElementById(NeedDiv);
    
	while(str.childNodes.length)
	{

		str.removeChild(str.childNodes[0]);
	}
    
       
	for (var i=0; i<arData.length; i++)
	{
    
		var cNode = document.createElement('li');
		if (i==0 || i==3) cNode.className = 'line';
		else cNode.className = '';
        
		cNode.innerHTML=arData[i];
         //alert(arData[i]);
		str.appendChild(cNode);
	}
   
}


function GetAlbum(user_id,cp)
{
	xmlHttpPost('./lib/ajax.album.php', 'user_id='+user_id+'&cp='+cp+'&gid='+_gid+'&bid='+_bid, 'GetAlbumSub');
}

function GetAlbumSub(pdata)
{
	eval(pdata);
    
	var AlbumDesc = AlbumDesc;
	document.getElementById('GalleryAlbum').innerHTML = AlbumDesc;
}

function GetAlbumComment(user_id,cp)
{
	//document.getElementById("msg").innerHTML = './lib/ajax.album.comment.php?user_id='+user_id+'&cp='+cp+'&gid='+_gid+'&bid='+_bid;
	xmlHttpPost('./lib/ajax.album.comment.php', 'user_id='+user_id+'&cp='+cp+'&gid='+_gid+'&bid='+_bid, 'GetAlbumCommentSub');
}

function GetAlbumCommentSub(pdata)
{
	eval(pdata);
	var AlbumCommentDesc = AlbumCommentDesc;
	document.getElementById('AlbumComment').innerHTML = AlbumCommentDesc;
}
//ajax 관련끝




function YourRecomm(seq,BbsCode,AjaxPageName,Choice,targetDiv)
{
	if(Choice == 'Good') var Ctext = '추천';
	else var Ctext = '비추천';

	if(confirm('해당글을 ' + Ctext + ' 하시겠습니까?'))
	{
		if(AjaxPageName) xmlHttpPost('../ajaxClass/'+AjaxPageName, 'seq='+seq+'&BbsCode='+BbsCode+'&Choice='+Choice+'&targetDiv='+targetDiv, 'CntChange');
	}
}

function CntChange(pdata)
{
	eval(pdata);
	var NeedDiv = NeedDiv;
	var Login = Login;
	var SelfWrite = SelfWrite;
	var Limit = Limit;
	var Finish = Finish;
	var str = document.getElementById(NeedDiv);
	if(Login == 'yes')
	{
		if(confirm('     추천은 회원만 가능합니다.\r\n로그인 페이지로 이동하시겠습니까?'))
		{
			var url = escape(document.location);
			document.location.href='http://www.mud4u.com/new/bbs/login.php?url='+url;
		}
	}
	else if(SelfWrite == 'yes')
	{
		alert('      자신이 쓴 글에는\r\n추천을 하실 수 없습니다.');
	}
	else if(Limit == 'yes')
	{
		alert('      하루에 사용할 수 있는\r\n추천수를 모두 사용하였습니다.\r\n더 이상 추천 하실 수 없습니다.');
	}
	else if(Finish == 'yes')
	{
		alert('이미 추천하셨습니다.');
	}
	else
	{
		str.innerHTML = Cnt;
	}
}

function WChange(D)
{
	if(D == 'IamMember')
	{
		document.getElementById('mWChange').innerText = '아이디';
	}
	else
	{
		document.getElementById('mWChange').innerText = '닉네임';
	}
}

function ThanksYou(aEvent, t)
{
	var x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
	var y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;
	if(!t.loginchk.value)
	{
		if(!t._SpamFilter.value)
		{
			alert('코드를 입력해주십시오!');
			t._SpamFilter.focus();
			return false;
		}
	}
	if(!t.bbs_contents.value)
	{
		alert('코멘트를 입력해주십시오!');
		t.bbs_contents.focus();
		return false;
	}
	document.getElementById("content").style.display='block';
	document.getElementById("content").style.top=y+170+"px";
	document.getElementById("sub_btn").style.cursor='default';
	document.getElementById("sub_btn").disabled=true;
	return true;
}



function chkForm(t)
{
	if(!t.passwd.value || t.passwd.value==t.passwd.defaultValue)
	{
		alert('비밀번호를 입력하세요.');
		t.passwd.focus();
		return false;
	}
}

function chkFormComm(t)
{
	if(!t.bbs_contents.value)
	{
		alert('코멘트를 입력하세요.');
		t.bbs_contents.focus();
		return false;
	}
}

function ShowL(aEvent)
{
	var x = window.event ? window.event.clientX + document.documentElement.scrollLeft : aEvent.pageX;
	var y = window.event ? window.event.clientY + document.documentElement.scrollTop : aEvent.pageY;
	document.getElementById("moveFrm").style.display='block';
	document.getElementById("moveFrm").style.left=x-70+"px";
	document.getElementById("moveFrm").style.top=y+18+"px";
}

function ShowL1(aEvent,Layname)
{
	var x = window.event ? window.event.clientX + document.documentElement.scrollLeft : aEvent.pageX;
	var y = window.event ? window.event.clientY + document.documentElement.scrollTop : aEvent.pageY;
	document.getElementById(Layname).style.display='block';
	document.getElementById(Layname).style.left=x-70+"px";
	document.getElementById(Layname).style.top=y+18+"px";
}

function GetComment(seq,AjaxPageName,PG,BbsCode)
{
	if(AjaxPageName) xmlHttpPost('../ajaxClass/'+AjaxPageName, 'seq='+seq+'&PG='+PG+'&BbsCode='+BbsCode, 'GetCommentSub');
}

function GetCommentSub(pdata)
{
	eval(pdata);
	var CommentDesc = CommentDesc;
	var CommentPage = CommentPage;
	document.getElementById('view_8').innerHTML = CommentDesc;
	document.getElementById('view_12').innerHTML = CommentPage;
}

