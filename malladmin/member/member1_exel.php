<?
/* 
powered by ��
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../common/header_pop.php";
include "../../config/common_array.php";

/* ������ ����ϱ� */ 
if($DownForExel=="yes"){
$Thistime = date("Y-m-d");
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=${Thistime}.xls" ); 
header( "Content-Description: PHP4 Generated Data" ); 

$cfg["common"]["lan"] = "ks_c_5601-1987";//������½� ���� �V
header("Content-Type: text/html; charset=".$cfg["common"]["lan"]);
}

$whereis = " WHERE 1";
if($grade) $whereis .= " and m.mgrade = '$grade'";
if($grantsta == "00") $whereis .= " and m.mgrantsta = '$grantsta'";

if ($stitle && $keyword) {
                $whereis .= " and $stitle LIKE '%$keyword%'";
}

if (!$sel_orderby) {$orderby = "m.uid@desc";}
else $orderby = $sel_orderby;


if ($DataEnable) {
	$FromDate = mktime(0,0,0,"$SMonth","$SDay","$SYear");
	$ToDate =  mktime(0,0,0,"$FMonth","$FDay","$FYear");
	$whereis .= " AND m.mregdate  >= '$FromDate' AND m.mregdate <= '$ToDate'";
}
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
<style id="2004-08-11 1 _14925_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.font514925
	{color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;}
.xl1514925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����;
	mso-generic-font-family:auto;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl2314925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:silver;
	mso-pattern:auto none;
	white-space:normal;}
.xl2414925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	background:silver;
	mso-pattern:auto none;
	white-space:normal;}
.xl2514925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����;
	mso-generic-font-family:auto;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2614925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2714925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:"0_ ";
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2814925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2914925
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
ruby
	{ruby-align:left;}
rt
	{color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:����, monospace;
	mso-font-charset:129;
	mso-char-type:none;}
-->
</style>
</head>

<body>

<div id="2004-08-11 1 _14925" x:publishsource="Excel">

<table x:str9 style='border-collapse:
 collapse;table-layout:fixed;width:984pt'>
 <col width=38 style='mso-width-source:userset;mso-width-alt:1080;width:29pt'>
 <col width=88 span=2 style='mso-width-source:userset;mso-width-alt:2503;
 width:66pt'>
 <col width=61 style='mso-width-source:userset;mso-width-alt:1735;width:46pt'>
 <col width=76 style='mso-width-source:userset;mso-width-alt:2161;width:57pt'>
 <col width=69 span=2 style='mso-width-source:userset;mso-width-alt:1962;
 width:52pt'>
 <col width=280 style='mso-width-source:userset;mso-width-alt:7964;width:210pt'>
 <col width=126 style='mso-width-source:userset;mso-width-alt:3584;width:95pt'>
 <col width=84 style='mso-width-source:userset;mso-width-alt:2389;width:63pt'>
 <col0 style='mso-width-source:userset;mso-width-alt:2560;width:68pt'>
 <col width=240 style='mso-width-source:userset;mso-width-alt:6826;width:180pt'>
 <tr height=26 style='mso-height-source:userset;height:19.9pt'>
  <td height=26 class=xl2314925 width=38 style='height:19.9pt;width:29pt'>��ȣ</td>
  <td class=xl2314925 width=88 style='border-left:none;width:66pt'>�̸�</td>
  <td class=xl2414925 width=88 style='width:66pt'>���̵�</td>
  <td class=xl2414925 width=61 style='width:46pt'>����</td>
  <td class=xl2314925 width=76 style='border-left:none;width:57pt'>����</td>
  <td class=xl2314925 width=69 style='border-left:none;width:52pt'>������</td>
  <td class=xl2314925 width=69 style='border-left:none;width:52pt'>�����ȣ</td>
  <td class=xl2314925 width=280 style='border-left:none;width:210pt'>�ּ�</td>
  <td class=xl2314925 width=126 style='border-left:none;width:95pt'>���ּ�</td>
  <td class=xl2314925 width=84 style='border-left:none;width:63pt'>��ȭ��ȣ</td>
  <td class=xl23149250 style='border-left:none;width:68pt'>�ڵ����ȣ</td>
  <td class=xl2314925 width=240 style='border-left:none;width:180pt'>�̸���</td>
 </tr>
