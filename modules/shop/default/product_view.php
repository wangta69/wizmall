<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

$view = $mall->getview($_GET["no"]);
?>
<script>
$(function(){
	$(".btn_save_cart").click(function(){
		$("#view_form").submit();
	});
});

function num_plus(num){
	gnum = parseInt(num.BUYNUM.value);
	num.BUYNUM.value = gnum + 1;
	return;
}
function num_minus(num){
	gnum = parseInt(num.BUYNUM.value);
if( gnum > 1 ){
	num.BUYNUM.value = gnum - 1;
	}	
	return;
}

function wishreally(){
if (confirm('\n\n정말로 본 제품을 위시리스트에 담으시겠습니까?\n\n')) return true;
return false;
}


function baropay(){
	var f=document.view_form;

	if(autoCheckForm(f)){
		f.sub_query.value = "baro";
		f.submit();
	}
}

function checkForm(f){
	if(autoCheckForm(f)) return true;
	else return false;
}

function checkthis(v){

	var i,currEl,splitvalue,commanewprice;
	var f = eval("document."+v.form.name);
	var currPrice = parseInt(f.GoodsPrice.value);
	var newprice = 0;
	
	
    for(i = 0; i < f.elements.length; i++){ 
		currEl = f.elements[i]; 
		if (currEl.getAttribute("oflag") != null) { 
			if(currEl.value){
				if(currEl.oflag == "1"){//가격추가
					splitvalue = currEl.value.split('|');
					newprice += parseInt(splitvalue[1]);
				}else if(currEl.oflag == "1"){//상품가격변경
					currPrice = parseInt(splitvalue[1]);
				}
			}
		}
	}
	
	newprice = currPrice + newprice; 
	commanewprice = SetComma1(newprice);	
	if (document.layers) { 
		document.layers.item_price.document.write(commanewprice); 
		document.layers.item_price.document.close(); 
	}else if (document.all) item_price.innerHTML = commanewprice;	
}


function getBigPicture(no){
	wizwindow('./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/picview.php?no='+no, 'BICIMAGEWINDOW','width=750,height=592,statusbar=no,scrollbars=no,toolbar=no,resizable=no')
}
//-->
</script>

<?php echo $mall->getNavy($code);//상단 navy 가져오기?>

<div class="row">
	
<form name='view_form' id="view_form" action='./wizbag.php' method="post" onsubmit='return checkForm(this);'>
	<input type="hidden" name="query" VALUE="cart_save">
	<input type="hidden" name="no" VALUE="<?=$no?>">
	<input type="hidden" name="source_id" VALUE="<?=$view["source_id"]?>">
	<input type="hidden" name="sub_query" VALUE= "">
	<input type="hidden" name="op" VALUE= "<?=$op?>">
	<div class="col-lg-5">
		<a href="javascript:getBigPicture(<?=$view["source_id"]?>)"><img src="<?=$view["imgsrc"]?>" width="100%" class="img-thumbnail"/></a>
		<div class="agn_c">
			<a href="javascript:getBigPicture(<?=$view["source_id"]?>)"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/but_zoom.gif" width="83"></a>
		</div>
	</div>
	<div class="col-lg-7">
		<span class="b orange">
			<?=$view[Name]?>
			<? if($view[Model]) echo "(".$view[Model].")"; ?>
			<?=$mall->ShowOptionIcon($cfg["skin"]["ShopIconSkin"], $view["Regoption"]);?>
		</span>
		<table class="table table-striped table-hover">
			<col width="120" />
			<col width="*" />
			<tr>
				<th class="agn_l">가격</th>
				<td> :
					<?=number_format($view["Price"])?>
					원
					<input type='hidden' name='GoodsPrice' value='<? echo $view[Price]; ?>'></td>
			</tr>
			<?if($view["Price1"]):?>
			<tr>
				<th class="agn_l">시중가격</th>
				<td> :
					<?=number_format($view["Price1"])?>
					원</td>
			</tr>
			<?endif;?>
			<?if($view["Brand"]):?>
			<tr>
				<th class="agn_l">브랜드</th>
				<td> :
					<?=$view["Brand"]?></td>
			</tr>
			<? endif;?>
			<?if($view["Point"]):?>
			<tr>
				<th class="agn_l">적립포인트</th>
				<td> :
					<?=number_format($view["Point"])?></td>
			</tr>
			<? endif;?>
			<?if($view["CompName"]):?>
			<tr>
				<th class="agn_l">제조사/원산지</th>
				<td> :
					<?=$view["CompName"]?></td>
			</tr>
					<? endif;?>
					<? //옵션설정값 디스플레이
