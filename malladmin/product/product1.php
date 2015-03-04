<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

## html 편집기 사용시 현재 폴더에 임시 폴더를 넣어둔다.

$htmleditimgfolder=session_id();
if($common->checsrfkey($csrf)){//csrf 처리
	if ($query == 'qde') {   //이미지 택일 삭제옵션시 실행	
		$admin->pd_img_delete($uid, $idx);
		$common->js_location($PHP_SELF."?menushow=".$menushow."&theme=".$theme."&mode=".$mode."&uid=".$uid."&cp=".$cp);
	}else if ($query == 'qin' || $query == 'qup') {//Insert 실행
	//echo "<script>alert('".$Description1."')</script>";
			//exit;
			
			
		include "../lib/class.image.php";
		$Image = new Image();//이미지 클라스 사용
		$common->Image($Image);
	
		$Name = addslashes(chop($Name));
		$Model = addslashes(chop($Model));
	
		
		if($Category3) $Category = $Category3;
		else if($Category2) $Category = $Category2;
		else if($Category1) $Category = $Category1;
		else $common->js_alert("카테고리가 설정되지 않았습니다.");
		
		$des_type1 = $des_type1 ? $des_type1 : 0;//Description1 텍스트 타입0:html 미적용, 1:html적용
		$des_type2 = $des_type2 ? $des_type2 : 0;
		$des_type3 = $des_type3 ? $des_type3 : 0;
		$TextType = $des_type1."|".$des_type2."|".$des_type3;
			//echo "<script>alert('".$Description1."')</script>";
		$Description1=$common->puttrimstr($Description1, $des_type1);
		$Description2=$common->puttrimstr($Description2, $des_type2);
		$Description3=$common->puttrimstr($Description3, $des_type3);
	
		$m_opflag	= $diffprice ? $diffprice : $cobuy;
		
	
	
		## 등록 옵션 입력하기 
		$Regoption	= "|";
		if(is_array($Multi_Regoption)){
			foreach($Multi_Regoption as $key=>$val){
				$Regoption .= $val."|";
			}
		}
	
	
		if($query == "qin"){
			
			$Date = time();
			## 상품이미지 올리기
			if($watermark){
				$admin->watermark = $watermark;//워트마크 생성여부 
				if($watermark == "text"){
					$admin->watermark_text = $watermark_text;
					$admin->watermark_font = "arial.ttf";
				}else if($watermark == "img"){
					$admin->watermark_img = $watermark_img;
				}
			}
			$rtnfile = $admin->pd_img_up("insert", "file", $Category, $copyimg);
	
			## PID를 구한다.
			$MaxUID = $dbcon->get_one("select max(UID) from wizMall");
			if(!$MaxUID) $uid = 1; else $uid = $MaxUID+1;
			
			## html편집기에서 이미지가 첨부되었을 경우 경로수정 및 파일 이동
			$Description1 = $admin->htmleditorImg($Description1, $uid);
			$source	= "../config/tmp_upload/".session_id();
			$common->RemoveFiles($source);
			
			##  쿼리문 시작
			unset($ins);
            $ins["UID"]         = $uid;
            $ins["PID"]         = $uid;
            $ins["Name"]        = $Name;
            $ins["Brand"]       = $Brand;
            $ins["CompName"]    = $CompName;
            $ins["Price"]    = $Price;
            $ins["Price1"]    = $Price1;
            $ins["WongaPrice"]    = $WongaPrice;
            $ins["Point"]    = $Point;
            $ins["Unit"]    = $Unit;
            $ins["Model"]    = $Model;
            $ins["Regoption"]    = $Regoption;
            $ins["SimilarPd"]    = $SimilarPd;
            $ins["Picture"]    = $rtnfile[1];
            $ins["None"]    = $None;
            $ins["Output"]    = $Output;
            $ins["Stock"]    = $Stock;
            $ins["Date"]    = $Date;
            $ins["Description1"]    = $Description1;
            $ins["Description2"]    = $Description2;
            $ins["Description3"]    = $Description3;
            $ins["Category"]    = $Category;
            $ins["TextType"]    = $TextType;
            $ins["Hit"]    = $Hit;
            $ins["GetComp"]    = $GetComp;
            $ins["opflag"]    = $m_opflag;
            $ins["Name"]    = $Name;
            
            $dbcon->insertData("wizMall", $ins);  


			$mall->insertPdCnt($Category);##카테고리별 상품갯수 입력
			
			$admin->MultiInsert($uid, $TmpMultiCategoryvalue);//다중카테고리 입력
		
			$admin->input_mallext($uid, $_POST);//확장 필드 입력
	
			$admin->input_imgtable($uid, $rtnfile);//이미지 테이블에 이미지 명 입력
	
			
		## 재고수량이 기입되었을 경우 재고수량을 입력한다.
			if($Stock){
			    unset($ins);
                $ins["Icomid"]    = $Icomid;
                $ins["Igoodscode"]    = $uid;
                $ins["Iinputqty"]    = $Stock;
                $ins["Iinputdate"]    = $Iinputdate;
                $dbcon->insertData("wizInputer", $ins); 
			}
			
		
		## 등록 옵션 입력하기
			if($optioncnt){
				$oorder=0;
				foreach($opname as $key=> $value){
					$ropflag = $opflag[$key];
					
                    unset($ins);
                    $ins["opid"]    = $uid;
                    $ins["oname"]    = $value;
                    $ins["oorder"]    = $oorder;
                    $ins["oflag"]    = $ropflag;
                    $dbcon->insertData("wizMalloptioncfg", $ins); 

					$ouid = $dbcon->_insert_id();
					$oorder++;
					
					if($opcnt[$key]){
						foreach($optioneachname[$key] as $key1=>$value1){
							$roprice = $optioneachprice[$key][$key1];
							$roqty = $optioneachqty[$key][$key1];
                            unset($ins);
                            $ins["ouid"]    = $ouid;
                            $ins["oname"]    = $value1;
                            $ins["oprice"]    = $roprice;
                            $ins["oqty"]    = $roqty;
                            $dbcon->insertData("wizMalloption", $ins); 
						}			
					}
				}
			}
	
	
			
			## 공동구매등록
			if($cobuy == "c"){
				$c_sdate = mktime(0,0,0, $SMonth, $SDay, $SYear);
				$c_fdate = mktime(0,0,0, $FMonth, $FDay, $FYear);
				$admin->coorbuy("insert", $uid, $c_sdate, $c_fdate, $c_price, $c_qty);
			}
	
			## 차등가격 입력
			$admin->diffprice($uid, $diffQtyArr, $diffPriceArr);
	
			$common->js_confirm("동종 상품 추가등록을 하시겠습니까?", "history.go(-1)", $PHP_SELF."?menushow=".$menushow."&theme=".$theme."&Category=".$Category);
		}else if ($query == 'qup') {//update 실행
			
			## html편집기에서 이미지가 첨부되었을 경우 경로수정 및 파일 이동
			$Description1 = $admin->htmleditorImg($Description1, $uid);
			$source	= "../config/tmp_upload/".session_id();
			$common->RemoveFiles($source);
	
			## 상품이미지 올리기
			$rtnfile = $admin->pd_img_up("update", "file", $Category, $copyimg, $c_category, $uid);
	
			/* omit 된 내용 : Output = '$Output', Stock = '$Stock',*/
			unset($ups);
            $ups["PID"]             = $uid;
            $ups["Name"]            = $Name;
            $ups["Brand"]           = $Brand;
            $ups["CompName"]        = $CompName;
            $ups["Price"]           = $Price;
            $ups["Price1"]          = $Price1;
            $ups["WongaPrice"]      = $WongaPrice;
            $ups["Point"]           = $Point;
            $ups["Unit"]            = $Unit;
            $ups["Model"]           = $Model;
            $ups["Regoption"]       = $Regoption;
            $ups["SimilarPd"]       = $SimilarPd;
            $ups["Picture"]         = $rtnfile[1];
            $ups["None"]            = $None;
            $ups["Description1"]    = $Description1;
            $ups["Description2"]    = $Description2;
            $ups["Description3"]    = $Description3;
            $ups["Category"]        = $Category;
            $ups["TextType"]        = $TextType;
            $ups["Hit"]             = $Hit;
            $ups["GetComp"]         = $GetComp;
            $ups["opflag"]          = $m_opflag;
            
            $dbcon->updateData("wizMall", $ups, "UID=".$uid);

			
			$admin->input_mallext($uid, $_POST);//확장 필드 입력
		
			
			$mall->insertPdCnt($c_category, "delete");##카테고리별 상품갯수 삭제
			$mall->insertPdCnt($Category);##카테고리별 상품갯수 입력
			
			$admin->MultiInsert($uid, $TmpMultiCategoryvalue);## 다중카테고리 입력
		
            unset($ups);
            $ups["Iinputprice"]    = $Iinputprice;
            $ups["Iunit"]    = $Iunit;
            $ups["Icomid"]    = $GetComp;
            $dbcon->updateData("wizInputer", $ups, "Igoodscode=".$uid);
		
			$admin->input_imgtable($uid, $rtnfile);//이미지 테이블에 이미지 명 입력
			
			##삭제되는 값의 존재 여부 확인이 어려우므로 모두 삭제하고 새로 입력한다.
			$sqlstr = "select uid from wizMalloptioncfg where opid = ".$uid;
			$qry=$dbcon->_query($sqlstr);
			while($list = $dbcon->_fetch_array($qry)):
				$ouid = $list["uid"];
                $dbcon->deleteData("wizMalloption", "ouid = ".$ouid);

			endwhile;
            $dbcon->deleteData("wizMalloptioncfg", "opid = ".$uid);
	
			## 옵션 명이 있을 경우 옵션입력을 시작한다.
			if(is_array($opname)){
				$oorder=0;
				foreach($opname as $key=> $value){
					$ropflag = $opflag[$key];
                    unset($ins);
                    $ins["opid"]    = $uid;
                    $ins["oname"]    = $value;
                    $ins["oorder"]    = $oorder;
                    $ins["oflag"]    = $ropflag;
                    $dbcon->insertData("wizMalloptioncfg", $ins);

					$ouid = mysql_insert_id();
					$oorder++;
					

					if(is_array($optioneachname[$key])){
						foreach($optioneachname[$key] as $key1=>$value1){
								//echo "key1 : $key1 , value1:$value1 <br />";
							$roprice = $optioneachprice[$key][$key1];
							$roqty = $optioneachqty[$key][$key1];
                            unset($ins);
                            $ins["ouid"]    = $ouid;
                            $ins["oname"]    = $value1;
                            $ins["oprice"]    = $roprice;
                            $ins["oqty"]    = $roqty;
                            $dbcon->insertData("wizMalloption", $ins);
						}			
					}
				}
					//exit;
			}
						
			## 공동구매등록
			if($cobuy == "c"){
				$c_sdate = mktime(0,0,0, $SMonth, $SDay, $SYear);
				$c_fdate = mktime(0,0,0, $FMonth, $FDay, $FYear);
				$admin->coorbuy("update", $uid, $c_sdate, $c_fdate, $c_price, $c_qty);
			}
	
			## 차등가격 입력
			$admin->diffprice($uid, $diffQtyArr, $diffPriceArr);
			
			if ($back == 'none') {  //이부분은 품절상품관리 화면으로 넘어갈때 사용
				echo "<html>
				<META http-equiv=\"refresh\" content =\"0;url=".$PHP_SELF."?menushow=".$menushow."&theme=product/product4\">
				</html>";
				exit;
			}else{// 아래는 걍 제품수정에서 넘어갈때입니다.
				echo "<html>
				<META http-equiv=\"refresh\" content =\"0;url=".$PHP_SELF."?menushow=".$menushow."&theme=product/product2&cp=".$cp."&category=".$s_category."&where=".$where."&keyword=".$keyword."&OPTI_LIST=".$OPTI_LIST."&sort=".$sort."&sort1=".$sort1."&sort2=".$sort2."&sorting=".$sorting."\">
				</html>";
				exit;
			}	
		}  
	}
}

