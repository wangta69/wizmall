<?php
include ("../../../lib/cfg.common.php");
include ("../../../config/db_info.php");

include "../../../lib/class.database.php";
$dbcon = new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();
//$keyword = iconv( "UTF-8","EUC-KR" , $keyword );
//$sido = iconv( "UTF-8","EUC-KR" , $sido );
//$sigungu = iconv( "UTF-8","EUC-KR" , $sigungu );
//$ch_item = iconv( "UTF-8","EUC-KR" , $ch_item );
//$sel_item = iconv( "UTF-8","EUC-KR" , $sel_item );

$sidoprever = array("서울"=>"db_zip_seoul", "부산"=>"db_zip_busan", "대구"=>"db_zip_daegu"
, "인천"=>"db_zip_incheon", "광주"=>"db_zip_gwangju", "대전"=>"db_zip_daejeon"
, "울산"=>"db_zip_ulsan", "세종"=>"db_zip_sejong", "강원"=>"db_zip_gangwon"
, "경기"=>"db_zip_gyeonggi", "경남"=>"db_zip_gyeongsang_s", "경북"=>"db_zip_gyeongsang_n"
, "전남"=>"db_zip_jeolla_s", "전북"=>"db_zip_jeolla_n", "제주"=>"db_zip_jeju"
, "충남"=>"db_zip_chungcheong_s", "충북"=>"db_zip_chungcheong_n");

     
$sidoarr = array("db_zip_seoul"=>"서울특별시", "db_zip_busan"=>"부산광역시", "db_zip_daegu"=>"대구광역시"
, "db_zip_incheon"=>"인천광역시", "db_zip_gwangju"=>"광주광역시", "db_zip_daejeon"=>"대전광역시"
, "db_zip_ulsan"=>"울산광역시", "db_zip_sejong"=>"세종특별자치시", "db_zip_gangwon"=>"강원도"
, "db_zip_gyeonggi"=>"경기도", "db_zip_gyeongsang_s"=>"경상남도", "db_zip_gyeongsang_n"=>"경상북도"
, "db_zip_jeolla_s"=>"전라남도", "db_zip_jeolla_n"=>"전라북도", "db_zip_jeju"=>"제주특별자치도"
, "db_zip_chungcheong_s"=>"충청남도", "db_zip_chungcheong_n"=>"충청북도");

?>
<style type="text/css">
.box {width:550px; height:250px;overflow:auto;padding:0px;border:1 solid;}
</style>
<script>

    
    var _sido = "<?php echo $sido;?>";
    var _sigungu = "<?php echo $sigungu;?>";
    function getsigungu(sido){
        if(sido != ''){
                $("#sigungu").removeOption(/./);
                $.post("./default/api.php", {sido:sido}, function(data){
                    //console.log(data);
                    eval("var obj="+data);
                    for (var k in obj) {
                        //console.log(k+':'+obj[k]["sigungu"]);
                        $("#sigungu").addOption(obj[k]["sigungu"], obj[k]["sigungu"], false);
                    }
                    if(_sigungu != ""){//post로 넘어 온 경우
                        $("#sigungu").selectOptions(_sigungu);
                    }
                    
                });
                
            }
    }
    
    $(function(){
        $("#sido").change(function(){
            var sido = $(this).val();
            getsigungu(sido);
            
        });

        if(_sido != ""){//post로 넘어 온 경우
            getsigungu(_sido);
            
        }
    });
