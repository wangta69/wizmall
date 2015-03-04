<?php
/*
 제작자 : 폰돌
 제작자 URL : http://www.shop-wiz.com
 제작자 Email : master@shop-wiz.com
 Free Distributer
 *** Updating List ***
 */

include "../lib/inc.depth1.php";

include "../config/wizboard/table/config.php";
include "../config/wizboard/table/prohibit_ip_list.php";

//로그인 책크 부분 시작
$common -> pub_path = "../";
$cfg["member"] = $common -> getLogininfo();
//로그인 정보를 가져옮
include ("./admin_check.php");
// 로그인 책크 부분 끝
$groupid = $_GET["groupid"] ? $_GET["groupid"]:$_POST["groupid"];

include "../lib/class.board.php";
$board = new board();
$board -> get_object($dbcon, $common);

if (!$GID)
	$GID = "root";
if (!$m_gid)
	$m_gid = "root";
//예약그룹, root:게시판용(일반, 쇼핑몰, 아바타용), intra:(인트라용, 웹메일용), cafe:카페용

switch($smode){
	case "make_grp"://그룹만들기
		if ($chg_name == "1") {
		$sqlstr = "update wizTable_Grp set GrpName = '".$groupname."' where GID = '".$groupid."'";
		$dbcon -> _query($sqlstr);
		$common -> js_location("$PHP_SELF");
		} else {
			$sqlstr = "select count(*) from wizTable_Grp where GID = '".$groupid."'";
			$result = $dbcon -> get_one($sqlstr);
			if ($result) {
				$common -> js_alert("코드가 중복되었습니다..");
			} else {
				$Mdate = time();
				unset($ins);
				$ins["GID"]	= $groupid;
				$ins["AdminName"]	= $AdminName;
				$ins["Pass"]	= $Pass;
				$ins["Grade"]	= $Grade;
				$ins["GrpName"]	= $groupname;
				$ins["Mdate"]	= $Mdate;
				
				$dbcon -> insertData("wizTable_Grp", $ins);
				$common -> js_alert("새그룹 ".$groupname." 이 생성되었습니다.", $PHP_SELF);
			}
		}
		break;
	case "del_group"://그룹 삭제 하기
		/* 현재 그룹에 속한 테이블의 유무를 책크후 테이블이 있으면 back 시킨다. */
		$sqlstr = "select count(*) from wizTable_Main where GID = '".$d_gid."'";
		$result = $dbcon -> get_one($sqlstr);
		if ($result)
			$common -> js_alert("그룹에 속한 테이블이 있습니다. \\n\\n 먼저 테이블을 삭제 후 작업을 진행해 주세요 \\n\\n");

		/* wizTable_Grp 로 부터 그룹명을 삭제한다. */
		$sqlstr = "delete from wizTable_Grp where GID='".$d_gid."'";
		$dbcon -> _query($sqlstr);
		$common -> js_location("$PHP_SELF");
		break;
	case "maketable"://테이블 생성
		$board -> createTable($m_bid, $m_gid, $TABLE_DES, $AdminName, $Pass, $groupid);
		break;



}
?>
<!DOCTYPE html>
<html lang="kr">
	<head>
		<title>관리자님을 환영합니다.[위즈보드 관리자모드]</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"] ?>">
		<script type="text/javascript"  src="../js/jquery.min.js"></script>
		<script type="text/javascript"  src="../js/wizmall.js"></script>
		<script type="text/javascript"  src="../js/jquery.plugins/jquery.validator-1.0.1.js"></script>
		<script type="text/javascript"  src="../js/jquery.plugins/jqalerts/jquery.alerts.js"></script>
		<script type="text/javascript" src="../js/bootstrap/js/bootstrap.min.js"></script>
		
		<script type="text/javascript"> 
					$(function(){
			$(".altern th:odd").addClass("bg3"); //basic이라는 클래스네임을 가진 요소의 tr 요소 중 홀수번째에 bg1클래스 부여
			$(".altern th:even").addClass("bg4");
			$(".list tr:odd").addClass("bg1");
			$(".list tr:even").addClass("bg2");
		 
		 	$("#btn_global").toggle(function(){
				$("#globalcfg").show();
			}, function(){
				$("#globalcfg").hide();
			});
			
			//추천 비추천 할당수
			$("#btn_global1").click(function(){
				var rccomper = $("#rccomPer").val();
				$.post("../lib/ajax.admin.board.php", {smode:"mkcfg",rccomper:rccomper}, function (data){
					//alert("적용되었습니다.");
				});
			});
			
			//금지 아이피
			$("#btn_prohibit_ip").click(function(){
				var prohibit_ip = $("#prohibit_ip").val();
				$.post("../lib/ajax.admin.board.php", {smode:"prohibit_ip_list",prohibit_ip:prohibit_ip}, function (data){
					alert(data);
				});
			});	
		
			//옵션수정
			$(".btn_op_manage").click(function(){
				var bid = $(this).attr("bid");
				var gid = $(this).attr("gid");
				wizwindow("./admin1.php?BID="+bid+"&GID="+gid, "option_window", "scrollbars=yes,resizable=yes,width=630,height=600");
			});
			//테이블 설명 및 패스워드 변경
			$(".btn_change").click(function(){
				var i			= $(".btn_change").index(this);
				var boarddes	= $(".boarddes").eq(i).val();
				var adminname;
				var pass		= $(".pass").eq(i).val();
				var uid			= $(this).attr("uid");
				$.post("./admin_proc.php", {smode:"change_des", boarddes:boarddes, adminname:adminname, pass:pass, uid:uid }, function(){
					alert("변경되었습니다.");
					//jAlert("변경되었습니다.");		
				});
			});
		
		});
		
		
		function DeleteThisTable(BID,GID,cp, ListCount){
			con =  confirm("정말로 삭제하시겠습니까? \n\n 삭제된 테이블은 복구불가능합니다.")
			if (con==true){
				window.open("./tabledelete.php?BID="+BID+"&GID="+GID+"&cp="+cp+"&ListCount="+ListCount+"&mode=ok","","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350");
			}
		}
		
		function delete_group(gid){
			con = confirm("그룹을 삭제합니다. \n\n 그룹삭제전 테이블을 먼저 삭제하셔야 합니다.. \n\n 그룹을 삭제하시겠습니까?")
			if (con==true)
			{
				location.href="<?php echo $PHP_SELF; ?>?smode=del_group&d_gid="+gid;
			}
			else return false;
		}

		function downforExel(){
			location.href="downforexcel.php?DownForExel=yes";
		}

		function gotoURL(url){
			window.open(url,'','')
		}

		function checkGroupForm(f){
			if(autoCheckForm(f)){
				return true;
			}else{
				return false;
			}
		}

		function gotoPage(cp){
			$("#cp").val(cp);
			$("#sform").submit();
		}