if ($uid) { ## 상품 목록을 wizMall Table에서 가져옮
	$sqlstr = "SELECT m.*,c.PriceQty,c.SDate,c.FDate FROM wizMall m left join wizcoorbuy c on m.UID=c.PID WHERE m.UID=".$uid;
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	$list["Name"]			= stripslashes($list["Name"]);
	$list["CompName"]		= stripslashes($list["CompName"]);
	$list["Description1"]	= stripslashes($list["Description1"]);
	$list["Description2"]	= stripslashes($list["Description2"]);
	$list["Description3"]	= stripslashes($list["Description3"]);
	$list["Model"]		= stripslashes($list["Model"]);
	$Picture			= explode("|",$list["Picture"]); 
	$imgFolder			= substr($list["Category"], -3);
	$SimilarPd			= explode("|",$list["SimilarPd"]); 
	$des_type			= explode("|", $list["TextType"]);
	$des_type1			= $des_type[0];
	$des_type2			= $des_type[1];
	$des_type3			= $des_type[2];
	
	## 공동구매 관련 정보
	$priceQty			= explode("||", $list["PriceQty"]);
	foreach($priceQty as $key=>$value){
		$p_qty[$key]	= explode(":", $value);
	}
	$SDate				= $list["SDate"];
	$FDate				= $list["FDate"];	
	
	## 상품재고 및 기타 상품 공급처에 관한 정보를 가져옮
	$inputsqlstr = "select Iinputprice, Iunit from wizInputer where Igoodscode=".$uid;
	$inputsqlqry = $dbcon->_query($inputsqlstr);
	$inputlist = $dbcon->_fetch_array($inputsqlqry);
	
	## 기타이미지 가지고 옮
	## max key 값 가져오기
	$sqlstr = "select max(orderid) from wizMall_img where pid = ".$uid."  and opflag= 'm' order by orderid asc";
	$max_value = $dbcon->get_one($sqlstr);

	$sqlstr = "select filename, orderid from wizMall_img where pid = ".$uid." order by orderid asc";
	$dbcon->_query($sqlstr);
	while($imglist = $dbcon->_fetch_array()):
		$filename = $imglist["filename"];
		$orderid = $imglist["orderid"];
		$fileimg[$orderid] = $filename;
	endwhile;

	## 차등가격에 대한 정보를 가져옮
	$sqlstr = "select qty, price from wizMallDiffPrice where pid = ".$uid." order by uid asc";
	$diffPrice = $dbcon->get_rows($sqlstr);
	$mode = "qup";
}else{
	$mode = "qin";
}
?>
<script language="javascript" src="../js/jquery.plugins/selectboxes.js"></script>
<script type="text/javascript" src="../js/Smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
    var _menushow   = "<?php echo $menushow?>";
    var _theme   = "<?php echo $theme?>";
    var _self       = "<?php echo $PHP_SELF?>";