$substr = "select * from wizMalloptioncfg where opid = '$no' order by oorder asc";
$qry = $dbcon->_query($substr);
while($sublist = $dbcon->_fetch_array($qry)):
	$oname	= $sublist["oname"];
	$oflag	= $sublist["oflag"];
	$ouid = $sublist["uid"];
	
	//옵션값갯수구하기
	$substr1 = "select count(1) from wizMalloption where ouid = '$ouid'";
	$valuecnt = $dbcon->get_one($substr1);
	if($valuecnt > 0 ){
?>
					<tr>
						<th class="agn_l"><?=$oname?></th>
						<td> :
<?php
	if($valuecnt == "1"){//옵션등록갯수가 하나이면 일반 텍스트 디스플레이
		echo $oname;
	}else{//실렉트 박스 출력
		//$checkstr = $oflag == "0"?" checkenable msg='".$oname."를 선택해 주세요'":"";
		$checkstr = $oflag == "0"?" checkenable msg='".$oname."를 선택해 주세요'":"";
?>
							<select name="optionfield[<?=$ouid?>]" class="formline" <?=$checkstr?> oflag="<?=$oflag;?>" onchange="checkthis(this)">
								<option value=''>
								<?=$oname?>
								선택</option>
<?php
		$substr1 = "select uid, oname, oprice from wizMalloption where ouid = '$ouid' order by uid asc";
		$subqry1 = $dbcon->_query($substr1);
		$subcnt=0;
		while($sublist1 = $dbcon->_fetch_array()):
			$uid = $sublist1["uid"];
			$oname = $sublist1["oname"];
			$oprice = $sublist1["oprice"];
			if($oprice) $displayoprice = "(".$oprice.")";
			echo "<option value='".$uid."|".$oprice."'>".$oname.$displayoprice."</option>\n";
		endwhile;
?>
							</select>
							<?
		}//if($valuecnt == "1"){}else{
?>
						</td>
					</tr>
					<? 

	}//if($valuecnt > 0 ){
endwhile;//while($sublist = $dbcon->_fetch_array($subqry)):
?>
					<tr>
						<th class="agn_l">주문수량</th>
						<td>
						<ul class="pd_cnt">
							<li><input type="text" name="BUYNUM" maxlength=5 value="1" onKeyPress="onlyNumber()" class="w30"></li>
							<li style="padding:0px;"><ul style="padding-left:5px;">
								<li><a href="javascript:num_plus(document.view_form);"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/num_plus.gif"></a></li>
								<li><a href="javascript:num_minus(document.view_form);"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/num_minus.gif"></a></li>
							</ul></li>
							<li>EA</li>
						</ul>
						</td>
					</tr>
<!--
					<tr>
						<th class="agn_l">결제금액</th>
						<td>
							<span id=""></span>
						</td>
					</tr>
-->
				</table>
				<div class="btn_box">
					<span class="btn_save_cart button bull"><a>쇼핑백에 넣기</a></span>
					
					<span class="button bull"><a href="javascript:baropay();">바로구매</a></span>
					
					<span class="button bull"><a href="<?=$pre_dir?>">리스트</a></span>
					<?if ($cfg["member"]):?>
					<span class="button bull"><a href='./skinwiz/wizwish/index.php?uid=<?=$view[UID];?>' onclick='return wishconfirm();'>상품찜</a></span>
					<? else:?>
					<span class="button bull"><a href='#' onclick="javascript:alert('로그인후 이용해 주세요.')">상품찜</a></span>
					<? endif;?>
				</div>
		</div><!--  class="col-lg-7"-->
	</form>
</div><!--  class="row"-->



<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">상품상세정보</h3>
	</div>
	<div class="panel-body">
		<?=$view["Description1"]?>
	</div>
</div>



<?php if($view[Description3]) :?>
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">배송관련정보</h3>
	</div>
	<div class="panel-body">
		<?=$view["Description3"]?>
	</div>
</div>
<?php endif;?>

<?php if($cfg["skin"]["GoodsDisplayPid"] == "checked" && $view[PID]) :?>
<!-- 인기 판매 제품 시작 -->
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">인기 판매 제품</h3>
	</div>
	<div class="panel-body">
		<table>
			<tr>
<?php
		$cnt=0;
		$SimilarPdArr = explode("|",$view[SimilarPd]);
		//echo $view[SimilarPd];
		while(list($key, $value) = each($SimilarPdArr)):
			if(trim($value)):
			
				$substr="SELECT m1.UID, m1.PID, m1.Category, m1.Picture, m1.None, m1.Regoption, m1.Model, m1.Name, m1.Price, m1.Price1,
				m2.Category as pcategory 
				FROM wizMall m1
				left join wizMall m2
				on m1.PID = m2.UID
				WHERE m1.UID = '$value'";
					
				$subqry=$dbcon->_query($substr);
				$sublist=$dbcon->_fetch_array($subqry);
				$Picture = explode("|", $sublist[Picture]);
				$UID		= $sublist["UID"];
				$PID		= $sublist["PID"];
				$Category	= $sublist["Category"];
				$None		= $sublist["None"];
				$Regoption	= $sublist["Regoption"];
				$Model		= $sublist["Model"];
				$Name		= $sublist["Name"];
				$Price		= $sublist["Price"];
				$Price		= $sublist["Price	"];
			
				$img_folder = substr($Category, -3);
				$img_path = "./config/uploadfolder/productimg/$img_folder/".$Picture[0];
				$View_Pic_Size = $common->TrimImageSize($img_path, 110);
				//if ($cnt <> 0) echo " <td bgcolor='#E6E6E6'></td>";
