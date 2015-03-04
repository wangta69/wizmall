<html>
<head>
<meta http-equiv="Content-Type" content="text/html; <?=$cfg["common"]["lan"]?>" />
<title>Untitled Document</title>
</head>

<body>
<form name="deliveryForm" method="<?=$method;?>" action="<?=$targeturl?>">
<input type="hidden" name="<?=$arg?>" value="<?=$argvalue?>" />
</form>
<script>
	var f = document.deliveryForm;
	f.submit();
</script>
</body>
</html>