</script>
		<link rel="stylesheet" type="text/css" href="../css/base.css" />
		<link rel="stylesheet" href="../css/admin.board.css" type="text/css">
		<link rel="stylesheet" href="../js/jquery.plugins/jqalerts/jquery.alerts.css" type="text/css" />
		<link href="../js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>
<div id="body">
	
	<div class="text-right">
		<a href="../" target="_blank">홈</a></span> | <a href="admin_log_out.php">로그아웃</a>
	</div>
	
	<div class="row">
		<div class="col-lg-2">
			
			<span class="b">그룹관리</span>
			<ul class="list-group">
<?php
$sqlstr = "select count(1) from wizTable_Main where Grade <> 'A'";
$tcount = $dbcon -> get_one($sqlstr);
?>
			<li class="list-group-item">
				<a href="<?php echo $PHP_SELF ?>?ListCount=<?php echo $ListCount ?>">전체보드리스트<?php echo "(" . number_format($tcount) . ")"; ?></a>
			</li>
<?php
$sqlstr = "select GID, GrpName, GrpCode from wizTable_Grp order by GrpName asc";
$result = $dbcon->_query($sqlstr);
$cnt=0;
while($list = $dbcon->_fetch_array($result)):
	$count = $dbcon->get_one("select count(*) from wizTable_Main where GID = '".$list["GID"]."'");
?>
			<li class="list-group-item">
				<a href="<?php echo $PHP_SELF ?>?groupid=<?php echo $list["GID"] ?>&groupname=<?php echo $list["GrpName"] ?>">
				<?
					if ($Grp == $list["GID"])
						echo "<b>";
				?>
				<?php echo $list["GrpName"] ?>
				:
				<?php echo $list["GID"] ?>
				
				<?php echo "(" . number_format($count) . ")"; ?>
				</a>
				<button type="button" name="btn" onClick="delete_group('<?php echo $list["GID"]; ?>')" title="그룹삭제" class="btn btn-default btn-xs">삭제</button>
			</li>