<?
$NO = $TOTAL-($ListNo*($cp-1));
$dbcon->get_select('m.*, i.*','wizMembers m left join wizMembers_ind i on m.mid  =  i.id',$whereis, $orderby);	
while( $list = $dbcon->_fetch_array( ) ) :
        $list[Address1] = trim($list[Address1]);
        $ZONE = explode(" ", $list[Address1]);
		if(substr($list[Jumin2],0,1) == 1 || substr($list[Jumin2],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
		$age = date("Y") - (substr($list[Jumin1],0,2) + $BirthCentury);
		$mgrade = $list["mgrade"];
		$mgradestr = $gradetostr_info[$mgrade]?$gradetostr_info[$mgrade]:$mgrade;
       
?> 
 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 class=xl2614925 width=38 style='height:24.0pt;width:29pt' x:num><?=$NO?></td>
  <td class=xl2714925 width=88 style='width:66pt'><?=$list[Name]?></td>
  <td class=xl2714925 width=88 style='width:66pt'><?=$list[ID]?></td>
  <td class=xl2714925 width=61 style='width:46pt'><?=$list[Sex]?></td>
  <td class=xl2714925 width=76 style='width:57pt' x:num="31"><?=$age?></td>
  <td class=xl2714925 width=69 style='width:52pt'><?=date("Y.m.d", $list[RegDate])?></td>
  <td class=xl2714925 width=69 style='width:52pt'><?=$list[Zip1]?></td>
      <td class=xl2714925 width=280 style='width:210pt'>
        <?=$list[Address1]?>
      </td>
      <td class=xl2814925 width=126 style='width:95pt'>��
        <?=$list[Address2]?>
      </td>
  <td class=xl2814925 width=84 style='width:63pt'><?=$list[Tel1]?></td>
  <td class=xl28149250 style='width:68pt'><?=$list[Tel2]?></td>
  <td class=xl2914925 width=240 style='width:180pt'><span style='color:blue;text-decoration:
  underline;text-underline-style:single;font-family:����, monospace;mso-font-charset:
  129'><?=$list[Email]?></span></td>
 </tr>
<?
$NO--; 
endwhile;
?> 
 <tr height=0 style='display:none'>
  <td class=xl2514925 width=38 style='width:29pt'></td>
  <td class=xl2514925 width=88 style='width:66pt'></td>
  <td class=xl2514925 width=88 style='width:66pt'></td>
  <td class=xl2514925 width=61 style='width:46pt'></td>
  <td class=xl2514925 width=76 style='width:57pt'></td>
  <td class=xl2514925 width=69 style='width:52pt'></td>
  <td class=xl2514925 width=69 style='width:52pt'></td>
  <td class=xl2514925 width=280 style='width:210pt'></td>
  <td class=xl2514925 width=126 style='width:95pt'></td>
  <td class=xl2514925 width=84 style='width:63pt'></td>
  <td class=xl25149250 style='width:68pt'></td>
  <td class=xl2514925 width=240 style='width:180pt'></td>
 </tr>
 <tr height=0 style='display:none'>
  <td width=38 style='width:29pt'></td>
  <td width=88 style='width:66pt'></td>
  <td width=88 style='width:66pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=76 style='width:57pt'></td>
  <td width=69 style='width:52pt'></td>
  <td width=69 style='width:52pt'></td>
  <td width=280 style='width:210pt'></td>
  <td width=126 style='width:95pt'></td>
  <td width=84 style='width:63pt'></td>
  <td0 style='width:68pt'></td>
  <td width=240 style='width:180pt'></td>
 </tr>
</table>

</div>

</body>

</html>
