<?php
/* 

powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
$tbl_name="wizpopup";



if($query == "qin"){

	/* 파일 업로딩 시작 */
	unset($pattached);
	$common->upload_path	= "../config/wizpopup";
	$common->uploadmode		= "insert";
	$common->uploadfile("file");
	
	$pattached	= $common->returnfile[0];
	
	if(!$phtmlenable) $phtmlenable = 0;
	if(!$pshtmlenable) $pshtmlenable = 0;
	if(!$pbgenable) $pbgenable = 0;
	$options = $phtmlenable."|".$pshtmlenable."|".$pbgenable."|";
	
	$ins["pskinname"]	= $pskinname;
	$ins["pwidth"]		= $pwidth;
	$ins["pheight"]		= $pheight;
	$ins["ptop"]		= $ptop;
	$ins["pleft"]		= $pleft;
	$ins["psubject"]	= $psubject;
	$ins["pcontents"]	= $pcontents;
	$ins["pattached"]	= $pattached;
	$ins["imgposition"]	= $imgposition;
	$ins["popupenable"]	= $popupenable;
	$ins["options"]		= $options;
	$ins["click_url"]	= $click_url;
	$dbcon->insertData($tbl_name, $ins);
	
	echo "<script >alert('성공적으로 저장되었습니다.');location.href='$PHP_SELF?menushow=".$menushow."&theme=util/popup1';</script>";
}else if($query == "qup"){

	/* 파일 업로딩 시작 */
	$sqlstr					= "select pattached from ".$tbl_name." WHERE uid=".$uid;
	$piclistvalue			= $dbcon->get_one($sqlstr);
	//$piclist				= explode("|", $piclistvalue);	
	$common->upload_path	= "../config/wizpopup";
	$common->oldfilename	= $piclistvalue;
	$common->uploadmode		= "update";
	$common->delfile		= $preserveimg;
	$common->uploadfile("file");
	
	$pattached	= $common->returnfile[0];


	if(!$phtmlenable) $phtmlenable		= 0;
	if(!$pshtmlenable) $pshtmlenable	= 0;
	if(!$pbgenable) $pbgenable			= 0;
	$options							= $phtmlenable."|".$pshtmlenable."|".$pbgenable."|";
	
	$ins["pskinname"]	= $pskinname;
	$ins["pwidth"]		= $pwidth;
	$ins["pheight"]		= $pheight;
	$ins["ptop"]		= $ptop;
	$ins["pleft"]		= $pleft;
	$ins["psubject"]	= $psubject;
	$ins["pcontents"]	= $pcontents;
	$ins["pattached"]	= $pattached;
	$ins["imgposition"]	= $imgposition;
	$ins["popupenable"]	= $popupenable;
	$ins["options"]		= $options;
	$ins["click_url"]	= $click_url;
	$dbcon->updateData($tbl_name, $ins, "uid=".$uid);
	echo "<script >alert('성공적으로 수정되었습니다.');location.href='$PHP_SELF?menushow=".$menushow."&theme=util/popup1';</script>";
}



if($mode == "qup"){
	$sqlstr		= "select * from ".$tbl_name." where uid = ".$uid;
	$dbcon->_query($sqlstr);
	$list		= $dbcon->_fetch_array();
	
	$options	= explode("\|", $list["options"]);
	$phtmlenable	= $options[0];
	$pshtmlenable	= $options[1];
	$pbgenable		= $options[2];	
}else {
	$mode = "qin";
}
?>
<script src="../js/Smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
$(function(){
	$(".btn_submit").click(function(){
		oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
		$("#s_form").submit();	
	});
});
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">팝업창 관리</div>
	  <div class="panel-body">
		 만약 index.php에 아래코드가 없을 경우 아래 코드를 넣어 준다.<br />
        &lt;?<br />
        include &quot;./util/wizpopup/popinsert.php&quot;;<br />
        ?&gt; 
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <p></p>
      <form action='<?php echo $PHP_SELF?>' id="s_form" method='post' enctype="multipart/form-data">
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type="hidden" name="query" value="<?php echo $mode;?>">
        <input type='hidden' name='uid' value='<?php echo $uid?>'>
        <input type="hidden" name="phtmlenable" value="1">
        <table class="table">
          <tr>
            <th>스킨선택</th>
            <td><select style="width: 160px" name=pskinname>
                <?
