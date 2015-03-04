<?
include ("../../lib/cfg.common.php");
include ("../../config/db_info.php");
include ("../../lib/class.database.php");
$dbcon      = new database($cfg["sql"]);

$sqlstr = "SELECT count(uid) FROM wizMembers WHERE mid='$user_id'";
$result = $dbcon->get_one($sqlstr);

if(!$user_id) {
    $message = '<div class="alert alert-info">아이디를 입력해 주세요</div>';
    $status = "false";
}else if((strlen($user_id) > 12) || (strlen($user_id) < 6)) {
    $message = '<div class="alert alert-danger">아이디는 6~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.</div>';
    $status = "false";
}else if ( $result ) {
    $message = '<div class="alert alert-danger"><strong>'.$user_id.'</strong>은(는) 이미 사용중인 아이디입니다.</div>';
    $status = "false";
}
else {
    $message    = '<div class="alert alert-success"><strong>'.$user_id.'</strong>은(는) 사용가능한 ID입니다.</div>';
    $status = "true";
}
$dbcon->_close();
?>
<!DOCTYPE html>
<html lang="kr">
    <head>
        <meta charset="<?=$cfg["common"]["lan"]?>">
        <title>ID 체크</title>
        <script language="javascript" src="../../js/jquery.min.js"></script>
        <link rel="stylesheet" href="../../css/common.css" type="text/css" />
        <link href="../../js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="../../js/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../js/pop_resize.js"></script>
    
    
        <script>
        setWindowResize(350, 250);
        
        $(function(){
            //아이디 검색
            $("#btn_search").click(function(){
                if($("#user_id").val() == ""){
                    alert("아이디를 입력해주세요");
                    $("#user_id").focus();
                }else{
                    $("#s_form").submit();
                }
            });
            
            //아이디 세팅
            $("#btn_set").click(function(){
                $("#id",opener.document).val($("#user_id").val());
                $("#idchk_result",opener.document).val(1)
                self.close();
            });
        });

        </script>
    </head>
    <body>
        <?php echo $message; ?>
        <form name="s_form" id="s_form" class="form-horizontal" role="form">
            <input type="hidden" name="action" value="user_idcheck">
        
            
            <div class="form-group">
                <label class="col-lg-2 control-label">아이디</label>
                <div class="col-lg-10">
                    <input type="text" name="user_id" id="user_id"  value="<?php echo $user_id?>" class="form-control"  placeholder="아이디입력">
                </div>
            </div>
            <span class="help-block">아이디는 영/숫자 혼합으로 6~15자가 가능합니다.</span>
            <div class="form-group">
                <?php if($status == "true") : ?>
                <div class="col-lg-10">
                    <button type="button" id="btn_set" class="btn btn-primary">적용</button>
                    <button type="button" id="btn_search" class="btn btn-primary">검색</button>
                </div>
                <?php else: ?>
                <div class="col-lg-10">
                    <button type="button" id="btn_search" class="btn btn-primary">검색</button>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </body>
</html>