?>
				<td><table>
						<tr>
							<td><a href="<?=$mall->pdviewlink($UID,$Category,$None)?>"><img src="<?=$img_path?>" <?=$View_Pic_Size?>></a></td>
						</tr>
						<tr>
							<td><?=$sublist[Name]?>
								<br />
								<?=$sublist[Model]?>
								<br />
								<?=number_format($sublist[Price])?>
								원</td>
						</tr>
					</table></td>
<?php
				$cnt++;
				if(!($cnt%4)) echo "</tr><tr align='center'>";
			endif;//if(trim($value)):
		endwhile;
		
		$tmpcnt = $cnt%4;
		if($tmpcnt){
			for($i=$tmpcnt; $i<4; $i++){
				echo "<td width='190' valign='top'></td>";
			}
		}
?>
			</tr>
		</table>
	</div>
</div>



<!-- 인기 판매 제품 끝 -->
<?php endif;?>

<?php if($cfg["skin"]["GoodsDisplayEstim"] == "checked"):?>
<!-- 상품 평가 시작 -->

<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">상품평 보기 | 고객님에게 꼭 맞는 상품 구입을 위한 유용한 자료로 사용하세요! <span class="button bull"><a href="javascript:wizwindow('./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/estimatepopup.php?query=<?=$query?>&code=<?=$code?>&no=<?=$no?>&GID=<?=$view["source_id"]?>','','width=554,height=450')">상품평쓰기</a></span></h3>
	</div>
	<div class="panel-body">
		<form name="estimat" action="<?=$PHP_SELF?>" onsubmit='return check_reple_Form();'>
	<input type="hidden" name="query" value="<?=$query?>">
	<input type="hidden" name="code" value="<?=$code?>">
	<input type="hidden" name="no" value="<?=$view["source_id"]?>">
	<input type="hidden" name="repleqry" value="insert">
	<input type="hidden" name="Name" value="<?=$cfg["member"]["mname"]?>">
	<input type="hidden" name="repleuid" value="">
	<input type="hidden" name="op" VALUE= "<?=$op?>">
	<!--<? if($cfg["member"]):?>
                                <input name="image2" type="image" src="img/main/btn_sub.gif" width="51" height="21"> 
                                <? else: ?>
                                <a href="javascript:window.alert('로그인후 사용가능합니다.')"><img src="img/main/btn_sub.gif" width="51" height="21"></a> 
                                <? endif;?>-->
</form>
<?php
    
$sqlstr = "select * from wizEvalu where GID = '".$view["source_id"]."' ORDER BY Wdate desc";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
$list[Contents] = nl2br($list[Contents]);
$list[Contents] = stripslashes($list[Contents]);
$list[Subject] = stripslashes($list[Subject]);
?>
<table class="table table-striped table-hover">
	<tr>
		<th>글쓴이</th>
		<td><?=$list[Name]?>
			<? if($cfg["member"] == $list[ID]):?>
			&nbsp;&nbsp;&nbsp;<a href="javascript:reple_delete('<?=$list[UID]?>');" >x</a>
			<?endif;?></td>
		<th>고객선호도 </th>
		<td><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/star<?=$list[Grade]?>.gif"></td>
	</tr>
	<tr>
		<td colspan="4"><?=$list[Subject]?></td>
	</tr>
	<tr>
		<td colspan="4" style="word-break:break-all;"><?=$list[Contents]?>
		</td>
	</tr>
</table>
<?
endwhile;
?>
<table>
	<tr>
		<td>≡ </td>
		<td>상품평은 개인의 체험을 바탕으로 한 주관적인 의견으로 사실과 다르거나,보는 사람에 따라 
			차이가 있을 수 있습니다.</td>
	</tr>
</table>
<!-- 상품 평가 끝 -->
<?endif;?>
	</div>
</div>
<script language="JavaScript">
<!--
function check_reple_Form(){
	var f=document.estimat;
	if(f.Name.value == ''){
		alert('성함을 입력해주세요');
		f.Name.focus();
		return false;
	} else if(f.Contents.value == ''){
		alert('상품사용후기를 입력해주세요');
		f.Contents.focus();
		return false;
	}
}

function reple_delete(uid){
var f=document.estimat;
	f.repleqry.value = "insert";
	f.mode.value = "";
	f.repleuid.value = uid;
	f.submit();

}
//-->
</script>

