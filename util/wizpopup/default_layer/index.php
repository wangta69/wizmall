<script> 
$(function(){
	$(".closeWin").click(function(){
		var i	=	$(".closeWin").index(this);
		var uid	= $(this).attr("uid");
 		if ( $(".layerpopupCheck").eq(i).is(':checked')) setCookie( "Notice_"+uid, "done" , 1); 

		$(this).parents().find(".dynamicPop").eq(i).remove();
		
	});
});

function setCookie( name, value, expiredays ) 
    { 
        var todayDate = new Date(); 
        todayDate.setDate( todayDate.getDate() + expiredays ); 
        document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
        } 
function closeWin(uid) 
{ 
        if ( document.forms[0].Notice.checked )
//만약 새창에서 여러개의 form 을 사용하고 있으면 forms[0] 에서 공지창 안띄우기 form의 순서(0부터 시작)로 고쳐줍니다. 예: forms[4] 
        setCookie( "Notice_"+uid, "done" , 1); 
        self.close(); 
		var i = $(".btn_close").index(this);
		$(this).parents().find(".dynamicPop").eq(i).remove();
} 
</script>

<div id="content" style="border-right: #9a9a9a 1px solid; border-top: #9a9a9a 1px solid; overflow: auto; border-left: #9a9a9a 1px solid; width: <?php echo $list["pwidth"]?>px; border-bottom: #9a9a9a 1px solid; height: <?php echo $list[pheight]-30?>px; text-align: left">
<?php
//echo $imgpath0." && ".$list[imgposition];
if($imgpath0 && $list["imgposition"] == "top"): ?>
  <img src="<?php echo $imgpath0;?>" border="0">
<?php
endif;
if(trim($list["pcontents"])){
    echo $list["pcontents"];
}
if($imgpath0 && $list["imgposition"] == "bottom"): ?>
  <img src="<?php echo $imgpath0;?>" border="0">
<?php
endif;
?>
</div>
<div style="font-size:12px; text-align:right">오늘 하루 이창 열지 않음
  <input type="checkbox" class="layerpopupCheck" value="checkbox">
  <a class="closeWin" uid="<?php echo $uid;?>">[닫기]</a></div>
