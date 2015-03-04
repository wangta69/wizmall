<script language="JavaScript">
<!--
	function DELETE_THIS(uid,cp,iid,theme,menushow){
		window.open("./inquire/inquire_del.php?uid="+uid+"&cp="+cp+"&iid="+iid+"&theme="+theme+"&menushow="+menushow,"","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350")
	}
	function down(filename){
		location.href = "./download.php?url=../config/uploadfolder/etc/&filename="+filename;
	}
//-->
</script>
<?
	$result=$dbcon->_query("select * from wizInquire where uid='$uid'");
	$list=$dbcon->_fetch_array($result);
	$list[contents]=nl2br($list[contents]);
	$attached=explode("|", $list[attached]);
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">문의사항</div>
	  <div class="panel-body">
		 A/S 문의를 보실 수 있습니다.
	  </div>
	</div>
</div>
<table>
  <tr> 
    <td> </td>
    <td> 
						<p></p>	
					    <table class="txt">
        
          <td>회사명</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[compname]?>
            &nbsp;&nbsp;</td>
        </tr>
        
          <td>성명</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[name]?>
          </td>
        </tr>
        
          <td>주민번호</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[juminno]?>
          </td>
        </tr>
        
          <td>전화번호</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[tel]?>
          </td>
        </tr>
        
          <td>휴대폰</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[hand]?>
          </td>
        </tr>
        
        <tr> 
          <td>팩스</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[fax]?>
          </td>
        </tr>
        
          <td>email</td>

          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[email]?>
          </td>
        </tr>
        
          <td>url</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> &nbsp; 
            <?=$list[url]?>
          </td>
        </tr>
        <td rowspan="3">주소</td>
        <td rowspan="3"><img src="images/com-line1.gif" height="10"></td>
        <td> &nbsp; 
          <?=$list[zip]?>
        </tr>
        <tr> 
          <td> &nbsp; 
            <?=$list[address1]?>
          </td>
        </tr>
        <tr> 
          <td> &nbsp; 
            <?=$list[address2]?>
          </td>
        </tr>
        
          <td>contents</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> 
            <?=$list[contents]?>
            &nbsp;</td>
        </tr>
        
          <td>첨부</td>
          <td><img src="images/com-line1.gif" height="10"></td>
          <td> <a href="javascript:down(<? echo $attached[0];?>, <? echo $iid;?>);"><? echo $attached[0];?></a></td>
        </tr>
        <tr> 
          <td colspan="3"></tr>
      </table>
      <table>
        <tr> 
          <td><input type="button" name="Button" value="삭 제" onClick="javascript:DELETE_THIS('<?=$uid;?>','<?=$cp;?>','<?=$iid;?>','<?=$theme;?>','<?=$menushow?>');" style="cursor:pointer";> 
            &nbsp; <input type="button" name="Submit2" value="리스트" onClick="javascript:location.replace('./main.php?menushow=<?=$menushow?>&theme=inquire/inquire2&cp=<?=$cp?>&iid=<?=$iid?>');" style="cursor:pointer";> 
          </td>
        </tr>
      </table></td>
  </tr>
</table>
