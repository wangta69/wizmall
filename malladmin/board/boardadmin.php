<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

*** Updating List ***
*/

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$GID = "root";
if(!strcmp($create_table,"makeit")){
	/* New Table 생성 */	
	$SetupPath = "../config/wizboard";	
	$SourcePath = "../wizboard";	
	$board->createTable($m_bid, $GID, $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);
}//if(!strcmp($create_table,"makeit"))에 대한 것을 닫음



?>
<!--
하단은 jqgrid 관련 옵션 세팅
//-->
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.plugins/jquery.jqGrid/css/ui.jqgrid.css" />
<script src="../js/jquery.plugins/jquery.jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="../js/jquery.plugins/jquery.jqGrid/plugins/ui.multiselect.js" type="text/javascript"></script>
<script src="../js/jquery.plugins/jquery.jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="../js/jquery.plugins/jquery.jqGrid/plugins/jquery.tablednd.js" type="text/javascript"></script>
<script src="../js/jquery.plugins/jquery.jqGrid/plugins/jquery.contextmenu.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	var lastsel;
//, invdate, asc
	jQuery("#list1").jqGrid({
		url:'./board/api_board.php?type=json&do=get_list',
		datatype: "json",
		colNames:['GID', 'BID','테이블설명', '패스워드', '경로','패스워드변경','상세옵션수정','게시물관리','보기'],
		colModel:[
			{name:'GID',index:'GID', width:55},
			{name:'BID',index:'BID', width:55},
			{name:'BoardDes',index:'BoardDes', width:90, editable:true},
			{name:'Pass',index:'Pass', width:100, editable:true},
			{name:'Path',index:'Path', width:300, sortable:false},
			{name:'Button1',index:'Button1', width:80, sortable:false, align:"center"},		
			{name:'Button2',index:'Button2', width:80, sortable:false, align:"center"},		
			{name:'Button3',index:'Button3', width:80, sortable:false, align:"center"},
			{name:'Button4',index:'Button4', width:80, sortable:false, align:"center"}
		],
		rowNum:10,
		rowList:[10,20,30],
		pager: '#pager1',
		sortname: 'UID',
		viewrecords: true,
		sortorder: "desc",
		height: "100%",
		width:"760",

		onSelectRow: function(id){
			if(id && id!==lastsel){
				jQuery('#list1').jqGrid('restoreRow',lastsel);
				jQuery('#list1').jqGrid('editRow',id,true);
				lastsel=id;
			}
		},
		gridComplete: function(){
		var ids = jQuery("#list1").jqGrid('getDataIDs');
		
		for(var i=0;i < ids.length;i++){
			var cl = ids[i];
			//alert(cl);//실제적인 아이디
			//eval("jQuery('#list1').editRow('"+cl+"')");
			btn1 = "<input style='height:22px;width:50px;' type='button' value='변경' onclick=\"jQuery('#list1').saveRow('"+cl+"');\" />"; 
			btn2 = "<input style='height:22px;width:50px;' type='button' value='수정' class='btn_option' />"; 
			btn3 = "<input style='height:22px;width:50px;' type='button' value='관리' class='btn_board' />"; 
			btn4 = "<input style='height:22px;width:50px;' type='button' value='보기' class='btn_view' />"; 
			jQuery("#list1").jqGrid('setRowData',ids[i],{Button1:btn1});
			jQuery("#list1").jqGrid('setRowData',ids[i],{Button2:btn2});
			jQuery("#list1").jqGrid('setRowData',ids[i],{Button3:btn3});
			jQuery("#list1").jqGrid('setRowData',ids[i],{Button4:btn4});
		}	
	},
		editurl: "./board/api_board.php?type=json&do=save_list",
		caption:"보드 관리"
	});
	jQuery("#list1").jqGrid('navGrid','#pager1',{edit:false,add:false,del:false});


	//$(".btn_view").live("click", function(){
	$(document).on("click", ".btn_view", function(){
		var i	= $(".btn_view").index(this);
		var ids = jQuery("#list1").jqGrid('getDataIDs');
		var cl = ids[i];
		var bid = $('#list1').getCell(cl, 'BID');
		var gid = $('#list1').getCell(cl, 'GID');
		var url = "../wizboard.php?BID="+bid+"&GID="+gid;
		window.open(url,'','');
	});

	//$(".btn_option").live("click", function(){
	$(document).on("click", ".btn_option", function(){
		var i	= $(".btn_option").index(this);
		var ids = jQuery("#list1").jqGrid('getDataIDs');
		var cl = ids[i];
		var bid = $('#list1').getCell(cl, 'BID');
		var gid = $('#list1').getCell(cl, 'GID');
		var url	= "../wizboard/admin1.php?BID="+bid+"&GID="+gid;
		window.open(url,'옵션보기','scrollbars=yes,resizable=yes,width=630,height=500');
	});

	//$(".btn_board").live("click", function(){
	$(document).on("click", ".btn_board", function(){
		var i	= $(".btn_board").index(this);
		var ids = jQuery("#list1").jqGrid('getDataIDs');
		var cl = ids[i];
		var bid = $('#list1').getCell(cl, 'BID');
		var gid = $('#list1').getCell(cl, 'GID');
		var url	= "<?=$PHP_SELF?>?AdminBID="+bid+"&AdminGID="+gid+"&menushow=<?=$menushow?>&theme=<?=$theme?>";
		location.href = url;
		//window.open(url,'옵션보기','scrollbars=yes,resizable=yes,width=630,height=500');
	});

});

