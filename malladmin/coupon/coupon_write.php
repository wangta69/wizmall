<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/

if($query == "qin"){
//wizCoupon
//uid,cname,cdesc,cpubtype,cpubdowncnt,cpubapplyall,cpubapplycontinue,ctype,csaleprice,csaletype,capplytype,capplycategory,capplyproduct`,cimg,ctermtype,cterm,ctermf,cterme,crestric
	$ctermfdate = explode(".", $ctermf_date);
	$ctermedate = explode(".", $cterme_date);
	
	$ctermf	= mktime($ctermfhour,$ctermfmin,0,$ctermfdate[1],$ctermfdate[2],$ctermfdate[0]);
	$cterme	= mktime($ctermehour,$ctermemin,0,$ctermedate[1],$ctermedate[2],$ctermedate[0]);
	

	
	$sqlstr = "insert into wizCoupon (cname,cdesc,cpubtype,cpubdowncnt,cpubapplyall,cpubapplycontinue,edncnt,ctype,csaleprice,csaletype,capplytype,capplycategory,capplyproduct,cimg,ctermtype,cterm,ctermf,cterme,crestric,wdate)
	values
	('$cname','$cdesc','$cpubtype','$cpubdowncnt','$cpubapplyall','$cpubapplycontinue','$edncnt','$ctype','$csaleprice','$csaletype','$capplytype','$capplycategory','$capplyproduct','$cimg','$ctermtype','$cterm','$ctermf','$cterme','$crestric',".time().")";
	$result = $dbcon->_query($sqlstr);
	$couponid = mysql_insert_id();
	
	//wizCouponapply
	//uid,couponid,category,pid	
	
	//적용카테고리 입력
	if(is_array($category)){
		foreach($category as $key => $value){
			if($value){
				$sqlstr = "insert into wizCouponapply (couponid,category) values ('$couponid','$value')";
				$dbcon->_query($sqlstr);
			}
		}
	}
	//적용제품 입력
	if(is_array($e_refer)){
		foreach($e_refer as $key => $value){
			if($value){
				$sqlstr = "insert into wizCouponapply (couponid,pid) values ('$couponid','$value')";
				$dbcon->_query($sqlstr);
			}
		}
	}	
	
	echo "<script>location.href='$PHP_SELF?menushow=$menushow&coupon/coupon_list';</script>";
	
}else if($query == "qup"){
	$ctermfdate = explode(".", $ctermf_date);
	$ctermedate = explode(".", $cterme_date);
	
	$ctermf	= mktime($ctermfhour,$ctermfmin,0,$ctermfdate[1],$ctermfdate[2],$ctermfdate[0]);
	$cterme	= mktime($ctermehour,$ctermemin,0,$ctermedate[1],$ctermedate[2],$ctermedate[0]);
	

	
	$sqlstr = "update wizCoupon set
	 		cname = '$cname',
			cdesc = '$cdesc',
			cpubtype = '$cpubtype',
			cpubdowncnt = '$cpubdowncnt',
			cpubapplyall = '$cpubapplyall',
			cpubapplycontinue = '$cpubapplycontinue',
			edncnt = '$edncnt',
			ctype = '$ctype',
			csaleprice = '$csaleprice',
			csaletype = '$csaletype',
			capplytype = '$capplytype',
			capplycategory = '$capplycategory',
			capplyproduct = '$capplyproduct',
			cimg = '$cimg',
			ctermtype = '$ctermtype',
			cterm = '$cterm',
			ctermf = '$ctermf',
			cterme = '$cterme',
			crestric = '$crestric'
			where uid = $uid";

	$result = $dbcon->_query($sqlstr);
	$couponid = mysql_insert_id();
	
	//기존 등록된 내용은 모두 삭제하고 새로 입력
	$sqlstr = "delete from wizCouponapply where couponid = '$uid'";
	$dbcon->_query($sqlstr);
	
	//적용카테고리 입력
	if(is_array($category)){
		foreach($category as $key => $value){
			if($value){
				$sqlstr = "insert into wizCouponapply (couponid,category) values ('$uid','$value')";
				$dbcon->_query($sqlstr);
			}
		}
	}
	//적용제품 입력
	if(is_array($e_refer)){
		foreach($e_refer as $key => $value){
			if($value){
				$sqlstr = "insert into wizCouponapply (couponid,pid) values ('$uid','$value')";
				$dbcon->_query($sqlstr);
			}
		}
	}
	
	echo "<script>location.href='$PHP_SELF?menushow=$menushow&theme=$theme&uid=$uid';</script>";
}




