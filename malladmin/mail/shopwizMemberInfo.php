<?php
	$sqlstr = " select m.mname, i.email, m.mailreceive from wizMembers m left join wizMembers_ind i on m.mid = i.id ";
	$orderby = " order by m.uid asc ";
	$whereis = " where 1 and m.mgrantsta = '03' ";
	if($mailreject) $whereis .= " and m.mailreceive = '1' ";
	$limit = " limit $startno, $Roopcnt ";
	
	switch($soption){
		case "all" : 
			$totalstr = $sqlstr.$whereis;
			$sqlstr .= $whereis.$orderby.$limit;
		break;
		case "seq" : 
			$totalstr = $sqlstr.$whereis." and m.uid between $startseq and $stopseq ";
			$sqlstr .= $whereis." and m.uid between $startseq and $stopseq ".$orderby.$limit;
		break;
		case "date" : 
			$totalstr = $sqlstr.$whereis." and m.mregdate  between $startdate' and $stopdate ";
			$sqlstr .= $whereis." and m.mregdate  between $startdate' and $stopdate ".$orderby.$limit;
		break;
		case "gender" : 
			$totalstr = $sqlstr.$whereis." and i.gender = '$genderSelect' ";
			$sqlstr .= $whereis." and i.gender = '$genderSelect' ".$orderby.$limit;
		break;
		case "grade" : 
			$totalstr = $sqlstr.$whereis." and m.mgrade = '$gradeSelect' ";
			$sqlstr .= $whereis." and m.mgrade = '$gradeSelect' ".$orderby.$limit;
		break;	   
	}

		$dbcon->_query($totalstr);
		$totalmail = $dbcon->_num_rows();

		$qry	 = $dbcon->_query($sqlstr);

	$i = 0;
	while($list =$dbcon->_fetch_array($qry)):

		$rName[$i]			= $list["mname"];
		$rEmail[$i]	 			= $list["email"];
		$i++;
	endwhile;