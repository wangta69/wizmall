<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
include "../common/header_pop.php";
if ($common -> checsrfkey($csrf)) {
	if ($action == "qup") {
			if($grantsta=="03"){//현재승인상태
				$mgrantsta = "04";
			}else if($grantsta=="00"){//현재 탈퇴상태
				$mgrantsta = "04";
			}else{//현재 보류샹태
				$mgrantsta = "03";
			}
	        $QUERY1 = "UPDATE wizMembers SET mgrantsta = '$mgrantsta' WHERE mid='$id'";
	        $dbcon->_query($QUERY1);
	}else if ($action == "qde") {// 회원삭제하기
		foreach($DeleteMember as $key => $value){
		$sqlstr = "select mid from wizMembers WHERE uid='$key'";
		$mid = $dbcon->get_one($sqlstr);
			if($mid){
				$dbcon->_query("DELETE FROM wizMembers WHERE mid='$mid'");
				$dbcon->_query("DELETE FROM wizMembers_ind WHERE id='$mid'");
				$dbcon->_query("DELETE FROM wizMembers_meeting WHERE id='$mid'");
				$dbcon->_query("DELETE FROM wizPoint WHERE id='$mid'");
			}
		}
	}
}//if ($common -> checsrfkey($csrf)) {

if($grade == "5") $title = "기업회원정보";
else if($grade == "10") $title = "일반회원정보";
else if($grantsta == "00") $title = "탈퇴회원정보";
else $title = "전체회원정보";
/* 회원 삭제 하기 끝 */
$WHERE = "WHERE 1";
if($grade) $WHERE .= " and m.mgrade = '$grade'";
if($grantsta == "00") $WHERE .= " and m.mgrantsta = '$grantsta'";
if ($searchtitle && $keyword) {
                $WHERE .= " and $searchtitle LIKE '%$keyword%'";
}

if (!$SELECT_SORT) {$sort = "m.uid";}
else $sort = $SELECT_SORT;

if ($DataEnable) {
	$FromDate = mktime(0,0,0,"$SMonth","$SDay","$SYear");
	$ToDate =  mktime(0,0,0,"$FMonth","$FDay","$FYear");
	$WHERE .= " AND m.mregdate  >= '$FromDate' AND m.mregdate <= '$ToDate'";
}


/* 페이징과 관련된 수식 구하기 */
if(empty($ListNo)) $ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$TOTAL_STR = "SELECT count(*) FROM wizMembers";
$REALTOTAL = $dbcon->get_one($TOTAL_STR);

$sqlstr = "SELECT count(*) FROM wizMembers m $WHERE";
$TOTAL = $dbcon->get_one($sqlstr);

$sqlstr = "SELECT m.*, i.* FROM wizMembers m 
left join wizMembers_ind i on m.mid  =  i.id $WHERE ORDER BY $sort DESC LIMIT $START_NO,$ListNo";

$dbcon->_query($sqlstr);
?>
<script>
function insertMember(){
	var ret;
	var str = new Array();
	var obj = document.getElementsByName('chk[]');
	var tbl = opener.document.getElementById('m_ids');
	ret = false;

	for (i=0;i<obj.length;i++){
		if (obj[i].checked){
			str = obj[i].value.split(':');
			oTr = tbl.insertRow();
			oTd = oTr.insertCell();
			oTd.id = "currPosition";
			oTd.innerHTML = str[1] + '(' + str[0] + ')';
			oTd = oTr.insertCell();
			oTd.innerHTML = "\<input type=text name=m_ids[] value='" + str[0] + "' style='display:none'>";
			oTd = oTr.insertCell();
			oTd.innerHTML = "<input type='button' name='Button' id='button' value='삭제' onclick='del_options(this.parentNode.parentNode)' style='cursor:pointer' />";
			ret = true;
		}

	}
	if (!ret){
		alert('회원을 선택해주세요');
		return;
	}
	opener.calSmsCnt();
	self.close();
}
</script>

<table>
  <form name="ListnoForm" action="<?=$PHP_SELF?>">
  	<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey() ?>">
    <input type='hidden' name='grade' value='<?=$grade?>'>
    <input type='hidden' name='grantsta' value='<?=$grantsta?>'>
    <input type="hidden" name="cp" value='<?=$cp?>'>
    <input type="hidden" name=searchtitle value='<?=$searchtitle?>'>
    <input type="hidden" name="keyword" value='<?=$keyword?>'>
    <input type="hidden" name=SELECT_SORT value='<?=$SELECT_SORT?>'>
    <input type="hidden" name=add value='<?=$add?>'>
    <input type="hidden" name=gender value='<?=$gender?>'>
    <input type="hidden" name=Dsort value='<?=$Dsort?>'>
    <input type="hidden" name=SYear value='<?=$SYear?>'>
    <input type="hidden" name=SMonth value='<?=$SMonth?>'>
    <input type="hidden" name=SDay value='<?=$SDay?>'>
    <tr>
      <td></td>
      <td><select name="ListNo" onChange="submit()">
          <option>리스트갯수</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
  </form>
