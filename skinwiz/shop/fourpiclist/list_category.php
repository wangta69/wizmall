<dl class="m_cat">
<dt><?php echo $mall->navy_title?></dt>
<dd><ul>
<?php
//ī�װ?�� ��ϵ� ��ǰ�� ���ϱ�
$cntstr = "select sum(pcnt) as pcnt, cat_no from wizCategory ".$mall->categoryCntWhere." group by cat_no";
unset($pdcntArr);
$cntqry = $dbcon->_query($cntstr);
while($cntlist = $dbcon->_fetch_array($cntqry)):
	$cat_no = $cntlist["cat_no"];
	$pcnt = $cntlist["pcnt"];
	$pdcntArr[$cat_no] = $pcnt;
endwhile;

// ī�װ? ����Ʈ ���ϱ�
$catstr = "select cat_name, cat_no from wizCategory ".$mall->categoryWhere;
$catqry = $dbcon->_query($catstr);
$cnt=0;
while($list = $dbcon->_fetch_array($catqry)){
	$cat_name = $list["cat_name"];
	$cat_no = $list["cat_no"];
	$pcdnt = 0;
	
	//echo "count = ".count($pdcntArr)."<br />";
	foreach($pdcntArr as $key=>$value){	
		$substrlen = (strlen(intval($cat_no))/2)*2;
	//echo "<br />cat_no = $cat_no ,key = $key , substrlen = ".((strlen(intval($cat_no))/2)*2)." <br />";
		if(substr($key, -$substrlen)  == $cat_no) $pcdnt += $value;
	}

		
//if($cnt%4) echo "<td> |  </td>";
?>        
          <li><a href="wizmart.php?code=<?php echo $cat_no;?>"><?php echo $cat_name;?></a><? echo "(".$pcdnt.")"?> </li>
<?php
//$cnt++;
//if(!($cnt%4)) echo "</tr><tr>";
}//while($list = $dbcon->_fetch_array($catqry)){
//$tmpcnt = $NO%4;
//if($tmpcnt){
//	for($i=$tmpcnt; $i<4; $i++){
//		echo "<td></td><td></td>";
//	}
//}
?> </ul></dd>
</dl>