<?php
$cnt++;
endwhile;
?>
			</ul>
			<form name="make_grp" metbod="post" onsubmit="return checkGroupForm(this);">
				<input type="hidden" name="smode" value="make_grp">
				그룹아이디 :
				<input name="groupid" type="text" size="10" checkenable msg="그룹아이디를 입력하세요" value="<?php echo $groupid; ?>">
				<br>
				그룹명 :
				<input name="groupname" type="text" size="10" checkenable msg="그룹명을 입력하세요" value="<?php echo $groupname; ?>">
				<input type="checkbox" name="chg_name" id="chg_name" value="1">
				이름변경<br>
				<button type="submit" name="Submit" id="button">그룹생성/그룹명변경</button>
			</form>
		</div><!-- col-lg-4 -->
		<div class="col-lg-10">
			
			<form action="<?php echo $PHP_SELF ?>" method="post" name="CreateForm">
				<input type="hidden" name="smode" value="maketable">
				<input type="hidden" name="ListCount" value="<?php echo $ListCount ?>">
				<input type="hidden" name="groupid" value="<?php echo $groupid ?>">
				<input type="hidden" name="groupname" value="<?php echo $groupname ?>">
				<table class="table_main">
					<tr>
						<th>그룹</th>
						<td><select name="m_gid" id="select">
<?php
$sqlstr = "select GID from wizTable_Grp order by GrpName asc";
$result = $dbcon->_query($sqlstr);
$cnt=0;
while($list = $dbcon->_fetch_array($result)):
$selected = $list["GID"] == $groupid ? " selected":"";
?>
							<option value="<?php echo $list["GID"] ?>"<?php echo $selected ?>>
							<?php echo $list["GID"] ?>
							</option>
<?php
endwhile;
?>
								</select></td>
							<th>아이디</th>
							<td><input type="text" name="m_bid" onKeyUp="javascript:onlyAlphaNum(this);">
								<br>
								영/숫자만 입력</td>
							<th> 테이블설명</th>
							<td><input type="text" name="TABLE_DES">
							</td>
							<th>패스워드</th>
							<td><input type="text" name="Pass">
							</td>
							<td><button type="submit" name="btn" title="생성">생성</button></td>
						</tr>
					</table>
				</form>
				
					<div class="space15">
					<form action="<?php echo $PHP_SELF ?>" name="ListCountForm" id="sform" method="get">
						<input type="hidden" name="groupid" value="<?php echo $groupid ?>">
						<input type="hidden" name="cp" id="cp" value="<?php echo $cp ?>">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>리스트수:
								
									<select name="ListCount" onChange="submit()">
									<?php
									$listArr	= array(10, 15, 20, 30, 50, 100);
									foreach($listArr as $key => $val){
										$selected	= $ListCount == $val ? " selected":"";

										echo '<option value="'.$val.'"'.$selected.'>'.$val.'</option>';
									}
									?>
									</select>
									<select name="stitle">
										<option value="BoardDes" <?php
										if ($stitle == "BoardDesd")
											echo "selected";
									?>>테이블설명</option>
										<option value="BID" <?php
											if ($stitle == "BID")
												echo "selected";
										?>>테이블명</option>
									</select>
									<input type="text" name="keyword" value="<?php echo $keyword ?>">
									<input type="submit" name="Submit3" value="검색"></td>
							</tr>
						</table>
					</form>
					
					
					<span class="button bull" id="btn_global"><a>전체환경변수설정</a></span>
					<div id="globalcfg" class="hide"> 전체게시물당 추천/비추천 포인트 할당 수
						<input name="rccomPer" type="text" id="rccomPer" value="<?php echo $cfg["wizboard"]["rccomPer"] ?>" />
						<span class="button bull" id="btn_global1"><a>확인</a></span> <br />
						점근 금지 IP
						<textarea name="prohibit_ip" id="prohibit_ip"><?php
							if (is_array($prohibit_ip))
								foreach ($prohibit_ip as $key => $val) {echo $val . "\n";
								}
						?>
		</textarea>
						<span class="button bull" id="btn_prohibit_ip"><a>확인</a></span> </div>
		<?php
		if ($groupid)
			$whereis = "WHERE Grade != 'A' AND GID='".$groupid."'";
		
