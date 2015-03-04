$(function(){
	
	$(".opflag").click(function(){
		$("#cobuyfield").hide();
		$("#diffpricefield").hide();
		var cnt = $(".opflag:checkbox:checked").length;
		var i	= $(".opflag").index(this);
		if(cnt >= 2){
			$(this).attr("checked", false);
			//$(this).checked = false;
			jAlert('공동구매와 차등가격은 동시에 선택될 수 없습니다.');
			
		}else if($(this).is(':checked')){
			var val = $(this).val();

			switch(val){
				case "c"://공동구매
					$("#cobuyfield").show();
					break;
				case "d"://차등가격
					$("#diffpricefield").show();
					break;
			}
		}
	});

	$("#addDiffprice").click(function(){
		var addString = '<li>';
		addString += '<ul><li>';
		addString += '- 신청수량이 <input name="diffQtyArr[]" value="" class="w30"> 개 미만일때 <input name="diffPriceArr[]" onkeydown=onlyNumber() value="" class="w50">';
		addString += ' <span class="button bull btn_addDiffprice_del"><a>삭제</a></span>';
		addString += '</li></ul>';
		addString += '</li>';
		$(addString).appendTo(".diffpricefieldClass");
	});

	//$(".btn_addDiffprice_del").live("click", function(){
	$(document).on("click", ".btn_addDiffprice_del", function(){
		//var i = $(".btn_addDiffprice_del").index(this);
		$(this).parent().parent().parent().remove();
	});
});

function getCategory(v, step) {
	if(step == 1) $("#Category2").removeOption(/./);
	else if(step == 2) $("#Category3").removeOption(/./);
		$.ajax({
		
			type: "GET",
			url: "./product/search_category.php",
			data: "value="+v.value+"&step="+step,//특정변수값을 주어서 결과를 받을때
			dataType: "xml",
			success: function(xml) {
				$(xml).find('item').each(function(){
					var cat_no = $(this).find('cat_no').text();
					var cat_name = $(this).find('cat_name').text();
					if(step == 1) $("#Category2").addOption(cat_no, cat_name, false);
					else if(step == 2) $("#Category3").addOption(cat_no, cat_name, false);	
					
				}); //close each(
			}//close function(xml)
		}); //close $.ajax(

} //close $(


function checkForm(f) {
	//var MultiCategorylen = f.TmpMultiCategory.length;
	var MultiCategorylen	= $("#TmpMultiCategory").length;
	var TmpMultivalue		= '';		
	var tmparr				= "";

	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
	
	for(var i=0; i< MultiCategorylen; i++){
		if(f.TmpMultiCategory.options[i]) TmpMultivalue += f.TmpMultiCategory.options[i].value + '|';
	}
	f.TmpMultiCategoryvalue.value = TmpMultivalue;
			
	if(!f.tmpSimilarPd) tmpSimilarPd = new Array(); 
	if ( f.Category1.value.length == 0 ) {
		alert( '등록할 카테고리를 선택해주세요' );
		f.Category1.focus();
		return false;
	}else if ( f.Name.value.length == 0 ) {
		alert( '상품의 이름을 입력해주세요' );
		f.Name.focus();
		return false;
	}else if ( f.Price.value.length == 0 ) {
		alert( '상품의 판매가를 입력해주세요' );
		f.Price.focus();
		return false;
	}else{
		if(f.tmpSimilarPd){
			var tmpSimilarPdlen = f.tmpSimilarPd.length
			for (i = 0; i < tmpSimilarPdlen; i++){
				tmparr = tmparr +"|"+f.tmpSimilarPd[i].value;
			}
			f.SimilarPd.value = tmparr
		}
	}
}

function MultiCategorySelect(selObj){
	var f=document.writeForm
	var aIdx=f.TmpMultiCategory.options.length;
	var str=selObj.options[selObj.selectedIndex].text;
	var itm= new Option(str)
	if(aIdx >= 5){
		window.alert('5개이상 카테고리 적용은 불가능합니다.');//이부분 풀어주시면 무한대.
		return false;
		exit;
	}
	f.TmpMultiCategory.options[aIdx] = itm;
	f.TmpMultiCategory.options[aIdx].value = selObj.options[selObj.selectedIndex].value
}

