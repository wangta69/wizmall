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

if ($query == "search") {
	if ($stitle == "m.mid" || $stitle == "m.mname") {
		$sqlstr = "select m.mid,m.mname,i.jumin1,i.jumin2 from wizMembers m left join wizMembers_ind i on m.mid = i.id where $stitle like '%$keyword%'";
	} else if ($sort == "CompName" || $sort == "CompID") {
		$sqlstr = "select CompID, CompName, CompPreName from wizCom where $sort like '%$keyword%'";
	}
	$dbcon -> _query($sqlstr);
}
$title = "회원정보찾기";
include "../common/header_html.php";
?>

<script>
	function Copy(id) {
		top.opener.document.Jumun.order_id.value = id;
		// close this window
		window.close();

	}
</script>


<body>
<span>회원찾기 아이디 찾기</span> 
<table>
    <tr> 
      <td><table>
<form action="<?=$PHP_SELF ?>">
	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
<input type="hidden" name="query" value="search">	  
          <tr> 
            <td><select name="stitle">
                <option value="m.mname" <?
				if ($sort == "m.mname")
					echo "selected";
			?>>이름으로 찾기</option>
				<option value="m.mid" <?
					if ($sort == "m.mid")
						echo "selected";
				?>>아이디입력</option>
				
              </select></td>
            <td><input name="keyword" type="text" id="keyword"></td>
            <td><input type="submit" name="Submit" value="찾기"></td>
          </tr>
</form>
        </table></td>
    </tr>
<? if($query == "search"): ?>	
    <tr> 
      <td><table>
          <tr> 
            <th>아이디</th>
            <th>이름</th>
            <th>주민번호</th>
          </tr>
<?
$cnt=0;
while($list =$dbcon->_fetch_array()):
?>
          <tr> 
            <td><a  href="javascript: Copy('<?=$list[mid] ?>')"> <?=$list[mid] ?></a><a  href="javascript: Copy('<?=$list[CompID] ?>')"> <?=$list[CompID] ?></a></td>
            <td><?=$list[mname] ?><?=$list[CompPreName] ?></td>
            <td><?=$list[jumin1] ?> - <?=$list[jumin2] ?></td>
          </tr>
          <?
		$cnt++;
		endwhile;
		if(!$cnt):/* 게시물이 존재하지 않을 경우 */
	?>
          <tr> 
            <td colspan="3">데이타가 존재하지 않습니다.</td>
          </tr>
          <?
		endif;
	?>
        </table></td>
    </tr>
<? endif; ?>	
  
</table>
</body>
</html>