else
			$whereis = "WHERE Grade != 'A' ";

		//echo $whereis;
		if ($stitle && $keyword)
			$whereis .= "and ".$stitle." like '%".$keyword."%'";
		$TargetBoard = "wizTable_Main";
		/* 총 갯수 구하기 */
		$TOTAL_STR = "SELECT count(UID) FROM ".$TargetBoard." ".$whereis;
		$TOTAL = $dbcon -> get_one($TOTAL_STR);
		if (!isset($ListCount) || !$ListCount)
			$ListCount = 10;
		$ListNo = $ListCount;
		/* 페이지당 출력 리스트 수 */
		$PageNo = 10;
		/* 페이지 밑의 출력 수 */
		if (empty($cp) || $cp <= 0)
			$cp = 1;
		?>
					<p class="text-right">
						<button name="btn" onClick="downforExel();" title="엑셀출력">엑셀출력</button></td>
					</p>
					<table class="table table-hover table-striped">
						<col width="60" />
						<col width="70" />
						<col width="70" />
						<col width="100" />
						<col width="*" />
						<col width="80" />
						<col width="80" />
						<col width="80" />
						<col width="100" />
						<col width="60" />
						<col width="60" />
						<thead>
							<tr class="active">
								<th>그룹</th>
								<th>테이블명</th>
								<th>테이블설명</th>
								<th>패스워드</th>
								<th>경로</th>
								<th>적용스킨</th>
								<th>수정</th>
								<th>옵션</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
		<?php 
		$START_NO = ($cp - 1) * $ListNo;
		$BOARD_NO=$TOTAL-($ListNo*($cp-1));
		
		$orderby = "BID@ASC";
		//$dbcon->debug = true;
		$qry = $dbcon->get_select('*',$TargetBoard,$whereis, $orderby, $START_NO, $ListNo);	
		$cnt=0;
		while( $BOARD_LIST = $dbcon->_fetch_array($qry)) :
		include "../config/wizboard/table/".$BOARD_LIST["GID"]."/".$BOARD_LIST["BID"]."/config.php";
		?>
							<tr>
								<td>
									<?php echo $BOARD_LIST["GID"] ?>
								</td>
								<td>
									<?php echo $BOARD_LIST["BID"] ?>
								</td>
								<td>
									<input type="text" name="BoardDes" class="boarddes w100" value="<?php echo $BOARD_LIST["BoardDes"] ?>">
								</td>
								<td>
									<input type="text" name="Pass" class="pass w100" value="<?php echo $BOARD_LIST["Pass"] ?>" >
								</td>
								<td>
									wizboard.php?BID=<?php echo $BOARD_LIST["BID"]; ?>&GID=<?php echo  $BOARD_LIST["GID"]; ?>
								</td>
								<td>
									<?php echo $cfg["wizboard"]["BOARD_SKIN_TYPE"] ?>
								</td>
								<td>
									<button type="button" class="btn btn-default btn-xs btn_change" uid="<?php echo $BOARD_LIST["UID"] ?>">변경</button>
								</td>
								<td>
		  							<button type="button" class="btn btn-default btn-xs btn_op_manage" bid="<?php echo $BOARD_LIST["BID"] ?>" gid="<?php echo $BOARD_LIST["GID"] ?>">옵션수정</button>
		  						</td>
								<td>
									<button type="button" name="btn" onClick="gotoURL('<?php echo $PHP_SELF;?>?AdminBID=<?php echo $BOARD_LIST["BID"] ?>&AdminGID=<?php echo $BOARD_LIST["GID"] ?>&cp=<?php echo $cp ?>&Grp=<?php echo $Grp ?>&ListCount=<?php echo $ListCount ?>&stitle=<?php echo $stitle ?>&keyword=<?php echo $keyword ?>');" title="게시물관리" class="btn btn-default btn-xs">게시물관리</button>
								</td>
								<td>
									<button type="button" name="btn" onClick="gotoURL('../wizboard.php?BID=<?php echo $BOARD_LIST["BID"] ?>&GID=<?php echo $BOARD_LIST["GID"] ?>');" title="옵션 처리" class="btn btn-default btn-xs">보기</button>
								</td>
								<td>
									<button type="button" name="btn" onClick="DeleteThisTable('<?php echo $BOARD_LIST["BID"]; ?>','<?php echo $BOARD_LIST["GID"]; ?>','<?php echo $cp; ?>','<?php echo $ListCount ?>')" title="옵션 처리" class="btn btn-default btn-xs">삭제</button>
								</td>
							</tr>
		<?php
		endwhile;
		?>
						</tbody>
					</table>
					<div class="paging_box">
		<?php
		$params = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL, "type" => "bootstrappost");
		echo $common -> paging($params);
		?>
					</div>
					<div>
<?php
if($AdminBID && $AdminGID):
?>
<iframe src="../wizboard.php?adminmode=true&BID=<?php echo $AdminBID ?>&GID=<?php echo $AdminGID; ?>" height="800" frameborder="0" framespacing="0" name="auto_iframe" id="auto_iframe" scrolling="no" class="w100p"></iframe>
<?php
endif;
?>
					</div></td>
				</tr>
			</table>
				</div><!-- col-lg-8 -->
		
		
			</div><!-- row -->
		</div>
	</body>
</html>