</script>
<script type="text/javascript" src="../js/product.js" charset="utf-8"></script>



<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">제품등록</div>
	  <div class="panel-body">
		 제품을 카테고리에 맞게 분류하여 등록하십시오.<br />
				등록카테고리를 지정하실 때에는 가장 하위 카테고리에 등록해 주시기 바랍니다. <br />
				스킨마다 약간식의 적용 옵션이 달라 질 수 도 있습니다.
	  </div>
	</div>
	
	
			<form  action='<?php echo $PHP_SELF?>' method='post' name="writeForm" enctype='multipart/form-data' onsubmit='return checkForm(this);'>
				<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey()?>">
				<input type="hidden" name='query' value='<?php echo $mode;?>'>
				<input type="hidden" name="menushow" value="<?php echo $menushow?>">
				<input type="hidden" name="theme" value=<?php echo $theme?>>
				<input type="hidden" name="SimilarPd">
				<input type="hidden" name='uid' value='<?php echo $uid?>'>
				<input type="hidden" name='back' value='<?php echo $back?>'>
				<!-- 아래는 수정모드에서 넘어온 조건(분류라던지 검색조건)을 다시 한번 보내준다 -->
				<input type="hidden" name='where' value='<?php echo $where?>'>
				<input type="hidden" name='keyword' value='<?php echo $keyword?>'>
				<input type="hidden" name='OPTI_LIST' value='<?php echo $OPTI_LIST?>'>
				<input type="hidden" name='sort' value='<?php echo $sort?>'>
				<input type="hidden" name='sort1' value='<?php echo $sort1?>'>
				<input type="hidden" name='sort2' value='<?php echo $sort2?>' />
				<input type="hidden" name='sorting' value='<?php echo $sorting?>'>
				<input type="hidden" name='s_category' value='<?php echo $category?>'>
				<input type="hidden" name='cp' value='<?php echo $cp?>'>
				<input type="hidden" name='c_category' value='<?php echo $list["Category"]?>'>
				<input type="hidden" name='htmleditimgfolder' value='<?php echo $htmleditimgfolder?>'>
				<!-- 다중카테고리용으로 히든 값을 보낸다. 5개 이상 보내고 싶을 경우 이 부분의 hindden 값을 조정 -->
				<input type="hidden" id="TmpMultiCategoryvalue" name='TmpMultiCategoryvalue' value=''>
				<table class="table table-hover">
				<col width="120px" />
				<col width="*" />
					<tr>
						<th class="active">등록카테고리</th>
						<td><select name="Category1" id="Category1" onchange="getCategory(this, 1);">
								<option value="" selected>대분류 </option>
								<option value="">----------------</option>
