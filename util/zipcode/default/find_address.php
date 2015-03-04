<?php
include ("../../../lib/cfg.common.php");
include ("../../../config/db_info.php");

include "../../../lib/class.database.php";
$dbcon = new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();
//$keyword = iconv( "UTF-8","EUC-KR" , $keyword );
//$sel_item = iconv( "UTF-8","EUC-KR" , $sel_item );

?>
<style type="text/css">
.box {width:550px; height:250px;overflow:auto;padding:0px;border:1 solid;
}
</style>
<table width="600px">
<col width="120px" />
<col width="*" />
<tr>
    <td>
        <ul class="nav nav-tabs">
            <li class="btn_street"><a href="#">도로명주소</a></li>
            <li class="active"><a href="#">지번주소</a></li>
        </ul>
    </td>
</tr>

<tr>
    <td>
        <? if(!$mode || $mode == "search"){?>
        <div class="well well-lg">

            <!-- 도로명 주소 폼 -->
            찾고자  하는 주소의 동(읍/면/리)를 입력해주세요 </br>예) 역삼2동, 서초동, 송파동 </br>

            
            <form class="sform" method="post">
                <div class="form-group">
                    <label for="inputkeyword">검색어</label>
                    <input type="text" name="keyword" class="form-control" id="inputkeyword" value="<?=$keyword?>" placeholder="동(읍/면/리)를 입력">
                </div>
                
                <button type="submit" class="btn btn-default">검색</button>
                <button type="button" class="btn btn-default" onclick = "self.close();">닫기</button>
            </form>
            <script>
                setWindowResize(600,280);
                $("#inputkeyword").focus();
                $(".sform").submit(function() {
                    if ($("#inputkeyword").val() == "") {
                        alert("동(읍면리)를 입력해 주세요");
                    }else{
                        $("#mode").val("search");
                        gotoPage();
                    }
                    return false;

                });
            </script>
        </div>  
        <? } ?>







        <?php
        if($mode == "search"){

            $search_count = 0;
    
            if ($keyword){
                $sqlstr = "select * from wizzipcode where gugun like '%$keyword%' or dong like '%$keyword%'";
                //echo $sqlstr;
                $qry = $dbcon->_query($sqlstr);
                
                while ($qrylist = $dbcon->_fetch_array($qry)){
                    $tmpzip                         = explode("-", $qrylist["zipcode"]);
                    $list[$search_count]["zip1"]    = $tmpzip[0];// Zipcode1
                    $list[$search_count]["zip2"]    = $tmpzip[1];// Zipcode2
            
                    $list[$search_count]["addr"]    = $qrylist["sido"]." ".$qrylist["gugun"]." ".$qrylist["dong"];// 주소
                    $list[$search_count]["bunji"]   = $qrylist["bunji"];// 번지
    
                    $search_count++;
                }


        }

?>
        <div class="well well-lg">
         검색결과
        <br>
        <br>
        
        
        
        
        <form class="sform" method="post" role="form">  
            <input type="hidden" name="sel_item" id="sel_item">
            <input type="hidden" name="ch_item" id="ch_item">
        </form>
                    
<?php 
if(count($list)){
?>
    <div class="box">
                <table class="table">
                    <col width="*" />
                    <col width="120px" />
                    <?php
                    for ($i = 0; $i < count($list); $i++) {
                        //echo "<option value='{$list[$i][zip1]}-{$list[$i][zip2]}^{$list[$i][addr]}'>{$list[$i][addr]} {$list[$i][bunji]}</option>";
                    ?>
                    <tr user-data-add="<?php echo $list[$i]["zip1"]?>-<?php echo $list[$i]["zip2"]?>^<?php echo $list[$i]["addr"]?>">
                        <td>(<?php echo $list[$i]["zip1"]?>-<?php echo $list[$i]["zip2"]?>) <? echo $list[$i]["addr"].$list[$i]["bunji"] ?></td>
                        <td>
                            <button type="button" class="btn btn-default btn-xs btn_sel">선택</button>
                            <button type="button" class="btn btn-default btn-xs btn_goto">신주소</button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
<?php
    }else{
?>
                    <tr>
                        <td colspan="2">데이타 없음</td>
                        <td></td>
                    </tr>
<?php
}
?>
                    
                </table>
        </div><!--<div class="box"> -->
        </div><!--<div class="well well-lg">-->
        <script>
            setWindowResize(600,650);
            $(function(){
                $(".btn_sel").click(function(){
                    var sel_item = $(this).parents("tr").attr("user-data-add");
                    //alert(sel_item);
                    $("#sel_item").val(sel_item);
                    $("#mode").val("search_detail");
                    gotoPage();
                });
                
                $(".btn_goto").click(function(){
                    var ch_item = $(this).parents("tr").attr("user-data-add");
                    $("#ch_item").val(ch_item);
                    switchtype("street");
                    $("#mode").val("search");
                    gotoPage();
                });
            });

        </script>
        <?php
        } else if($mode == "search_detail"){
            $TmpAddr = explode("^", $sel_item);
            $TmpZipcode = explode("-" , $TmpAddr[0]);
        ?>
        <div class="well well-lg">
        <form name = "checkThirdFrm" id="checkThirdFrm" method = "post" class="form-horizontal" role="form">
            <input type = "hidden" name = "address1" id="address1" value = "<?php echo $TmpAddr[1] ?>">
                                나머지
                                주소를 입력하시고, '주소입력'을 <b><font color="#CC3399">클릭</b>하세요.</br>
                            
            <div class="form-group">
                <label for="inputkeyword">우편 번호</label>
                <input type='text' name='zip1' id="zip1" value='<?php echo $TmpZipcode[0] ?>' readonly  class="form-control w50" style="display: inline" >
                -
                <input type='text' name='zip2' id="zip2" value='<?php echo $TmpZipcode[1] ?>' readonly  class="form-control w50"  style="display: inline">
            </div>
            <div class="form-group">
                <label>주소</label>
                <label><?php echo $TmpAddr[1] ?></label>
            </div>
            <div class="form-group">
                <label for="inputkeyword">상세주소</label>
                <input name="address2" id="address2" type="text" class="form-control" >
            </div>
            

            <div class="form-group">
                <button type="submit" class="btn btn-default">적용</button>
                <button type="button" class="btn btn-default" onclick = "self.close();">닫기</button>
            </div>
                        
        </form>
            <script>
                setWindowResize(600,350);
                $("#address2").focus();
                
                $("#checkThirdFrm").submit(function(e){
                    e.preventDefault();
                    
                    if($("#address2").val() == ""){
                        alert("상세주소를 입력하여 주세요");
                        $("#address2").focus();
                        return false;
                    }else{
                        $("#<?php echo $zip1; ?>",opener.document).val($("#zip1").val());
                        $("#<?php echo $zip2; ?>",opener.document).val($("#zip2").val());
                        $("#<?php echo $firstaddress; ?>",opener.document).val($("#address1").val());
                        $("#<?php echo $secondaddress; ?>",opener.document).val($("#address2").val());
                        $("#<?php echo $secondaddress; ?>",opener.document).focus();
                        window.close();
                        return false;
                    }
                });

        </script>
        </div><!--<div class="well well-lg"> -->
    

        <?php
        }
        ?>
    </td>
</tr>
</table>