function DeleteMultiCat(sel){
	var f=document.writeForm
	var selectedIndexNo = sel.selectedIndex;
	sel.options[sel.selectedIndex]=null;
}

function addToPIC()
{
 var oID = document.getElementById('nameToDiv');

  var item = document.createElement("input");
  item.setAttribute('type','file');
  item.setAttribute('name','file[]');
  item.setAttribute('class','dd1');
  oID.appendChild(item);
  
/*
기존 IE 용
	nameToDiv.insertAdjacentElement("BeforeEnd",document.createElement("<br />"));
	nameToDiv.insertAdjacentElement("BeforeEnd",document.createElement("<input type='file' name='file'>"));
	*/
}

function del(no,idx){
	location.href = "<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&mode=<?=$mode;?>&cp=<?=$cp?>&uid="+no+"&query=qde"+ "&idx="+idx;    	 
}

//옵션관련 자바스크립트 시작
function listOptionCnt(v, inicnt){
	var cnt = parseInt(v.value);
	//alert(cnt);
	var data = "";
	for (i=1+parseInt(inicnt); i <= cnt; i++)    { 
		tmpno = "0"+i;
		var k = i-1;

		data = data +
		"<table>"+
		"<tr>"+
		"<td id=currPosition>옵션명 : <input name='opname["+k+"]' value='' class='w100'> "+
		"<select name='opcnt["+k+"]' onChange='listeachOptionCnt(this, "+k+", 0)'>"+
		"<option value='0'>갯수</option>"+
		"<option value='1'>1</option>"+
		"<option value='2'>2</option>"+
		"<option value='3'>3</option>"+
		"<option value='4'>4</option>"+
		"<option value='5'>5</option>"+
		"<option value='6'>6</option>"+
		"<option value='7'>7</option>"+
		"<option value='8'>8</option>"+
		"<option value='9'>9</option>"+
		"<option value='10'>10</option>"+
		"</select> "+
		"<select name='opflag["+k+"]'> "+
		"<option value='0' selected='selected'>기본</option> "+
		"<option value='1'>가격추가</option>"+
		"<option value='2'>원가격변경</option>"+
		"</select></td>"+
		"<td><span id='add_optioneach_"+k+"'></span></td>"+
		"</tr>"+
		"</table>";
		
	}
	$("#add_option").html(data);
}//end function listOptionCnt


function listeachOptionCnt(v, uid, inicnt){
	var cnt = v.value;
	var data = "";
	//uid = uid + parseInt(f.optioncntadd.value);
	for (i=1+parseInt(inicnt); i <= cnt; i++)    { 
		tmpno = "0"+i;
		var k = i-1;
		//var k = i-1 + parseInt(f.optioncntadd.value);
		data = data +
		"<table>"+
		"<tr>"+
		"<td>옵션값:"+
		"<input name='optioneachname["+uid+"]["+k+"]' class='w50' /> "+
		"가격:"+
		"<input name='optioneachprice["+uid+"]["+k+"]'  class='w30' value='0'> "+
		"재고: "+
		"<input name='optioneachqty["+uid+"]["+k+"]'  class='w30'value='0'></td>"+
		"</tr>"+
		"</table>";
		
	}
	//alert(data)
	
	$("#add_optioneach_"+uid).html(data);

}//end function listeachOptionCnt

function option_del(el)
{
	idx = el.rowIndex;
	obj = el.parentNode
	obj.deleteRow(idx);
	//deleteRow(idx);
	//deleteRow(el);

}

//옵션관련 자바스크립트 시끝



function gotobasicinfo(){
	location.href="?menushow=menu2&theme=basicconfig/basic_info2";
}


function dp_watermark(v){//워터 마크 옵션 디피
	$("#watermark_text").hide();
	$("#watermark_img").hide();

	switch(v.value){
    	case "text":$("#watermark_text").show();break;
        case "img":$("#watermark_img").show();;break;
    }
}  

