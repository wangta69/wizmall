<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***
*/
include ("../common/header_pop.php");
include ("../../config/common_array.php");

if($query == "d_update"){

}else if($query == "d_insert"){
	
}else if($query == "d_delete"){

}

?>
<script>
$(function(){
	$("#btn_bank_save").click(function(){
		$.post("./proc/proc.php", {smode:"qin", t_page:"bankinfo"
			, bankname:$("#input_bankname").val()
			, account_no:$("#input_account_no").val()
			, account_owner:$("#input_account_owner").val()		
			}, 
			function(data){
				//alert(data);
				loadbankList();
		});
	});
	
	$(".btn_bank_up").click(function(){
		var uid = $(this).attr("uid");
		var index = $(".btn_bank_up").index(this);
		var bankname		= $(".bankname").eq(index).val();
		var account_no		= $(".account_no").eq(index).val();
		var account_owner	= $(".account_owner").eq(index).val();
		
		
		$.post("./proc/proc.php", {smode:"qup", t_page:"bankinfo", uid:uid
			, bankname:bankname
			, account_no:account_no
			, account_owner:account_owner	
			}, 
			function(data){
				loadbankList();
		});
	});
	
	$(".btn_bank_del").click(function(){
		var uid = $(this).attr("uid");
	
		$.post("./proc/proc.php", {smode:"qde", t_page:"bankinfo", uid:uid}, 
			function(data){
				loadbankList();
		});
	});
			
});
	function qryStatus(uid, qry){
		var f = document.PublicForm;
		f.uid.value = uid;
		f.query.value = qry;
		f.submit();
	}
</script>

<table class="table table-hover">
        <tr class="active"> 
          <th class="text-center">은행명</th>
          <th class="text-center">계좌번호</th>
          <th class="text-center">예금주</th>
          <th>&nbsp;</th>
        </tr>   
       
<?
$sqlstr = "select * from wizaccount order by uid asc";
$dbcon->_query($sqlstr);
while($list =$dbcon->_fetch_array()):
	$uid			= $list["uid"];
	$bankname		= $list["bankname"];
	$account_no		= $list["account_no"];
	$account_owner	= $list["account_owner"];

?>         
        <tr> 
          <td class="tr"><select name="bankname" class="bankname w100p">
            <option value="">은행명</option>
<?
foreach($bankinfo as $value){
	$selected = $bankname == $value ? " selected":"";
	echo "<option value='$value'$selected>$value</option>\n";
}
?>            
          </select></td>
          <td><input name="account_no" type="text" class="account_no w100p" value="<?=$account_no?>"></td>
          <td><input name="account_owner" type="text" class="account_owner w100p" value="<?=$account_owner?>"></td>
          <td>
          	<button type="button" class="btn btn-default btn-xs btn_bank_up" uid="<?=$uid?>">수정</button>
          	<button type="button" class="btn btn-default btn-xs btn_bank_del" uid="<?=$uid?>">삭제</button>
		  </td>
        </tr>  
<?
endwhile;
?>  
 
        <tr> 
          <td><select name="input_bankname" id="input_bankname" class="w100p">
            <option value="">은행명</option>
<?
foreach($bankinfo as $value){
	echo "<option value='$value'>$value</option>\n";
}
?>            
          </select>
          </td>
          <td><input name="input_account_no" type="text" id="input_account_no" class="w100p" ></td>
          <td><input name="input_account_owner" type="text" id="input_account_owner" class="w100p"></td>
          <td>

			<button type="button" class="btn btn-default btn-xs" id="btn_bank_save">등록</button>
          </td>
        </tr>               
</table>