</script>
<table width="600px">

    <tr>
        <td>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">도로명주소</a></li>
                <li class="btn_address"><a href="#">지번주소</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
        <? if(!$mode || $mode == "search"){?>
                <div class="well well-lg">

                    <!-- 도로명 주소 폼 -->
                    검색방법 : 예)서울시 중구 소공로</br>

                    
                    <form class="sform"  class="form-horizontal" method="post">
                        <table class="table add_list">
                        <col width="120px" />
                        <col width="*" />
                    <tr>
                    <th>시도</th>
                    <th><select id="sido" name="sido" class="form-control" title="시도 선택">
                              <option value="" selected="selected">전체</option>
                              <?php
                              foreach($sidoarr  as $key=>$val){
                                $selected = $sido == $key ? " selected":"";
                                echo '<option value="'.$key.'"'.$selected.'>'.$val.'</option>\n';
                              }
                              ?>                            
                            </select></th>
                </tr>
                <tr>
                    <th>시군구</th>
                    <th><select id="sigungu" name="sigungu" class="form-control" title="시군구 선택"><option value="">전체</option></select></th>
                </tr>
                <tr>
                    <th>도로명</th>
                    <th><input type="text" name="keyword" class="form-control" id="inputkeyword" placeholder="도로명" value="<?=$keyword;?>"></th>
                </tr>
                </table>
                        
                        <button type="submit" class="btn btn-default">검색</button>
                        <button type="button" class="btn btn-default" onclick = "self.close();">닫기</button>
                    </form>
                    <script>
                        setWindowResize(600,380);
                        $("#inputkeyword").focus();
                        $(".sform").submit(function() {
                            if ($("#sido").val() == "") {
                                alert("시도를 선택해주세요");
                            }else if ($("#sigungu").val() == "") {
                                alert("시군구를 선택해주세요");
                            }else if ($("#inputkeyword").val() == "") {
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

            if ($keyword || $ch_item){
                if($ch_item){
                    //138-130^서울 송파구 오금동 서울송파우체국
                    $exp    = explode("^", $ch_item);
                    $zip    = str_replace("-", "",$exp[0]);
                    
                    $add    = explode(" ", $exp[1]);
                    $db     = $sidoprever[$add[0]];
                    $sql = "select * from ".$db." where zipcode='".$zip."'";
                }else{
                    $sql = "select zipcode, sido, sigungu, street, buildingno, dongname, sigungubuildingname, ri, san, areano from ".$sido." where sigungu = '".$sigungu."' and street like '%$keyword%'";
                }
                
                //echo $sql;
                $rows = $dbcon->get_rows($sql);
                
                if(is_array($rows)) foreach($rows as $key => $val){
                    $tmpzip                         = explode("-", $qrylist["zipcode"]);
                    $rows[$key]["zip1"] = substr($val["zipcode"], 0, 3);// Zipcode1
                    $rows[$key]["zip2"] = substr($val["zipcode"], -3);// Zipcode2
                }

            }   
?>
        <div class="well well-lg">
        검색결과
        <br>
        <br>
        <form class="sform" method="post" role="form">  
            <input type="hidden" name="sel_item" id="sel_item">
        </form> 
        <div class="box">
            <table class="table add_list">
                <col width="80px"/>
                <col width="*"/>
                <col width="40px"/>
                <tr>
                    <th>우편번호</th>
                    <th>주소</th>
                    <th></th>
                </tr>
                <?php 
                
                    if(count($rows)){
                        foreach($rows as $key=>$val){
                ?>
                
                <tr user-data-add="<?php echo $val["zip1"]."-".$val["zip2"]."^".$val["sido"]." ".$val["sigungu"]." ".$val["street"]." ".$val["buildingno"]?>">
                    <td><?php echo $val["zip1"]."-".$val["zip2"];?></td>
                    <td><?php echo $val["sido"]." ".$val["sigungu"]." ".$val["street"]." ".$val["buildingno"]."</br>".$val["sido"]." ".$val["sigungu"]." ".$val["dongname"]." ".$val["sigungubuildingname"]." ".$val["ri"]." ".$val["ga"];?></td>
                    <td><button type="button" class="btn btn-default btn-xs btn_sel">선택</button></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td></td>
                    <td>검색결과가 없습니다.</td>
                    <td></td>
                </tr>
                <?php
                }
                ?>
            </table>    
        </div>
                
    
        </div><!--<div class="well well-lg"> -->
        <script>
            setWindowResize(600,700);
            $(".btn_sel").click(function(){
                    var sel_item = $(this).parents("tr").attr("user-data-add");
                    //alert(sel_item);
                    $("#sel_item").val(sel_item);
                    $("#mode").val("search_detail");
                    gotoPage();
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
                                주소를 입력하시고, '적용'을 <b><font color="#CC3399">클릭</b>하세요.</br>
                            
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
        </div>
    

        <?php
        }
        ?>

        </td>
    </tr>
</table>