if($uid){
	$mode = "qup";
	## 입력데이타 가져오기
	$sqlstr = "select * from wizCoupon where uid = '$uid'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	
	##등록 카테고리/상품가져오기
	$sqlstr = "select * from wizCouponapply where couponid = '$uid'";
	$dbcon->_query($sqlstr);
	while($sublist = $dbcon->_fetch_array()):
		if($sublist["category"]) $category[] = $sublist["category"];
		if($sublist["pid"]) $e_refer[] = $sublist["pid"];
	endwhile;

}else{
	$mode = "qin";
	$list["cpubdowncnt"] = 1;
	$list["edncnt"] = 0;
}
?>
<script language=javascript src="../js/Calendar.js"></script>
<script language=javascript src="../js/wizmall.js"></script>
<script id="dynamic"></script>
<script language=JavaScript>
<!--
function checkForm(f){
	if(f.cname.value == ""){
		alert('쿠폰이름을 입력하세요');
		f.cname.focus();
		return false;	
	}else if(f.csaleprice.value == ""){
		alert('쿠폰금액을 입력하세요');
		f.csaleprice.focus();
		return false;	
	}else return true;
}

function chk_cpubtype(v){
	if(v.value == "2"){
		box_cpubtype2.style.display = "block";
	}else{
		box_cpubtype2.style.display = "none";
	}
}

function chk_ctermtype(v){
	for(i=1; i<=2; i++){
		//alert(v.value);
		if(v.value == i){
			eval("ctermtype"+i+".style.display = 'block'");
		}else{
			eval("ctermtype"+i+".style.display = 'none'");
		}
	}
	
}

function getCategory(step,f,flag,target){
	form = f.form.name;
	//alert ("./product/search_category.php?step="+step+"&trigger="+f.value+"&form="+form+"&flag="+flag+"&target="+target);
	dynamic.src = "./product/search_category.php?step="+step+"&trigger="+f.value+"&form="+form+"&flag="+flag+"&target="+target;
	
}

function exec_add()
{
	var ret;
	var str = new Array();
	var obj = document.forms[0]['selectCategory'];
	//alert(obj.length);
	for (i=0;i<obj.length;i++){
		if (obj[i].value){
			str[str.length] = obj[i][obj[i].selectedIndex].text;
			ret = obj[i].value;
		}
	}
	if (!ret){
		alert('카테고리를 선택해주세요');
		return;
	}
	var obj = document.getElementById('objCategory');
	oTr = obj.insertRow();
	oTd = oTr.insertCell();
	oTd.id = "currPosition";
	oTd.innerHTML = str.join(" > ");
	oTd = oTr.insertCell();
	oTd.innerHTML = "\<input type=text name=category[] value='" + ret + "' style='display:none'>";
	oTd = oTr.insertCell();
	oTd.innerHTML = "<input type='button' value='삭제' onClick='cate_del(this.parentNode.parentNode)' style='cursor:pointer'>";
}

function cate_del(el)
{
	idx = el.rowIndex;
	var obj = document.getElementById('objCategory');
	obj.deleteRow(idx);
}

function open_box(name,isopen)
{
	var mode;
	var isopen = (isopen || document.getElementById('obj_'+name).style.display!="block") ? true : false;
	mode = (isopen) ? "block" : "none";
	document.getElementById('obj_'+name).style.display = document.getElementById('obj2_'+name).style.display = mode;
}

