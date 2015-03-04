<?php
include ("../../lib/cfg.common.php");
include ("../../config/db_info.php");

include "../../lib/class.database.php";
$dbcon = new database($cfg["sql"]);

include "../../lib/class.common.php";
$common = new common();
?>
<!DOCTYPE html>
<html lang="kr">
	<head>
		<meta charset="<?=$cfg["common"]["lan"] ?>">
		<title>우편번호찾기</title>
		<script type="text/javascript" src="../../../js/jquery.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery.plugins/selectboxes.js"></script>
		<script type="text/javascript" src="../../../js/pop_resize.js"></script>
		<link type="text/css" rel="stylesheet" href="../../../css/base.css" />
		<link type="text/css" rel="stylesheet" href="../../../js/bootstrap/css/bootstrap.min.css">	
		
		<script>
		var zipcodeskin = "<?php echo $cfg["skin"]["ZipCodeSkin"]; ?>";
        var search_url = zipcodeskin+"/find_street.php";
            
			$(function(){
				switchtype('<?php echo $searchziptype;?>');
				gotoPage();
				
				$(document).on("click", ".btn_street", function(){
					switchtype("street");
					$("#mode").val("");
					gotoPage();
				});
				$(document).on("click", ".btn_address", function(){
					switchtype("address");
					$("#mode").val("");
					gotoPage();
				});
			});
			
			
			function gotoPage(){
				//	alert($(".sform").serialize());
				$.post(search_url, $(".sform").serialize(), function(data){
						$("#bodyHTML").html(data);
				})
			}
			
			function switchtype(arg){
				switch(arg){
					case "address":
						search_url = zipcodeskin+"/find_address.php";
					break;
					default:
						search_url = zipcodeskin+"/find_street.php";
					break;
				}
				$("#searchziptype").val(arg);
			}
			
		</script>
	</head>

	<body>

		<form method="post" class="sform">
				<input type="hidden" name="mode" id="mode" value="">
				<input type="hidden" name="searchziptype" id="searchziptype" value="<?php echo $searchziptype;?>">
				<input type="hidden" name="form" value="<?php echo $form; ?>">
				<input type="hidden" name="zip1" value="<?php echo $zip1; ?>">
				<input type="hidden" name="zip2" value="<?php echo $zip2; ?>">
				<input type="hidden" name="firstaddress" value="<?php echo $firstaddress; ?>">
				<input type="hidden" name="secondaddress" value="<?php echo $secondaddress; ?>">
		</form>
		
		<div id="bodyHTML"></div>
	</body>
</html>