</table>
<table>
  <form action='<?=$PHP_SELF?>' name='memberlist'>
  	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
    <input type='hidden' name='grade' value='<?=$grade?>'>
    <input type='hidden' name='grantsta' value='<?=$grantsta?>'>
    <input type="hidden" name="cp" value='<?=$cp?>'>
    <input type="hidden" name=searchtitle value='<?=$searchtitle?>'>
    <input type="hidden" name="keyword" value='<?=$keyword?>'>
    <input type="hidden" name=SELECT_SORT value='<?=$SELECT_SORT?>'>
    <input type="hidden" name=add value='<?=$add?>'>
    <input type="hidden" name=gender value='<?=$gender?>'>
    <input type="hidden" name=Dsort value='<?=$Dsort?>'>
    <input type="hidden" name=SYear value='<?=$SYear?>'>
    <input type="hidden" name=SMonth value='<?=$SMonth?>'>
    <input type="hidden" name=SDay value='<?=$SDay?>'>
    <tr>
      <th>선택</th>
      <th>회원이름<br />
        (성별, 나이)</th>
      <th>아이디</th>
      <th>등급</th>
      <th>포인트</th>
      <th>가입일</th>
      <th>로긴수</th>
      <th>승인</th>
    </tr>
    <?
$NO = $TOTAL-($ListNo*($cp-1));	
while( $list = $dbcon->_fetch_array( $sqlqry ) ) :
        $area = explode(" ", trim($list[address1]));
		if(substr($list[jumin2],0,1) == 1 || substr($list[jumin2],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
		$age = date("Y") - (substr($list[jumin1],0,2) + $BirthCentury);
		if(!$list[gender] && $list[jumin2]){
			$genderno = substr($list[jumin2],0,1);
			if($genderno == 1 || $genderno == 3) $list[gender] = "1";
			else if($genderno == 2 || $genderno == 4) $list[gender] = "2";
		}
		switch($list["gender"]){
			case "1":
				$gender_str = "남";
			break;
			case "2":
				$gender_str = "여";
			break;
		}		
		$mgrade = $list["mgrade"];
		$mgradestr = $gradetostr_info[$mgrade]?$gradetostr_info[$mgrade]:$mgrade;
       
?>
    <tr>
      <td><input type="checkbox" name="chk[]" id="idcheck" value="<?=$list["mid"]?>:<?=$list["mname"]?>";></td>
      <td><?=$list[mname]?>
        <? if($list[gender] || $list[jumin2]) echo "<br />(".$gender_str;
			  if($list[jumin2]) echo ",".$age;
			  if($list[gender] || $list[jumin2]) echo ")"; 
			  ?>
      </td>
      <td><?=$list[mid]?></td>
      <td><?=$mgradestr?></td>
      <td><?=number_format($list["mpoint"])?></td>
      <td><?=date("Y.m.d", $list[mregdate])?></td>
      <td><?=number_format($list[mloginnum])?></td>
      <td><a href="javascript:changegrant('<?=$list["mgrantsta"]?>', '<?=$list["mid"]?>');">
        <?		

if ( $list["mgrantsta"] == "03" ){#승인 상태일 경우
	echo "<img src='../img/icon_accept.gif' alt='승인상태'>";
}else if ( $list["mgrantsta"] == "00" ) {# 탈퇴회원일경우
	echo "<img src='../img/icon_out.gif' alt='탈퇴상태'>";
}else{// 미승인 상태일 경우
	echo "<img src='../img/icon_refuse.gif' alt='보류상태'>";
}		
?>
        </a></td>
    </tr>
    <?
$NO--; 
endwhile;
?>
  </form>
  <tr>
    <td colspan=8><table>

        <tr>
          <td><table>
              <form action='<?=$PHP_SELF?>' method="post">
              	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
                <input type="hidden" name="grade" value='<?=$grade?>'>
                <input type="hidden" name="grantsta" value='<?=$grantsta?>'>
                <tr>
                  <td colspan="4"><div>
                      <?
$appstartyear = date("Y", $WizApplicationStartDate);
$appstartmonth = date("m", $WizApplicationStartDate);
$appstartday = date("j", $WizApplicationStartDate);
$thisyear = date("Y");
if (!$action) {
$year = $appstartyear;
$month = $appstartmonth;
$day = $appstartday;
}
else {
$year = $SYear;
$month = $SMonth;
$day = $SDay;
}
?>
                     <select name='SYear' size='1'>
                        <?
for($i=$appstartyear;$i<=$thisyear+1;$i++) {
if($year == $i) {
echo "<option value='$i' selected>${i}년</option>\n";
}
else {
echo "<option value='$i'>${i}년</option>\n";
}
}
?>
                      </select>
                      <select name='SMonth' size='1'>
                        <?
for($i="01";$i<=12;$i++) {
if(strlen($i)==1) $i="0".$i;
if($month == $i) {
echo "<option value='$i' selected>${i}월</option>\n";
}
else {
echo "<option value='$i'>${i}월</option>\n";
}
}
?>
                      </select>
                      <select name='SDay' size='1'>
                        <?
for($i="01";$i<=31;$i++) {
if(strlen($i)==1) $i="0".$i;
if($day == $i) {
echo "<option value='$i' selected>${i}일</option>\n";
}
else {
echo "<option value='$i'>${i}일</option>\n";
}
}
?>
                      </select>
                      ~
                      <?
if (!$action) {
$year = date("Y");
$month = date("m");
$day = date("j");
}
else {
$year = $FYear;
$month = $FMonth;
$day = $FDay;
}
?>
                      <select name='FYear' size='1'>
                        <?
for($i="2003";$i<=2009;$i++) {
if($year == $i) {
echo "<option value='$i' selected>${i}년</option>\n";
}
else {
echo "<option value='$i'>${i}년</option>\n";
}
}
?>
                      </select>
                      <select name='FMonth' size='1'>
                        <?
for($i="01";$i<=12;$i++) {
if(strlen($i)==1) $i="0".$i;
if($month == $i) {
echo "<option value='$i' selected>${i}월</option>\n";
}
else {
echo "<option value='$i'>${i}월</option>\n";
}
}
?>
                      </select>
                      <select name='FDay' size='1'>
                        <?
for($i="01";$i<=31;$i++) {
if(strlen($i)==1) $i="0".$i;
if($day == $i) {
echo "<option value='$i' selected>${i}일</option>\n";
}
else {
echo "<option value='$i'>${i}일</option>\n";

}
}
?>
                      </select>
                      <input type="checkbox" name="DataEnable" value="1"<? if($DataEnable) echo " checked";?>>
                      Enable </div></td>
                </tr>
                <tr>
                  <td><select name=searchtitle>
                      <option value=''>검색영역</option>
                      <option value=''>----------</option>
                      <option value='m.mid'<?if($searchtitle=='m.mid'){ECHO" SELECTED";}?>>아이디</option>
                      <option value='m.mname'<?if($searchtitle=='m.mname'){ECHO" SELECTED";}?>>이 름</option>
                      <option value='address1'<?if($searchtitle=='address1'){ECHO" SELECTED";}?>>주거지역</option>
                      <option value='i.gender'<?if($searchtitle=='i.gender'){ECHO" SELECTED";}?>>성 별</option>
                      <option value='i.email'<?if($searchtitle=='i.email'){ECHO" SELECTED";}?>>이메일</option>
                      <option value='i.jumin1'<?if($searchtitle=='i.jumin1'){ECHO" SELECTED";}?>>주민번호(6)</option>
                      <option value='i.jumin2'<?if($searchtitle=='i.jumin2'){ECHO" SELECTED";}?>>주민번호(7)</option>
                    </select>
                  </td>
                  <td><input size=10 
                                name="keyword">
                  </td>
                  <td><input type="image" src="../img/se.gif" width="66"></td>
                  <td><select style="width: 140px" 
                                onChange=this.form.submit() name='SELECT_SORT'>
                      <option value=''>선택부분별 정렬</option>
                      <option value=''>-------------------</option>
                      <option value='m.mregdate'<?if($SELECT_SORT=='m.mregdate'){ECHO" SELECTED";}?>>등록날짜순 
                      정렬</option>
                      <option value='m.mid'<?if($SELECT_SORT=='m.mid'){ECHO" SELECTED";}?>>아이디순 
                      정렬</option>
                      <option value='m.mname'<?if($SELECT_SORT=='m.mname'){ECHO" SELECTED";}?>>이름순 
                      정렬</option>
                      <option value='m.mpoint'<?if($SELECT_SORT=='m.mpoint'){ECHO" SELECTED";}?>>포인트순 
                      정렬</option>
                      <option value='m.mgrade'<?if($$SELECT_SORT=='m.mgrade'){ECHO" SELECTED";}?>>등급순 
                      정렬</option>
                      <option value='m.mloginnum'<?if($SELECT_SORT=='m.mloginnum'){ECHO" SELECTED";}?>>접속순 
                      정렬</option>
                      <option value='i.jumin1'<?if($SELECT_SORT=='i.jumin1'){ECHO" SELECTED";}?>>나이구분 
                      정렬</option>
                      <option value='i.address1'<?if($SELECT_SORT=='i.address1'){ECHO" SELECTED";}?>>지역구분 
                      정렬</option>
                      <option value='i.gender'<?if($SELECT_SORT=='i.gender'){ECHO" SELECTED";}?>>성별구분 
                      정렬</option>
                    </select>
                  </td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
<table>
  <tr>
    <td><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?grade=$grade&grantsta=$grantsta&ListNo=$ListNo&searchtitle=$searchtitle&keyword=".urlencode($keyword)."&SELECT_SORT=$SELECT_SORT&SYear=$SYear&SMonth=$SMonth&SDay=$SDay&FYear=$FYear&FMonth=$FMonth&FDay=$FDay&DataEnable=$DataEnable";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></td>
  </tr>
</table>
<table>
  <tr>
    <td><input type="button" name="Button" id="button" value="확인" onclick="insertMember()" style="cursor:pointer"></td>
  </tr>
</table>
