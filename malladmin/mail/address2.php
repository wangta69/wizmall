<?php
//$user_id = $_COOKIE["WIZMAIL_USER_ID"];
$user_id = "admin";



	switch($query){
		case "groupedit":
			$sql_update = "update wizMailAddressBookG set subject='$groupname' where userid='".$user_id."' and code='$groupcode'";
			$dbcon->_query($sql_update);
			//$segroup = $groupcode;
			//$segroupname = $groupname;
			break;
		case "groupdatadelete":
			$sql_delete = "delete from wizMailAddressBook where userid='".$user_id."' and grp='$segroup'";
			$dbcon->_query($sql_delete);
			break;
		case "groupdelete":
			$sql_delete = "delete from wizMailAddressBookG where userid='".$user_id."' and code='$segroup'";
			$dbcon->_query($sql_delete);
			//$segroup="all";
			//$segroupname="전체그룹";
			break;
		case "groupcreate":
			$sql= "insert into wizMailAddressBookG (userid, subject) values ('$user_id', '$groupname') ";
			//echo $sql;
			$dbcon->_query($sql);
			break;
	}	
		
?>

<script  language='javascript'>
$(function(){
	$(".btn_add_group").click(function(){
		if ($("#newgroupname").val() == '') {
			alert('\n그룹명을 입력해 주세요!\n\n');
			$("#newgroupname").focus();
	        return;
		}else{
			$("#groupname").val($("#newgroupname").val());
			$("#query").val("groupcreate");
			$("#sform").submit();
		}
		
	});
});
function sendit() 
{

    if ($("#tmpgroupname").val() == '') {
        alert('\n그룹명을 입력해 주세요!\n\n');
		$("#tmpgroupname").focus();
        return;
    }else{
	    $("#groupname").val($("#tmpgroupname").val());
	    $("#groupname").val($("#tmpgroupname").val());
	    $("#query").val("groupedit");
		$("#sform").submit();
    }
}

</script>
<form action='<?=$PHP_SELF?>' id='sform' method='get'>
	<input type='hidden' name='menushow' value='<?=$menushow?>'>
	<input type='hidden' name='theme' value='<?=$theme?>'>
	<input type='hidden' name='query' id="query" value='groupedit'>
	<input type='hidden' name='groupcode' id="groupcode"  value=''> 
	<input type='hidden' name='groupname' id="groupname" value=''> 
</form>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">그룹관리</div>
	  <div class="panel-body">
		 
	  </div>
	</div>
	
	<div class="row">
	  <div class="col-lg-4">
	  	
		<ul class="list-group">
			<li class="list-group-item">
				<a href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>'>전체그룹</a>
			</li>
<?php

$sql	= "select * from wizMailAddressBookG where userid='".$user_id."' order by idx asc";
$qry	= $dbcon->_query($sql);
$Total	= $dbcon->_num_rows();

if($Total)
{
	$cnts = 0;
	while($list = $dbcon->_fetch_array($qry))
	{
?>

			<li class="list-group-item">
					<a href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&idx=<?=$list["idx"]?>'> <?=$list["subject"]?></a>
			</li>
<?php
		$cnts = $cnts + 1;
	}
}

?>
		</ul>
		
		<input type="text" id="newgroupname">
		<button type="button" class="btn btn-default btn-xs btn_add_group">그룸추가</button>
		
      	  	
	  </div><!-- col-lg-4" -->
	  
<?php
$qureystr = "g.userid='".$user_id."' ";

if($idx) $qureystr .= "and g.idx='$idx' ";
$sql = "select 
			count(*) as addrcnt, g.idx, g.subject
		from 
			wizMailAddressBookG g
		left join 
			wizMailAddressBook b
		on g.idx = b.grp
		where 
			$qureystr
	
		";
		echo $sql;
$list = $dbcon->get_row($sql);
?>
	  
	  <div class="col-lg-7">
	  	그룹 등록정보 (*)는 필수 입력 사항입니다.
			<table class="table">
				<tr> 
					<th>이름*</td>
					<td>
						<input type='text' id="tmpgroupname"  size='35' value='<?=$list["subject"]?>'>
						<input type='hidden' id="tmpidx"  size='35' value='<?=$list["idx"]?>'>
						<?
						if($idx):
						?>
						<a href='javascript:sendit();' class="btn btn-default">수정</a>
						<?
						endif;
						?>
					</td>
				</tr>
				<tr> 
					<th>등록된사람</td>
					<td><?=$list["addrcnt"]?> 명</td>
				</tr>
<?php
if($segroup != "all"):
?>					
				<tr> 
					<th>데이타삭제</td>
					<td>
	  
						<a href="javascript:if(confirm('\n데이타를 삭제합니다.\n\n그룹에 등록된 모든 데이타가 영구히 삭제됩니다\n\n')){location.href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&query=groupdatadelete&segroup=<?=$segroup?>&segroupname=<?=$segroupname?>';}">데이타 삭제</a>
						(그룹에 등록된 모든 데이타가 영구히 삭제됩니다)
								
					</td>
				</tr>
				<tr> 
					<th>그룹삭제</td>
					<td>
						<a href="javascript:if(confirm('\n그룹을 삭제합니다.\n\n그룹과 그룹에 등록된 모든 데이타가 영구히 삭제됩니다\n\n')){location.href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&query=groupdelete&segroup=<?=$segroup?>&segroupname=<?=$segroupname?>';}">그룹삭제</a>
						(그룹과 그룹에 등록된 모든 데이타가 영구히 삭제됩니다)
									
					</td>
				</tr>
<?php
endif;
?>				
			</table>

	  </div><!--col-lg-8 -->
	</div><!-- row -->


	
	
</div>