<?php
$mall->getSelectCategory("1", $list["Category"]);
?>
							</select>
							<select name="Category2" id="Category2" onchange="getCategory(this, 2);">
								<option value="" selected>중분류</option>
								<option value="">----------------</option>
<?php
if($mode == "qup"){
$mall->getSelectCategory("2", $list["Category"]);
}
?>
							</select>
							<select name="Category3" id="Category3">
								<option value="" selected>소분류</option>
								<option value="">----------------</option>
<?php
if($mode == "qup"){
$mall->getSelectCategory("3", $list["Category"]);
}
?>
							</select>
							(등록카테고리가 없을시 카테고리를 <a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=catmanager/shopmanager1">등록</a> 하세요)</td>
					</tr>
					<tr>
						<th class="active">다중카테고리</th>
						<td><table>
								<tr>
									<td><select style="width: 270px" name="" onchange="MultiCategorySelect(this)">
											<option value=''>상품등록 카테고리 선택</option>
											<option value=''>--------------------------------------</option>
<?php
$substr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 3 and cat_flag = 'wizmall' ORDER BY cat_order ASC";
$subqry = $dbcon->_query($substr);
while($sublist=@$dbcon->_fetch_array($subqry)):
	if($sublist["cat_no"]==$list["Category"]) echo "<option value='".$sublist["cat_no"]."' selected>".$sublist["cat_name"]."</option>\n";
	else echo "<option value='".$sublist["cat_no"]."'>".$sublist["cat_name"]."</option>\n";
	$cat_no_new = substr($sublist["cat_no"],4);
	$substr1 = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 6 AND RIGHT(cat_no, 3) = '".$sublist["cat_no"]."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
	$subqry1 = $dbcon->_query($substr1);
	while($sublist1=@$dbcon->_fetch_array($subqry1)):
		if($sublist1["cat_no"]==$list["Category"]) echo "<option value='".$sublist1["cat_no"]."' selected>".$sublist["cat_name"]." > ".$sublist1["cat_name"]."</option>\n";
		else echo "<option value='".$sublist1["cat_no"]."'>".$sublist["cat_name"]."> ".$sublist1["cat_name"]."</option>\n";
		$cat_no_new1 = substr($sublist1["cat_no"],2);
		$substr2 = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 9 AND RIGHT(cat_no, 6) = '".$sublist1["cat_no"]."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
		$subqry2 = $dbcon->_query($substr2);
		while($sublist2=@$dbcon->_fetch_array($subqry2)):
		if($sublist2["cat_no"]==$list["Category"]) echo "<option value='".$sublist2["cat_no"]."' selected>".$sublist["cat_name"]." > ".$sublist1["cat_name"]." > ".$sublist2["cat_name"]."</option>\n";
		else echo "<option value='".$sublist2["cat_no"]."'>".$sublist["cat_name"]." > ".$sublist1["cat_name"]." > ".$sublist2["cat_name"]."</option>\n";
		endwhile;
	endwhile;
endwhile;	
?>
										</select></td>
									<td><select name="TmpMultiCategory" id="TmpMultiCategory" multiple>
<?php
$sqlsubstr = "select Category from wizMall where PID = '".$uid."' and UID != '".$uid."'";
$sqlsubqry = $dbcon->_query($sqlsubstr);
while($sublist = $dbcon->_fetch_array($sqlsubqry)): 
		$mul_cat = $sublist["Category"];
		$mul_cat_len =strlen($mul_cat);
	if($mul_cat_len > 0){
		$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($mul_cat, -3)."' and cat_flag = 'wizmall'";
		$cat_name = $dbcon->get_one($sqlcatstr);
	}
	if($mul_cat_len > 3){
		$sqlcatstr = "select cat_name from wizCategory where cat_no = '".substr($mul_cat, -6)."' and cat_flag = 'wizmall'";
		$cat_name .= ">".$dbcon->get_one($sqlcatstr);
	}
	if($mul_cat_len > 6){
		$sqlcatstr = "select cat_name from wizCategory where cat_no = '".$mul_cat."' and cat_flag = 'wizmall'";
		$cat_name .= ">".$dbcon->get_one($sqlcatstr);
	}
?>
											<option value="<?php echo $sublist["Category"]?>">
											<?php echo $cat_name?>
											</option>
<?php
endwhile;
?>
										</select>
										<button type="button" class="btn btn-default btn-xs" onclick=DeleteMultiCat(this.form.TmpMultiCategory)>제거</button>
										<a href="javascript:window.open('http://www.shop-wiz.com/board/main/view/root/manual/2/2','OnlineManual','width=500,0,scrollbars=yes,resizable=yes')";><img src="../../wizboard/images/help.gif">
											
										</a></td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">상품명</th>
						<td><input name=Name value="<?php echo $list["Name"]?>">
						</td>
					</tr>
					<tr>
						<th class="active">상품모델명</th>
						<td><input name="Model" value="<?php echo $list["Model"]?>">
							- 사용하지 않을경우 공백처리</td>
					</tr>
					<tr>
						<th class="active">판매가(즉시구매가)<br />
							차등가격적용<input name="diffprice" type="checkbox" class="opflag"  value="d" <? if($list["opflag"]=="d") echo "checked";?>>
						</th>
						<td><input name="Price" value="<?php echo $list["Price"]?$list["Price"]:0;?>">
							콤마(,)없이 숫자로만 입력(보기:10000)
							
								<div id="diffpricefield"<?php echo $list["opflag"]=="d" ? "":" class='none'";?>>
									<div class="fleft">
										<ul class="diffpricefieldClass" >
<?php
for($i=0; $i<count($diffPrice); $i++){
echo '<li>
<ul><li>
- 신청수량이 <input name="diffQtyArr[]" value="'.$diffPrice[$i]["qty"].'" class="w30"> 개 미만일때 <input name="diffPriceArr[]" onkeydown=onlyNumber() value="'.$diffPrice[$i]["price"].'" class="w50">
<span class="button bull btn_addDiffprice_del"><a>삭제</a></span>
</li></ul>
</li>';
}
?>
											
										</ul>
									</div>
									<div class="fleft" style="padding-left:30px">
										<span class="button bull" id="addDiffprice"><a>추가</a></span>
									</div>
								</div>

							
							</td>
					</tr>
					<tr>
						<th class="active">소비자가</th>
						<td><input name="Price1" value="<?php echo $list["Price1"]?>" maxLength=30>
							콤마(,)없이 숫자로만 입력(보기:10000)- 사용하지 않을경우 공백처리</td>
					</tr>
					<tr>
						<th class="active">부가 포인트</th>
						<td><input name="Point" value="<?php echo $list["Point"]?>">
							이 상품에 부가할 마일리지포인트. </td>
					</tr>
					<tr>
						<th class="active">공동구매
							<input name="cobuy" type="checkbox" class="opflag" value="c" <? if($list["opflag"]=="c") echo "checked";?>></th>
						<td>공동구매시 이곳에 책크(공동구매는 일반 매장이 아니라 공동 구매 매장에만 디스플레이, 차등가격중 택1)</td>
					</tr>
					<tr id="cobuyfield"<?php echo $list["opflag"]=="c" ? "":" class='none'";?>>
						<td colspan="2"><table class="table_sub">
								<tr>
									<th class="active">*차등가격적용 </th>
									<td><table 
>
											<tr>
												<td>- 신청수량이
													<input name="c_qty[0]" value="<?php echo $p_qty[0][1];?>">
													개 이상일때
													<input name="c_price[0]" onKeyPress=is_number() value="<?php echo $p_qty[0][0];?>">
													원(하위로 5, 10, 20... 순으로 입력)</td>
											</tr>
											<tr>
												<td>- 신청수량이
													<input name="c_qty[1]" value="<?php echo $p_qty[1][1];?>" />
													개 이상일때
													<input  name="c_price[1]" onKeyPress=is_number()  value="<?php echo $p_qty[1][0];?>" />
													원</td>
											</tr>
											<tr>
												<td>- 신청수량이
													<input name="c_qty[2]" value="<?php echo $p_qty[2][1];?>" />
													개 이상일때
													<input name="c_price[2]" onKeyPress=is_number() value="<?php echo $p_qty[2][0];?>" />
													원</td>
											</tr>
										</table></td>
								</tr>
								<tr>
									<th class="active">*공동구매기간 </th>
									<td>
<?php
$common->startyear = date("Y");
$common->getSelectDate($SDate);
?>
										<select name='SYear' size='1'>
											<?php echo $common->rtn_year ?>
										</select>
										<select name='SMonth' size='1'>
											<?php echo $common->rtn_month ?>
										</select>
										<select name='SDay' size='1'>
											<?php echo $common->rtn_day ?>
										</select>
										~
<?php
$common->getSelectDate($FDate);
?>
										<select name='FYear' size='1'>
											<?php echo $common->rtn_year ?>
										</select>
										<select name='FMonth' size='1'>
											<?php echo $common->rtn_month ?>
										</select>
										<select name='FDay' size='1'>
											<?php echo $common->rtn_day ?>
										</select></td>
								</tr>
							</table>
							 </td>
					</tr>
					<tr>
						<td colspan="2">이미지 copy
							<input type="checkbox" name="checkbox" id="checkbox" />
							(큰그림은 반드시 넣어시고 작은/중간 그림은 선택)<br />
							<select name="watermark" id="watermark" onchange="dp_watermark(this)">
								<option>워터마크적용</option>
								<option value="text">텍스트적용</option>
								<option value="img">이미지적용</option>
							</select>
							<input name="watermark_text" type="text" id="watermark_text" value="<?php echo $cfg["admin"]["str_watermark"]?>"  style="display:none" />
							<input type="text" name="watermark_img" id="watermark_img" value="<?php echo $cfg["admin"]["img_watermark"]?>"  style="display:none" />
							[<a href="javascript:gotobasicinfo()">기본 텍스트/이미지 수정하기</a>]</td>
					</tr>
					<tr>
						<th class="active">큰그림</th>
						<td><table>
								<tr>
									<td><input type='file' name='file[]'></td>
									<td><? if($fileimg[0]): ?>
										<a href='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[0]?>' target=_blank><img src ='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[0]?>' width = 30></a>
										<?php echo $common->getImgName($fileimg[0])?>
										<?endif;?>
										(권장사이즈 : 500 x 500)(상세보기팝업이미지)</td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">작은그림<br />
							(copy
							<input name="copyimg[1]" type="checkbox" id="copyimg[1]" value="1" />
							)</th>
						<td><table>
								<tr>
									<td><input type='file' name='file[]'></td>
									<td><? if($fileimg[1]): ?>
										<a href='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[1]?>' target=_blank><img src ='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[1]?>' width = 30></a>
										<?php echo $common->getImgName($Picture[1])?>
										<?endif;?>
										(권장사이즈 : 100 x 100)리스트이미지</td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">중간그림<br />
							(copy
							<input name="copyimg[2]" type="checkbox" id="copyimg[2]" value="1" />
							)</th>
						<td><table>
								<tr>
									<td><input type='file' name='file[]'></td>
									<td><? if($fileimg[2]): ?>
										<a href='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[2]?>' target=_blank><img src ='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[2]?>' width = 30>
										<?endif;?>
										</a>
										<?php echo $common->getImgName($Picture[2])?>
										(권장사이즈 : 300 x 300) 상세보기 큰이미지</td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">기타그림</th>
						<td><table>
<?php
//$PictureCount = $uid ? sizeof($$fileimg) : 3;
for($i=3; $i<=$max_value; $i++){ 
?>
								<tr>
									<td><input type='file' name='file[]'></td>
									<td><?if($fileimg[$i]):?>
										<a href='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[$i]?>' target=_blank><img src ='../config/uploadfolder/productimg/<?php echo $imgFolder?>/<?php echo $fileimg[$i]?>' width = 30></a>
										<?php echo $common->getImgName($fileimg[$i])?>
										<?endif;?>
										<input type="button" value="삭제" onclick = "del('<?php echo $uid?>','<?php echo $i?>');"></td>
								</tr>
								<?}?>
							</table>
							<table>
								<tr>
									<td><div id='nameToDiv'></div></td>
									<td width="75" valign="bottom">
											<button type="button" class="btn btn-default btn-xs" onclick="javascript:addToPIC() ;return false";>추가하기</button>
										</td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">자세한설명
							<input type="hidden" value="1" name="des_type1">
						</th>
						<td><textarea name="Description1" rows=20 id="ir1" style="width:98%"><?php echo $list["Description1"]?></textarea></td>
					</tr>
<script >
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "ir1",
	sSkinURI: "../js/Smart/SmartEditor2Skin.html",
	fCreator: "createSEditor2"
});
</script>

				</table>
				<br />
				<div class="text-center">
					<button type="submit" class="btn btn-default">제품등록</button>
				</div>	
				<br />
				<br />
				<span> 옵션 입력사항</span>
				<table class="table table-hover">
				<col width="120px" />
				<col width="*" />
					<tr>