</script>


<script>
function reSize() {
    try {
        var objBody = auto_iframe.document.body;
        var objFrame = document.all["auto_iframe"];
        ifrmHeight = objBody.scrollHeight + (objBody.offsetHeight - objBody.clientHeight)+"px";
        objFrame.style.height = ifrmHeight;
    }
        catch(e) {}
}

function init_iframe() {
    reSize();
    setTimeout('init_iframe()',1)
}

init_iframe();
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">게시판관리</div>
	  <div class="panel-body">
		 게시판의 생성및 게시물삭제 비번, 기타 등 게시물에 대한 조치를 취하는 곳입니다.<br />
				일부 게시판은 관리자에서 제공되는 쓰기/보기폼이 다를 수 있으므로 이 경우는 웹페이지에서 직접 작성해 주시기 
				바랍니다.<br />
				보드의 삭제 및 그룹변경은 유의를 하셔야 하며 보드삭제는 <a href="../wizboard/index.php">이곳</a>을 
				클릭하신 후 진행하시면됩니다.
	  </div>
	</div>
</div>
<table class="table_outline">
	<tr>
		<td>
			<div class="space20"></div>
			<?
if($AdminBID)
{
 //include ("./boardlist.php");
?>
			<iframe src="../wizboard.php?adminmode=true&BID=<?=$AdminBID?>&GID=<? echo $AdminGID; ?>" height="800" frameborder="0" framespacing="0" name="auto_iframe" id="auto_iframe" scrolling="no" class="w100p"></iframe>
			<div class="space20"></div>
			<?
}else{
?>
			<!-- board List End -->
			<form  action="<?=$PHP_SELF?>" method="post">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value="<?=$theme?>">
				<input type="hidden" name="GID" value="<? echo $GID; ?>">
				<input type="hidden" name="create_table" value="makeit">
				<table class="table">
					<tr >
						<th>테이블이름</th>
						<td><input name="m_bid"></td>
						<th>테이블설명</th>
						<td><input name="TABLE_DES"></td>
						<th>패스워드</th>
						<td><input name="Pass" type="password" size=15 maxlength=15></td>
						<td><button type="submit" class="btn btn-primary">생성</button></td>
					</tr>
				</table>
			</form>
			<br />
			<table id="list1"></table>
<div id="pager1"></div>
			<?
      }
	  ?></td>
	</tr>
</table>