function list_goods(name)
{
	var category = '';
	open_box(name,true);	
	var els = document.forms[0]['selectCategory2'];
	for (i=0;i<els.length;i++){
		if (els[i].value) category = els[i].value;
	}
	var ifrm = eval("ifrm_" + name);
	var goodsnm = eval("document.forms[0].search_" + name + ".value");
	ifrm.location.href = "./coupon/product_list.php?name=" + name + "&category=" + category + "&goodsnm=" + goodsnm;
}

function go_list_goods(name){
	if (event.keyCode==13){
		list_goods(name);
		return false;
	}
}
function view_goods(name)
{
	open_box(name,false);
}

function remove(name,obj)
{
	var tb = document.getElementById('tb_'+name);
	tb.deleteRow(obj.rowIndex);
	react_goods(name);
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

var iciRow, preRow, nameObj;
function spoit(name,obj)
{
	nameObj = name;
	iciRow = obj;
	iciHighlight();
}
function iciHighlight()
{
	if (preRow) preRow.style.backgroundColor = "";
	iciRow.style.backgroundColor = "#FFF4E6";
	preRow = iciRow;
}
//-->	
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">쿠폰만들기</div>
	  <div class="panel-body">
		 쿠폰만들기 고객에게 발급할 쿠폰을 만듭니다.<br />
                  회원직접다운로드쿠폰을 제외한 다른 쿠폰들은 발급받은 회원1명 당 쿠폰사용은 1회로 제한 됩니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>
      <table>
        <tr>
          <td><form method="post" name="couponWriteForm" action="<?=$PHP_SELF;?>" onsubmit="return checkForm(this)">
              <input type="hidden" name="query" value="<?=$mode?>" />
              <input type="hidden" name="menushow" value="<?=$menushow;?>" />
              <input type="hidden" name="theme" value="<?=$theme;?>" />
              <input type="hidden" name="uid"	value="<?=$uid;?>" />
              <table class="table">
                <tr>
                  <td width="100">쿠폰이름</td>
                  <td><input type=text name='cname'0 maxlength=30 value="<?=$list["cname"]?>" required class=line id="cname"></td>
                </tr>
                <tr>
                  <td>쿠폰설명</td>
                  <td><input type=text name='cdesc'0 maxlength=70 value="<?=$list["cdesc"]?>" class=line id="cdesc"></td>
                </tr>
                <tr>
                  <td>쿠폰발급방식</td>
                  <td><input type="radio" name=cpubtype value='1' onclick="chk_cpubtype(this);" <? if($list["cpubtype"] == "1" || $list["cpubtype"] == "") echo "checked";?>>
                    운영자발급 (쿠폰등록 후 쿠폰리스트에서 운영자가 특정회원에게 발급합니다) <br />
                    <input type="radio" name=cpubtype value='2' onclick="chk_cpubtype(this);" <? if($list["cpubtype"] == "2") echo "checked";?>>
                    회원직접다운로드 (상품상세정보에서 회원이 직접 쿠폰을 다운로드받습니다)
                    <table style="border-collapse:collapse;display:none" width=635 id="box_cpubtype2">
                      <tr>
                        <td>이 쿠폰의 총 다운로드 횟수를
                          <input type='text' style='text-align:right' name='cpubdowncnt' size=3 value='<?=$list["cpubdowncnt"]?>' onkeydown='onlyNumber()' maxlength='9' id="cpubdowncnt">
                          회로 제한합니다 (공란으로 두면  무제한) <br />
                          <input type="checkbox" name='cpubapplyall' value='1'   id="cpubapplyall"<? if($list["cpubapplyall"] == "1") echo "checked";?>>
                          쿠폰이 적용된 하나의 상품을 한번에 여러개 주문할 때 쿠폰혜택을 모두 제공합니다<br />
                          (체크안하면 같은 상품을 한번에 여러개 주문시 한개만 쿠폰혜택 제공)&nbsp; <br />
                          <input type="checkbox" name='cpubapplycontinue' value='1' id="cpubapplycontinue"<? if($list["cpubapplycontinue"] == "1") echo "checked";?>>
                          쿠폰을 사용한 후 다음번 주문시에도 같은 상품의 쿠폰다운로드를 허용합니다<br />
                          (체크안하면 다음번 주문시 같은 상품의 쿠폰다운로드 허용안함)&nbsp;
                          </div>
                          <div id='goodsallid2'>
                          <br />
                          허용한다면, 다음번 주문시 같은 상품의 쿠폰 다운로드 횟수를
                          <input type='text' style='text-align:right' name='edncnt' size=3 maxlength=9 value='<?=$list["edncnt"]?>' onkeydown='onlyNumber()'>
                          회로 제한합니다 (공란으로 두면  무제한)</td>
                      </tr>
                    </table>
                    <? if($list["cpubtype"] == "2")  echo "<script>chk_cpubtype(document.couponWriteForm.cpubtype[1]);</script>";?>
                    <br />
                    <input type="radio" name=cpubtype value='3'   onclick="chk_cpubtype(this);" <? if($list["cpubtype"] == "3") echo "checked";?>>
                    회원가입자동발급 (회원가입시 자동발급됩니다) <br />
                    <input type="radio" name=cpubtype value='4'   onclick="chk_cpubtype(this)" <? if($list["cpubtype"] == "4") echo "checked";?>>
                    구매후 자동발급 (구매후 배송완료시에 자동발급됩니다)</td>
                </tr>
                <tr>
                  <td>쿠폰기능</td>
                  <td><input type="radio" name=ctype value='1' onclick='chk_msg(this.value);'<? if($list["ctype"] == "1" || $list["ctype"] == "") echo " checked";?>>
                    할인쿠폰을 발행합니다 (구매시 바로 할인되는 쿠폰)&nbsp;&nbsp;<br />
                    <input type="radio" name=ctype value='2'   onclick='chk_msg(this.value);'<? if($list["ctype"] == "2" ) echo " checked";?>>
                    적립쿠폰을 발행합니다 (구매 후(배송완료) 적립되는 쿠폰) </td>
                </tr>
                <tr>
                  <td>쿠폰금액</td>
                  <td> 총 구매금액 중
                    <input type=text class=line name='csaleprice' size=10 style="text-align:right" maxlength=15 value="<?=$list["csaleprice"]?>" onkeydown='onlyNumber();' id="csaleprice">
                    &nbsp;
                    <select name='csaletype' id="csaletype">
                      <?=$common->getSelectfromArray($csaletypeArr, $list["csaletype"])?>
                    </select>
                    을 할인/적립해주는 쿠폰을 발행합니다</td>
                </tr>
                <tr>
                  <td>쿠폰발급상품</td>
                  <td><table>
                      <tr>
                        <td><input type="radio" name=capplytype value='1'<? if($list["capplytype"] == "1" || $list["capplytype"] == "") echo " checked";?>>
                          전체상품에 발급합니다</td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td><input type="radio" name=capplytype value='2'<? if($list["capplytype"] == "2") echo " checked";?>>
                          특정 상품 및 특정 카테고리에 발급합니다 (아래에서 검색후 선정)</td>
                      </tr>
                      <tr>
                        <td height=5></td>
                      </tr>
                      <tr>
                        <td>카테고리 선정 (카테고리선택 후 오른쪽 선정버튼클릭)<br />
                          <select name="Category1" onChange="getCategory('2', this, 'wizmall', 'Category2');" id="selectCategory">
                            <option value="" selected>대분류 </option>
                            <option value="">----------------</option>
                            <?
$mall->getSelectCategory("1");
?>
                          </select>
                          <select name="Category2" onChange="getCategory('3', this, 'wizmall','Category3');" id="selectCategory">
                            <option value="" selected>중분류</option>
                            <?
if($mode == "qup"){
$mall->getSelectCategory("2");
}
?>
                            <option value="">----------------</option>
                          </select>
                          <select name="Category3" id="selectCategory">
                            <option value="" selected>소분류</option>
                            <?
if($mode == "qup"){
$mall->getSelectCategory("3");
}
?>
                          </select>
                          <input type="button" name="button3" id="button3" value="카테고리선정" onclick="exec_add()" style="cursor:pointer">
                          <div class="box" style="padding:10 0 0 10">
                            <table  cellpadding=8 id=objCategory style="border-collapse:collapse">
                              <?
if(is_array($category)){
	foreach($category as $key => $value){
		if($value){
?>
                              <tr>
                                <td id=currPosition><?=$mall->getCategoryFullPath($value)?></td>
                                <td><input type=text name=category[] value="<?=$value?>" style="display:none"></td>
                                <td><input type='button' value='삭제' onClick='cate_del(this.parentNode.parentNode)' style='cursor:pointer'>
                                </td>
                              </tr>
                              <?
		}//if($value){
	}//foreach($category as $key => $value){
}//if(is_array($category)){
?>
                            </table>
                          </div>
                          상품 선정 (상품검색 후 선정)<br />
                          <select name="Categorystep1" onChange="getCategory('2', this, 'wizmall', 'Categorystep2');" id="selectCategory2">
                            <option value="" selected>대분류 </option>
                            <option value="">----------------</option>
                            <?
$mall->getSelectCategory("1");
?>
                          </select>
                          <select name="Categorystep2" onChange="getCategory('3', this, 'wizmall','Categorystep3');" id="selectCategory2">
                            <option value="" selected>중분류</option>
                            <?
if($mode == "qup"){
$mall->getSelectCategory("2");
}
?>
                            <option value="">----------------</option>
                          </select>
                          <select name="Categorystep3" id="selectCategory2">
                            <option value="" selected>소분류</option>
                            <?
if($mode == "qup"){
$mall->getSelectCategory("3");
}
?>
                          </select>
                          <input type=text name=search_refer onkeydown="return go_list_goods('refer')">
                          <input type="button" name="button4" id="button4" value="검색" onClick="list_goods('refer')" style="cursor:pointer">
                          <input type="button" name="button4" id="button4" value="펼침/닫힘" onclick="view_goods('refer')" style="cursor:pointer">
                          <div id=divRefer style="position:relative;z-index:99;padding-left:8">
                            <div id=obj_refer class=box1>
                              <iframe id=ifrm_refer style="width:100%;height:100%" frameborder=0></iframe>
                            </div>
                            <div id=obj2_refer class="box2 scroll" onselectstart="return false" onmousewheel="return iciScroll(this)">
                              <div class=boxTitle>- 등록된 상품 (삭제하려면 더블클릭)</div>
                              <table id="tb_refer" class=tb>
                                <col>
                                <?
if(is_array($e_refer)){
	foreach($e_refer as $key => $value){
		if($value){
			$sublist = $mall->getProductInfo($value);
			$pimg = explode("|", $sublist["Picture"]);
			$imgpath = "../config/uploadfolder/productimg/".substr($sublist["Category"], -2)."/".$pimg[0];
?>
                                <tr onclick="spoit('refer',this)" ondblclick=remove('refer',this) class=hand>
                                  <td nowrap><a href="../wizmart.php?query=view&code=<?=$sublist["Category"]?>&no=<?=$value?>" target=_blank><img src='<?=$imgpath?>' width=40 onerror=this.src='../images/common/noimg_100x100.gif'></a></td>
                                  <td%><div>
                                      <?=$sublist["Name"];?>
                                    </div>
                                    
                                    <?=number_format($sublist["Price"]);?>
                                    
                                    <input type="hidden" name=e_refer[] value="<?=$value;?>">
                                  </td>
                                </tr>
                                <?
		}//if($value){
	}//foreach($e_refer as $key => $value){
}//if(is_array($e_refer)){
?>
                              </table>
                            </div>
                            <div id=referX style="font:0"></div>
                          </div>
                          <div>
                            <script>react_goods('refer');</script>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td>쿠폰이미지</td>
                  <td><table>
                      <tr>
                        <td><img src="../../data/skin/easy/img/common/coupon01.gif">
                          <input type="radio"  name=cimg value=1<? if($list["cimg"] == "1" || $list["cimg"] == "") echo " checked";?>>
                        </td>
                        <td width=5></td>
                        <td><img src="../../data/skin/easy/img/common/coupon02.gif">
                          <input type="radio"  name=cimg value=2<? if($list["cimg"] == "2") echo " checked";?>>
                        </td>
                        <td width=5></td>
                        <td><img src="../../data/skin/easy/img/common/coupon03.gif">
                          <input type="radio"  name=cimg value=3<? if($list["cimg"] == "3") echo " checked";?>>
                        </td>
                        <td width=5></td>
                        <td><img src="../../data/skin/easy/img/common/coupon04.gif">
                          <input type="radio"  name=cimg value=4<? if($list["cimg"] == "4") echo " checked";?>>
                        </td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td>적용기간</td>
                  <td><input type="radio"  name=ctermtype value=1 onclick="javascript:chk_ctermtype(this)"<? if($list["ctermtype"] == "1" || $list["ctermtype"] == "") echo " checked";?>>
                    시작일, 종료일 선택&nbsp;&nbsp; <br />
                    <input type="radio"  name=ctermtype value=2  onclick="javascript:chk_ctermtype(this)"<? if($list["ctermtype"] == "2") echo " checked";?>>
                    발급일로부터 기간 제한<br />
                    <span id="ctermtype1" style="display:block">
                    <?      
      $common->getSelectDate($list["ctermf"]);//시간 실렉트 관련 정의
?>
                    <input name="ctermf_date" type="text" id="ctermf_date" value="<? if($list["ctermf"]) echo date("Y.m.d", $list["ctermf"])?>" size="9" readonly="readonly">
                    <select name="ctermfhour" id="ctermfhour">
                      <option value="">시간</option>
                      <? echo $common->rtn_hour;?>
                    </select>
                    <select name="ctermfmin" id="ctermfmin">
                      <option value="">분</option>
                      <? echo $common->rtn_min;?>
                    </select>
                    <a href="javascript:ShowCalendar('all.ctermf_date')"><img src="./img_Calendar/cal.gif"></a> -
                    <?      
      $common->getSelectDate($list["cterme"]);//시간 실렉트 관련 정의
?>
                    <input name="cterme_date" type="text" id="cterme_date" value="<? if($list["cterme"]) echo date("Y.m.d", $list["cterme"])?>" size="9" readonly="readonly">
                    <select name="ctermehour" id="ctermehour">
                      <option value="">시간</option>
                      <? echo $common->rtn_hour;?>
                    </select>
                    <select name="ctermemin" id="select4">
                      <option value="">분</option>
                      <? echo $common->rtn_min;?>
                    </select>
                    <a href="javascript:ShowCalendar('all.cterme_date')"><img src="./img_Calendar/cal.gif" /></a></span> <span id="ctermtype2" style="display:none"> &nbsp; 쿠폰발급일로부터
                    <input type=text name=cterm value="<?=$list["cterm"]?>" size=5 maxlength=3 onkeydown='onlyNumber()'>
                    일까지 사용기간을 제한합니다. </span>
                    <? if($list["ctermtype"] == "2")  echo "<script>chk_ctermtype(document.couponWriteForm.ctermtype[1]);</script>";?></td>
                </tr>
                <tr>
                  <td>쿠폰사용제한</td>
                  <td><input type=text name=crestric size=10 style="text-align:right" maxlength=10 value="<?=$list["crestric"]?>" class=line id="crestric">
                    원 이상 구매시에만 사용가능 (공란으로 두면 구매금액에 상관없이 사용이 가능합니다)</td>
                </tr>
              </table>
              <input type="submit" name="Submit" id="button" value="등록" />
              <input type="button" name="button2" id="button2" value="취소" />
            </form></td>
        </tr>
      </table>
      <br />
       </td>
  </tr>
</table>
