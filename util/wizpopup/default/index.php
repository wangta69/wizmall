<html>
	<head>
		<title><?php echo $list["psubject"];?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"];?>">
		<script language="javascript" src="/js/jquery-1.4.2.min.js"></script>
		<script> 
		$(function(){
			$(".btn_direct_go").click(function(){
				opener.location.href="<?php echo $list["click_url"];?>";
				self.close();
			});
		});
		
		function setCookie( name, value, expiredays ) 
		{ 
		    var todayDate = new Date(); 
		    todayDate.setDate( todayDate.getDate() + expiredays ); 
		    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
		}
		function closeWin() 
		{ 
		        if ( document.forms[0].Notice.checked )
		//만약 새창에서 여러개의 form 을 사용하고 있으면 forms[0] 에서 공지창 안띄우기 form의 순서(0부터 시작)로 고쳐줍니다. 예: forms[4] 
		        setCookie( "Notice_<?php echo $uid?>", "done" , 1); 
		        self.close(); 
		} 
		</script>
		<style>
		#popbody {
			margin: 0;
			padding: 0;
			background-color:<?php echo $background?>;
		}
		#content {
			border: #9a9a9a 1px solid;
			overflow: auto;
			width: <?php echo $list["pwidth"]; ?>px;
			height: <?php echo $list["pheight"]-30;?>px;
			text-align: left
		}
		</style>
	</head>
	<body id="popbody">

		<?php
		//echo $imgpath0." && ".$list[imgposition];
		if($imgpath0 && $list["imgposition"] == "top"): ?>
		  <div><img src="<?php echo $imgpath0?>" border="0"></div>
		<?php
		endif;
		if(trim($list["pcontents"])){
		?>
		 <div><?php echo $list["pcontents"]?></div>
		<?php
		}
		if($imgpath0 && $list["imgposition"] == "bottom"): 
		?>
		 <div><img src="<?php echo $imgpath0?>" border="0"></div>
		<?php
		endif;
		?>
		
		<?php if($list["click_url"]){ ?>
			<div class="agn_r"><span class="button bull btn_direct_go"><a>[바로가기]</a></span></div>
		<?php
		}
		?>
		
		  <form>
		  	<div style="text-align: right;"> 
		   		 오늘 하루 이창 열지 않음
		        <input type="checkbox" name="Notice" value="checkbox">
		        <a href="javascript:onclick=closeWin()">[닫기]</a></td>
		    </div>
		  </form>
	</body>
</html>