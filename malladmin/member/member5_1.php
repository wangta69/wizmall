<?php
/* 

powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
if ($common -> checsrfkey($csrf)) {
	if ($action == 'wizCom_write') :
		/* 현재 wizMembers 와 아이디를 비교하여 동일 아이디가 존재할 경우 아이디를 사용할 수 없게 한다. */
		$sqlstr = "select count(UID) from wizMembers where mid = '$CompID'";
		$result = $dbcon->get_one($sqlstr);
		if($result){
			echo "<script >window.alert('현재 동일 아이디가 사용중입니다. \\n\\n 아이디를 새로 변경해 주세요'); history.go(-1); </script>";
			exit;
		}
	
		$sqlstr = "select count(*) from wizCom where CompID = '$CompID'";
		$result = $dbcon->get_one($sqlstr);
		if($result){
			echo "<script >window.alert('현재 동일 아이디가 사용중입니다. \\n\\n 아이디를 새로 변경해 주세요'); history.go(-1); </script>";
			exit;
		}
	
		$CompZip1 = $zip1."-".$zip2; 
		$RegDate = time();
	    $QUERY1 = "INSERT INTO wizCom
	    (
	    CompSort,CompID,CompName,CompPass,CompNum,CompKind,CompType,CompZip1,CompAddress1,CompAddress2,
	    CompPreName,CompPreTel,CompChaName,CompChaTel,CompTel,CompFax,CompChaEmail,CompUrl,CompContents
	    )
	    VALUES
	    (
	    '$CompSort','$CompID','$CompName','$CompPass','$CompNum','$CompKind','$CompType','$CompZip1','$CompAddress1','$CompAddress2',
		'$CompPreName','$CompPreTel','$CompChaName','$CompChaTel','$CompTel','$CompFax','$CompChaEmail','$CompUrl','$CompContents'
	    )";
	    $dbcon->_query($QUERY1);
	/* 만약 CompSort >= 50 (판매처) 일경우 wizMembers 에도 일부정보를 입력하여 공유하도록 한다. */
		if($CompSort >= 50 ) {
	  	  $QUERY1 = "INSERT INTO wizMembers
	  	  (mid,mpasswd,mname,mgrade,mregdate)
	  	  VALUES('$CompID','$CompPass','$Name','5','$RegDate')";
	  	  $dbcon->_query($QUERY1);
		  }
	
	
	    echo "<html>
	    <META http-equiv=\"refresh\" content =\"0;url=$PHP_SELF?menushow=$menushow&theme=member/member5\">
	   </html>";
	    exit;
	endif;


	if ($action == 'wizCom_modify') :
		$CompZip1 = $zip1."-".$zip2; 
		$SqlStr = "UPDATE wizCom SET 
		CompSort = '$CompSort',
		CompName = '$CompName',
		CompID = '$CompID',
		CompPass = '$CompPass',
		CompNum = '$CompNum',
		CompKind = '$CompKind',
		CompType = '$CompType',
		CompZip1 = '$CompZip1',
		CompAddress1 = '$CompAddress1',
		CompAddress2 = '$CompAddress2',
		CompPreName = '$CompPreName',
		CompPreTel = '$CompPreTel',
		CompChaName = '$CompChaName',
		CompChaTel = '$CompChaTel',
		CompTel = '$CompTel',
		CompFax = '$CompFax',
		CompChaEmail = '$CompChaEmail',
		CompUrl = '$CompUrl',
		CompContents = '$CompContents'
		WHERE UID='$uid'";
		//echo "\$SqlStr = $SqlStr <br />";
		
		$result = $dbcon->_query($SqlStr);
		//exit;
		if($result){ echo "<html>
		        <META http-equiv=\"refresh\" content =\"0;url=$PHP_SELF?menushow=$menushow&theme=member/member5\">
		       </html>";
		        exit;
		}		
	endif;
}//if ($common -> checsrfkey($csrf)) {
?>
<script>
function checkForm(f) {
        if ( !f.CompName.value.length ) {
                alert( '거래처의 상호를 입력해 주세요' );
                f.CompName.focus();
                return false;
        }
        if ( !f.CompSort.value.length ) {
                alert( '거래처의 분류를 선택해 주세요' );
                f.CompSort.focus();
                return false;
        }
        if ( !f.CompID.value.length ) {
                alert( '거래처의  아이디를 입력해 주세요' );
                f.CompID.focus();
                return false;
        }				
        if ( !f.CompPass.value.length ) {
                alert( '거래처의 접속을 위한 패스워드를 입력해 주세요' );
                f.CompPass.focus();
                return false;
        }
        if ( !f.CompNum.value.length ) {
                alert( '거래처의 사업자등록번호를 입력해 주세요' );
                f.CompNum.focus();
                return false;
        }
        if ( !f.CompKind.value.length ) {
                alert( '거래처의 업태를 입력해 주세요' );
                f.CompKind.focus();
                return false;
        }
        if ( !f.CompType.value.length ) {
                alert( '거래처의 종목을 입력해 주세요' );
                f.CompType.focus();
                return false;
        }
        if ( !f.zip1.value.length || !f.zip2.value.length) {
                alert( '우편번호를 입력해 주세요' );
                f.zip1.focus();
                return false;
        }
        if ( !f.CompAddress1.value.length ) {
                alert( '거래처의 주소를 입력해 주세요' );
                f.CompAddress1.focus();
                return false;
        }
        if ( !f.CompPreName.value.length ) {
                alert( '대표자의 성명을 입력해 주세요' );
                f.CompPreName.focus();
                return false;
        }
        if ( !f.CompChaName.value.length ) {
                alert( '담당자의 성명을 입력해 주세요' );
                f.CompChaName.focus();
                return false;
        }
	
}
function OpenZipcode(){
	window.open("../util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip1&zip2=zip2&firstaddress=CompAddress1&secondaddress=CompAddress2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading"><?if($mode=="modify") echo"거래처 수정"; else echo"거래처 등록";?></div>
	  <div class="panel-body">
		 제품공급 거래처 및 판매처를 등록합니다. <br />
				등록된 거래처는 제품등록시에 선택할 수 있으며 제품공급 거래처를 
				등록하면 공급 거래처별로 매출통계를 낼 수 있습니다.
	  </div>
	</div>
</div>
<table class="table_outline">
	<tr>
		<td>
			<div class="space20"></div>
			<form action='<?php echo $PHP_SELF?>' method="post" name='FrmUserInfo' onsubmit='return checkForm(this)'>
				<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
				<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
				<input type="hidden" name="theme" value="<?php echo $theme?>">
				<table class="table">
					<? 
if(!strcmp($mode,"modify")){
	if($uid){
	$sqlstr = "select * from wizCom where UID ='$uid'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	$Zip =  explode("-", $list["CompZip1"]);
	}
	echo "<input type='hidden' name='action' value='wizCom_modify'> ";
	echo "<input type='hidden' name='uid' value='$uid'> ";
}else  echo "<input type='hidden' name='action' value='wizCom_write'> ";
?>
					<tr>
						<th>* 
							상호</th>
						<td><input name="CompName" type="text" value="<? echo $list["CompName"]?>"></td>
						<!-- 
기업회원 구분(wizCom.CompSort)은 크게 공급처( <50 ) 과 소매처(50 <=, <100) 로 분류된다. 
01 : 도매공급자, 02 : 소매공급자, 03 : 생산자), 50 : 쇼핑몰(온라인)기업고객고객, 51 : 도매판매처, 52, 소매판매처 .. 경우에따라 이곳은 자유롭게 프로그램가능)
-->
						<th>* 
							거래처분류</th>
						<td><select name="CompSort">
								<option value="01" <? if($list["CompSort"] == "01") echo "selected";?>>도매공급자</option>
								<option value="02" <? if($list["CompSort"] == "02") echo "selected";?>>소매공급자</option>
								<option value="03" <? if($list["CompSort"] == "03") echo "selected";?>>생산자</option>
								<option value="51" <? if($list["CompSort"] == "51") echo "selected";?>>도매판매처</option>
								<option value="52" <? if($list["CompSort"] == "52") echo "selected";?>>소매판매처</option>
							</select></td>
					</tr>
					<tr>
						<th>* 
							거래처아이디</th>
						<td><input name="CompID" type="text" id="CompID" value="<? echo $list["CompID"]?>" <? if(!strcmp($mode,"modify")) echo "readonly";?>></td>
						<th>* 거래처패스워드</th>
						<td><input name="CompPass" type="text" value="<? echo $list["CompPass"]?>"></td>
					</tr>
					<tr>
						<th>* 
							사업자등록번호</th>
						<td colspan="3"><input name="CompNum" type="text" value="<? echo $list["CompNum"]?>"></td>
					</tr>
					<tr>
						<th>* 
							업태</th>
						<td><input name="CompKind" type="text" value="<? echo $list["CompKind"]?>"></td>
						<th>* 종목 </th>
						<td><input name="CompType" type="text" value="<? echo $list["CompType"]?>"></td>
					</tr>
					<tr>
						<th>* 
							사업장 주소</th>
						<td colspan=3><input type="text" name="zip1" value="<?php echo $Zip[0]?>" maxlength="3" id="zip1" class="w30">
							-
							<input type="text" name="zip2" value="<?php echo $Zip[1]?>" maxlength="3" id="zip2" class="w30">
							<button type="button" class="btn btn-default btn-xs" onClick='OpenZipcode()'>우편번호찾기</button><br />
							<input type="text" name="CompAddress1" value="<? echo $list["CompAddress1"]?>" id="CompAddress1" class="w300">
							<br />
							<input type="text" name="CompAddress2" value="<? echo $list["CompAddress2"]?>" id="CompAddress2" class="w300"></td>
					</tr>
					<tr>
						<th>* 
							전화</th>
						<td><input name="CompTel" type="text" value="<? echo $list["CompTel"]?>"></td>
						<th>* 팩스</th>
						<td><input name="CompFax" type="text" value="<? echo $list["CompFax"]?>"></td>
					</tr>
					<tr>
						<th>* 
							대표자명</th>
						<td><input name="CompPreName" type="text" value="<? echo $list["CompPreName"]?>">
						</td>
						<th>* 대표자 연락처</th>
						<td><input name="CompPreTel" type="text" value="<? echo $list["CompPreTel"]?>"></td>
					</tr>
					<tr>
						<th>* 
							담당자명</th>
						<td><input name="CompChaName" type="text" value="<? echo $list["CompChaName"]?>">
						</td>
						<th>* 담당자 연락처</th>
						<td><input name="CompChaTel" type="text" value="<? echo $list["CompChaTel"]?>"></td>
					</tr>
					<tr>
						<th>* 
							담당자이메일</th>
						<td colspan=3><input name="CompChaEmail" type="text" value="<? echo $list["CompChaEmail"]?>"></td>
					</tr>
					<tr>
						<th>* 
							홈페이지</th>
						<td colspan=3><input name="CompUrl" type="text" value="<? echo $list["CompUrl"]?>" class="w300"></td>
					</tr>
					<tr>
						<th>* 
							기타</th>
						<td colspan=3><textarea name="CompContents" rows="6" id="CompContents" class="w100p"><? echo $list["CompContents"]?>
</textarea></td>
					</tr>
				</table>
				<br />
				<div class="btn_box">
				<button type="submit" class="btn btn-primary">완료</button>
				</dvi>
			</form></td>
	</tr>
</table>