<?php
##옵션관련 정보를 불러온다
if($uid){
$substr = "select count(1) from wizMalloptioncfg where opid = ".$uid;
$subqry = $dbcon->_query($substr);
$sublist = $dbcon->_fetch_array($subqry);
$optioncnt = $sublist[0];
}
if(!$optioncnt) $optioncnt = 0;
?>
						<input type="hidden" name="optioncntadd" value="<?php echo $optioncnt?>" />
						<th class="active">옵션설정</th>
						<td><select name="optioncnt" id="optioncnt" onchange="listOptionCnt(this, '<?php echo $optioncnt?>')">
								<option value="0">갯수</option>
<?php
for($i=1; $i<=5; $i++){
	$selected = $optioncnt == $i ? " selected":"";
	echo "<option value='".$i."'".$selected.">".$i."</option>\n";
}
?>
							</select>
							(옵션필드갯수:색상, 사이즈, 인치...) <br />
							가격추가나 원가격변동은 택1하여 사용해 주시기 바랍니다.<br />
							옵션당 한개의 값만 입력하시면 단일 텍스트가 출력됩니다.
<?php
$substr = "select * from wizMalloptioncfg where opid = '".$uid."' order by oorder asc";
$subqry = $dbcon->_query($substr);
$cnt=0;
while($sublist = $dbcon->_fetch_array($subqry)):
$oname	= $sublist["oname"];
$oflag	= $sublist["oflag"];
$ouid = $sublist["uid"];

