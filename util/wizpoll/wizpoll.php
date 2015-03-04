<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../../lib/cfg.common.php";
include ("../../config/db_info.php");
include ("../../config/wizPoll_info.php");
include ("./func/function.php");
$BOARD_NAME="wizpoll";


include "./skin_top.php";

switch ( $mode )
{
        case ( "list" ) :
        include ("./$Poll_Skin_Name/list.php");
        break;
        case ( "view" ) :
        include ("./$Poll_Skin_Name/view.php");
        break;
        case ( "write" ) :
        include ("./$Poll_Skin_Name/write.php");
        break;
        case ( "modify" ) :
        include ("./$Poll_Skin_Name/write.php");
        break;
        case ( "delete" ) :
        include ("./DELETE_FORM.php");
        break;
        case ( "login" ) :
        include ("./member_login.php");
        break;					
        default :
       include ("./$Poll_Skin_Name/list.php");
}
include "./skin_bottom.php";
?>