$vardir = "../util/wizpopup";
$open_dir = opendir($vardir);
while($opendir = readdir($open_dir)) {
	if(($opendir != ".") && ($opendir != "..") && is_dir($vardir."/".$opendir)) {
		$selected = $list["pskinname"]==$opendir?"selected":""; 
		echo "<option value=\"".$opendir."\" ".$selected.">".$opendir." 스킨</option>\n";
	}
}
closedir($open_dir);
?>
              </select>
              &nbsp; </td>
          </tr>
          <tr>
            <th>팝업창  크기 </th>
            <td>가로
              <input name='pwidth' type='text' value ="<?php echo $list["pwidth"]?>" class="w30" />
              pixels X 세로
              <input name='pheight' type='text' value ="<?php echo $list["pheight"]?>" class="w30" />
              pixels </td>
          </tr>
          <tr>
            <th>팝업창 위치</th>
            <td>상단
              <input name='ptop' type='text' value ="<?php echo $list["ptop"]?>" class="w30" />
              pixels , 좌측
              <input name='pleft' type='text' value ="<?php echo $list["pleft"]?>" class="w30" />
              pixels (브라우저로부터 디스플레이 위치)</td>
          </tr>
          <tr>
            <th>자세히보기</th>
            <td><input name="click_url" type="text" value="<?php echo $list["click_url"]?>" size="40" class='dd1'>(url 입력시 자동설정)</td>
          </tr>
          <tr>
            <th>공지제목<br />
              <input type="checkbox" name="pshtmlenable" value="checkbox" <?php echo $pshtmlenable=="1"?"checked":"";?>>
              HTML 사용 </th>
            <td>
              <input name="psubject" type="text" value="<?php echo $list["psubject"]?>" class="w200" />
              (일부스킨에 따라 적용가능)</td>
          </tr>
          <tr>
            <th>공지내용</th>
<?php
$pcontents = stripslashes($pcontents);
?>
            <td>
              <textarea name="pcontents" rows="20" class="w100p" id="ir1"><?php echo $list["pcontents"]?>
</textarea>
            </td>
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
          <tr>
            <th>이미지업로딩
              <!--  <input type="checkbox" name="pbgenable" value="checkbox" <?php echo $pbgenable=="1"?"checked":"";?>>
              BG로 띄우기-->
            </th>
            <td>
              <input type="file" name="file[0]">
              <input name="preserveimg[0]" type="checkbox" value="1">
              이미지삭제 <?php echo $common->getImgName($list["pattached"])?></td>
          </tr>
          <tr>
            <th>이미지위치
              <!--  <input type="checkbox" name="pbgenable" value="checkbox" <?php echo $pbgenable=="1"?"checked":"";?>>
              BG로 띄우기-->
            </th>
            <td>
              <select name="imgposition">
                <option value="top" <?php echo $list["imgposition"]=="top"?"selected":"";?>>상</option>
                <option value="bottom" <?php echo $list["imgposition"]=="bottom"?"selected":"";?>>하</option>
              </select></td>
          </tr>
          <tr>
            <th>PopUp Enable</th>
            <td>
              <input name="popupenable" type="checkbox" value="1" <?php echo $list["popupenable"]=="1"?"checked":"";?>>
              (팝업창을 띄우시려면 이곳에 책크가 되어있어야 합니다.)</td>
          </tr>
        </table>
      </form>
      <div class="agn_c w_default">
      <span class="button bull btn_submit"><a>적용</a></span>
      <span class="button bull btn_submit"><a href="main.php?menushow=<?php echo $menushow?>&theme=util/popup1">리스트</a></span>
      </div></td>
  </tr>
</table>