//옵션값갯수구하기
$substr1 = "select count(1) from wizMalloption where ouid = '".$ouid."'";
$subqry1 = $dbcon->_query($substr1);
$sublist1 = $dbcon->_fetch_array($subqry1);
$valuecnt = $sublist1[0];
if(!$valuecnt) $valuecnt = 0;
?>
							<table>
								<tr>
									<td id=currPosition>옵션명 :
										<input name='opname[<?php echo $cnt;?>]' value='<?php echo $oname?>' class='w100'/>
										<select name='opcnt[<?php echo $cnt;?>]' onChange="listeachOptionCnt(this, <?php echo $cnt;?>, '<?php echo $valuecnt?>')" style="width:50px">
											<option value='0'>갯수</option>
<?php
for($i=1; $i<=10; $i++){
	$selected = $valuecnt == $i ? " selected":"";
	echo "<option value='".$i."'".$selected.">".$i."</option>\n";
}
?>
										</select>
										<select name='opflag[<?php echo $cnt;?>]' style="width:90px">
											<option value='0' selected='selected'>기본</option>
											<option value='1'<? if($oflag == "1") echo " selected"; ?>>가격추가</option>
											<option value='2'<? if($oflag == "2") echo " selected"; ?>>원가격변경</option>
										</select>
										<input type="button" name="button2" id="button" value="del" onclick="option_del(this.parentNode.parentNode)" style='cursor:pointer'></td>
									<td>
