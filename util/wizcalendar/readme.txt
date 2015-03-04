jquery 로 변경

메인 디스플레이시


<script type="text/javascript" src="/js/jquery.min.js"></script>
<script>
    function getdiary(mode, month){
        $.post("./util/wizcalendar/mainskin2.php", {mode:mode, Month:month}, function(data){
            $("#diary_html").html(data);
        }); 
    }

</script>

$(function(){
	getdiary('', '');
});