//비교상품관련
function adSimilarPd(idx)
{
	var tb0 = document.getElementById('tb0');
	var tb = parent.document.getElementById('tb_refer');

	oTr = tb.insertRow(0);
	oTd = oTr.insertCell(-1);
	oTd.innerHTML = tb0.rows[idx].cells[0].innerHTML;
	oTd = oTr.insertCell(-1);
	oTd.innerHTML = tb0.rows[idx].cells[1].innerHTML;

	tb.rows[0].className = "hand";
	tb.rows[0].onclick = function(){ parent.spoit('refer',this); }
	tb.rows[0].ondblclick = function(){ parent.remove('refer',this); }
	parent.react_goods('refer');
}

function react_goods(name)
{
	var tmp = new Array();
	
	var obj = document.getElementById('tb_'+name);
	//alert(obj.rows.length);
	for (i=0;i<obj.rows.length;i++){
	//alert(obj.rows[i].cells[0].innerHTML);
		tmp[tmp.length] = "<div style='float:left;width:0;border:1 solid #cccccc;margin:1px;' title='" + obj.rows[i].cells[1].getElementsByTagName('div')[0].innerText + "'>" + obj.rows[i].cells[0].innerHTML + "</div>";
	}
	document.getElementById(name+'X').innerHTML = tmp.join("") + "<div style='clear:both'>";
}


// 파일 첨부시 미리보기 구현
//<input type='file' name='file[0]' onchange="return image_onchange(0);" id=upfile><img alt=미리보기 id=sm src="" width="largh" style="VISIBILITY: hidden"  name="imgsiz">
function AutoResize(img, flag){ 
	foto1= new Image(); 
	foto1.src=(img); 
	Controlla(img, flag); 
} 
function Controlla(img, flag){ 
	if((foto1.width!=0)&&(foto1.height!=0)){ 
		viewFoto(img, flag); 
	} 
	else{ 
		funzione="Controlla('"+img+"')"; 
		intervallo=setTimeout(funzione,20); 
	} 
} 
function viewFoto(img, flag){ 
	largh=foto1.width; 
	img_width=foto1.width;
	altez=foto1.height;
	img_height=foto1.height;
	if(largh >= 80) {
		largh = 80;
	}
	//if(altez >= 650) {
	//   altez = 450;
	//}
	var imgsiz
	document.imgsiz[flag].width = largh ;
	document.imgsiz[flag].alt = '원본 이미지사이즈 :' + img_width +'×'+ img_height ;
	//document.imgsiz.height = altez ;
	//f.sm.style.visibility="visible";
} 

function image_onchange(flag){    
	var f=document.writeForm;
	sm=new Array(); 
	upfile=new Array(); 
    if(f.upfile.value!=""){
    f.sm[flag].src=f.upfile[flag].value;
    f.sm[flag].style.visibility="visible";
    imgsize = f.upfile[flag].value;
    if(event.srcElement.value.match(/(.jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG)/)) {
        f.sm[flag].src = event.srcElement.value;
        f.sm[flag].style.display = '';

        if(f.sm[flag].fileSize > 1000*1024){ 
        document.images[img_pre].style.display = 'none';
        alert("1000k 이상은 업로드 하실수 없습니다.");
        }
    }
    else {
        document.images[img_pre].style.display = 'none';

        if(f.sm.fileSize ==-1){
        alert("이미지 파일만 가능합니다");
        }
    }

    AutoResize(imgsize, flag);
    }                

}


//이미지 원래크기로 팝업창 띄우기/////////////////////////////////
function AutoResize1(img){ 
  foto1= new Image(); 
  foto1.src=(img); 
  Controlla1(img); 
} 
function Controlla1(img){ 
  if((foto1.width!=0)&&(foto1.height!=0)){ 
    viewFoto1(img); 
  } 
  else{ 
    funzione="Controlla('"+img+"')"; 
    intervallo=setTimeout(funzione,20); 
  } 
} 
function viewFoto1(img){ 
  largh=foto1.width; 
  altez=foto1.height;
  if(largh >= 1024 && 768 <= altez) {
      largh = 1024;
   }
   if(largh <= 1024 && altez >= 768) {
      largh = largh + 40;
      altez = 768;
   }
   if(largh >= 1024 && altez >= 768) {
      largh = 1024;
      altez = 768;
   }
  stringa="width="+largh+",height="+altez+",left=0,top=0,scrollbars=yes"; 
  finestra=window.open(img,"",stringa);
  
} 