<?php
$substr1 = "select * from wizMalloption where ouid = '".$ouid."' order by uid asc";
$subqry1 = $dbcon->_query($substr1);
$subcnt=0;
while($sublist1 = $dbcon->_fetch_array($subqry1)):
?>
										<table>
											<tr>
												<td>옵션값:
													<input name='optioneachname[<?php echo $cnt;?>][<?php echo $subcnt?>]' value='<?php echo $sublist1["oname"]?>' class='w50' />
													가격:
													<input name='optioneachprice[<?php echo $cnt;?>][<?php echo $subcnt?>]'  value='<?php echo $sublist1["oprice"]?>' class='w30' />
													재고:
													<input name='optioneachqty[<?php echo $cnt;?>][<?php echo $subcnt?>]'  value='<?php echo $sublist1["oqty"]?>' class='w30' />
													<input type="button" name="button2" id="button" value="del" onclick="option_del(this.parentNode.parentNode)" style='cursor:pointer'></td>
											</tr>
										</table>
<?php
$subcnt++;
endwhile;//while($sublist1 = $dbcon->_fetch_array($subqry1)):
?>
										<span id='add_optioneach_<?php echo $cnt?>'></span> </td>
								</tr>
							</table>
<?php
$cnt++;
endwhile;//while($sublist = $dbcon->_fetch_array($subqry)):
?>
							<span id="add_option"> </span> </td>
					</tr>
					<tr>
						<th class="active">브랜드명</th>
						<td><input name="Brand" value="<?php echo $list["Brand"]?>" maxLength=30></td>
					</tr>
					<tr>
						<th class="active">제조사/원산지</th>
						<td><input name="CompName" value="<?php echo $list["CompName"]?>" maxLength=30></td>
					</tr>
					<tr>
						<th class="active">등록옵션</th>
						<td>
<?php
$regoption	= $mall->getpdoption();
$c_option = explode("|", $list["Regoption"]);
while(list($key, $val)=each($regoption)):
	$checked = in_array($val["uid"], $c_option) ? " checked":"";
	echo "<input type='checkbox' name='Multi_Regoption[]' value='".$val["uid"]."' ".$checked." >".$val["op_name"]."&nbsp; ";

endwhile;
?>
</td>
					</tr>
					<tr>
						<th class="active">비교상품</th>
						<td><table>
								<tr>
									<td> 비교상품을 디스플레이 하기위해서는 기본환경&gt;몰스킨설정&gt;상세보기스킨&gt; 관련상품표시하기를 책크해 두셔야 합니다. <br />
										<select name="tmpSimilarPd" size="6"  multiple="multiple" readonly>
