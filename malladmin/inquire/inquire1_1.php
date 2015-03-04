<?php
	$result=$dbcon->_query("select * from wizInquire where uid='$uid'");
	$list=$dbcon->_fetch_array($result);
	$list[contents]=nl2br($list["contents"]);
	$attached=explode("|", $list["attached"]);
?>
<script language="JavaScript">
	function DELETE_THIS(uid,cp,iid,theme,menushow){
	window.open("./inquire/inquire_del.php?uid="+uid+"&cp="+cp+"&iid="+iid+"&theme="+theme+"&menushow="+menushow,"","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350")
	}

	function down(filename){
		//location.href = "./download.php?url=../config/uploadfolder/etc/&filename="+filename;
		location.href = "./download.php?type=inquire&filename="+filename;
	}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">온라인 의뢰</div>
	  <div class="panel-body">온라인 의뢰를 보실 수 있습니다.
	  </div>
	</div>
	
<table class="table">
				<col width="100" />
				<col width="*" />
				<tr>
					<th>회사명</th>
					<td><?=$list["compname"]?></td>
				</tr>
				<tr>
					<th>성명</th>
					<td><?=$list["name"]?></td>
				</tr>
				<tr>
					<th>주민번호</th>
					<td><?=$list["juminno"]?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$list["tel"]?></td>
				</tr>
				<tr>
					<th>휴대폰</th>
					<td><?=$list["hand"]?></td>
				</tr>
				<tr>
					<th>팩스</th>
					<td><?=$list["fax"]?></td>
				</tr>
				<tr>
					<th>email</th>
					<td><?=$list["email"]?></td>
				</tr>
				<tr>
					<th>url</th>
					<td><?=$list["url"]?></td>
				</tr>
				<tr>
					<th>주소</th>
					<td><?=$list["zip"]?>
						<br />
						<?=$list["address1"]?>
						<br />
						<?=$list["address2"]?>
					</td>
				</tr>
				<tr>
					<th>contents</th>
					<td><?=$list["contents"]?></td>
				</tr>
				<tr>
					<th>첨부</th>
					<td><a href="javascript:down('<? echo $attached[0];?>', '<? echo $iid;?>');"><?=$common->getImgName($attached[0])?></a></td>
				</tr>
			</table>
			<div class="btn_box">
				<button type="button" class="btn btn-primary" onClick="javascript:DELETE_THIS('<?=$uid;?>','<?=$cp;?>','<?=$iid;?>','<?=$theme;?>','<?=$menushow?>');">삭 제</button>
				<button type="button" class="btn btn-primary" onClick="javascript:location.replace('./main.php?menushow=<?=$menushow?>&theme=inquire/inquire1&cp=<?=$cp?>&iid=<?=$iid?>');">리스트</button>
			</div>
	
</div>