<?php
$mall->getSimilarPd($SimilarPd);
?>
										</select>
										<button type="button" class="btn btn-default btn-xs" value="찾기" onclick="window.open('product/product1_1search.php?mode=compare&sort='+document.writeForm.Category1.value+'&sort1='+document.writeForm.Category2.value+'&sort2='+document.writeForm.Category3.value+'&mode=new','Product_Search_Window','width=620, height=650, scrollbars=yes')"; style="cursor:pointer">찾기</button>
									</td>
								</tr>
							</table></td>
					</tr>
					<tr>
						<th class="active">등록일</th>
						<td>
<?php
$year = date("Y");
$month = date("m");
$day = date("j");
if($list["Date"]){
	$regyear = date("Y", $list["Date"]);
	$regmonth = date("m", $list["Date"]);
	$regday = date("d", $list["Date"]);
}else{
	$regyear = $year;
	$regmonth = $month;
	$regday = $day;
}

echo "<select name='Year' size='1'>";
for($i=$regyear;$i<=$year+5;$i++) {
    $selected = ($regyear == $i)? " selected":"";
    echo "<option value='".$i."'".$selected.">".$i."</option>\n";
}
echo "</select>년 <select name='Month' size='1'>";
for($i="01";$i<=12;$i++) {
    $selected = ($regmonth == $i)? " selected":"";
    echo "<option value='".$i."'".$selected.">".$i."</option>\n";
}
echo "
</select>월 <select name='Day' size='1'>";
for($i="01";$i<=31;$i++) {
    $selected = ($regday == $i)? " selected":"";
    echo "<option value='".$i."'".$selected.">".$i."</option>\n";
}
echo "</select>일";
?>
							<a href="#" onclick="window.open('http://shop-wiz.com/wizmanual.php?BID=manual&mode=view&UID=8&searchkeyword=&category=2','OnlineManual','width=500,0,scrollbars=yes,resizable=yes')";><img src="../../wizboard/images/help.gif" width="20" height="9"></a> (for
							more info, click &quot;?&quot;)</td>
					</tr>
					<tr>
						<th class="active">품절</th>
						<td><input type="checkbox" value="1" name="None" <? if($list["None"] == "1") echo "checked"; ?>>
							품절상품은 리스트는 되나 장바구니에 담겨지지 않습니다.</td>
					</tr>
					<tr>
						<th class="active">공급처</th>
						<td><select name=GetComp>
								<option value=''>공급거래처 없음</option>
								<option value=''>------------------</option>
<?php
$sqlcompstr = "SELECT UID,CompName,CompID FROM wizCom WHERE (CompSort = '01' or CompSort = '02' or CompSort = '03')";
$sqlcompqry = $dbcon->_query($sqlcompstr);
while( $complist = $dbcon->_fetch_array( $sqlcompqry ) ) {
unset($selected);
if(!strcmp(trim($complist["CompID"]),trim($list["GetComp"]))) $selected = " selected";
        echo "<option value='".$complist["CompID"]."'".$selected.">".$complist["CompName"]."</option>";
}
?>
							</select>
							<a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=member/member5" class="btn btn-default btn-xs">공급처등록</a>
						</td>
					</tr>
					<tr>
						<th class="active">원가 </th>
						<td><input name="WongaPrice" value="<?php echo $list["WongaPrice"]?>" 
                        maxLength=30>
							콤마(,)없이 숫자로만 입력(보기:10000) - 원 상품가</td>
					</tr>
					<tr>
						<th class="active">단위</th>
						<td><input name="Unit" value="<?php echo $list["Unit"]?>">
						</td>
					</tr>
					<tr>
						<th class="active">배송정보<br />
							<input name="des_type3" type="checkbox" value="1" <? echo $des_type3=="1"?"checked":"";?>>
							HTML사용</th>
						<td>
							<textarea id="Description3" name="Description3" rows="6"  style="width:98%"><?php echo $list["Description3"]?></textarea>
						</td>
					</tr>
					<tr>
						<th class="active">간단한
							설명</th>
						<td>
							<textarea name="Description2" rows="3"  style="width:98%"><?php echo $list["Description2"]?></textarea>

							상품에 대한 간단한 설명을 넣는 곳입니다. 스킨에 따라 적용되지 않을 수도 있습니다.<br />
						</td>
					</tr>					
					<tr>
						<th class="active">재고수량<br />
							(공동구매수량)</th>
						<td><? if($uid){ ?>
							현재고수량:
							<?php echo $list["Stock"]?>
							<?php echo $list["Unit"]?>
							(입하량의 추가/변경 일경우 <a href="javascript:wizwindow('./product/product2_2.php?uid=<?php echo $uid?>&Name=<?php echo $list["Name"]?>&Output=<?php echo $list["Output"]?>&Icomid=<?php echo $list["GetComp"]?>','InputChangeWindow','width=300,0')">이곳을
							눌러</a> 변경해 주세요)
<?php
}else{
?>
							<input name="Stock" value="">
<?php
}
?>
						</td>
					</tr>
				</table>
				<br />
				<div class="agn_c">
					<button type="submit" class="btn btn-default">제품등록</button>
				</div>
			</form>
</div>
