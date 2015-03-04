<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include ("./product/common.php");
?>
<script>
function mini_help_window_open( page, name, top, left, width, height )
{
        window.open( page, name,
        'toolbar=no, location=no, directories=no, status=no, ' +
        'menubar=no, scrollbars=yes, resizable=yes, width=' +
        width + ', height=' + height +
        ', top=' + top + ', left=' + left );
}


function move_all( obj, mode )
{
        f_index = 0
        e_index = obj.length - 1
        select_index = obj.selectedIndex

        // 아래로 이동
        if( mode == "down" )
        {
                if( select_index < e_index )
                {
			target_index = obj.length-1

			select_obj = obj[select_index]
			dest_obj = obj[obj.length-1]

                        temp_value = select_obj.value
                        temp_text = select_obj.text

			for ( t=select_index; t < e_index ;t++)
			{
				obj[t].value = obj[t+1].value
				obj[t].text = obj[t+1].text
			}

			dest_obj.value = temp_value
			dest_obj.text = temp_text
                }
        }
        // 위로 이동
        else
        {
                if( select_index > f_index )
                {
			target_index = 0 

                        select_obj = obj[select_index]
                        dest_obj = obj[0]

                        temp_value = select_obj.value
                        temp_text = select_obj.text

			for ( t=select_index; t > f_index ;t--)
			{
				obj[t].value = obj[t-1].value
				obj[t].text = obj[t-1].text
			}
			dest_obj.value = temp_value
			dest_obj.text = temp_text
                }
        }
        dest_obj.selected = true

	for (i=0 ;i <= obj.length-1 ;i++)
	{
		display_box=obj[i]
		display_order = frm["display_order[]"][i]
		display_order.value=display_box.value
	}

} // end of move_all()

function move_one( obj, mode )
{
        f_index = 0
        e_index = obj.length - 1
        select_index = obj.selectedIndex

        // 아래로 이동
        if( mode == "down" )
        {
                if( select_index < e_index )
                {
			select_obj = obj[select_index]
			dest_obj = obj[select_index+1]
                        temp_value = select_obj.value
                        temp_text = select_obj.text

                        select_obj.value = dest_obj.value
                        select_obj.text = dest_obj.text
                        dest_obj.value = temp_value
                        dest_obj.text = temp_text

        		dest_obj.selected = true
                }
        }
        // 위로 이동
        else
        {
                if( select_index > f_index )
                {
                        select_obj = obj[select_index]
                        dest_obj = obj[select_index-1]
                        temp_value = select_obj.value
                        temp_text = select_obj.text

                        select_obj.value = dest_obj.value
                        select_obj.text = dest_obj.text
                        dest_obj.value = temp_value
                        dest_obj.text = temp_text

        		dest_obj.selected = true
                }
        }

	for (i=0 ;i <= obj.length-1 ;i++)
	{
		display_box=obj[i]
		display_order=frm["display_order[]"][i]
		display_order.value=display_box.value
	}

} // end of move_one()

function move_directs( obj, idx )
{
        f_index = 0
        e_index = obj.length - 1

        select_index = obj.selectedIndex
	target_index = idx - 1

	if( ( target_index < f_index ) || ( target_index > e_index ) )
	{
		alert("입력하신 값이 범위를 벗어납니다.");
		return false ;
	}

	if ( target_index == select_index )
	{
		alert("입력하신 값과 선택한 항목이 동일합니다.");
		return false ;
	}

	if ( select_index > target_index ) 
	{
		select_obj = obj[select_index]
		dest_obj = obj[target_index]

		temp_value = select_obj.value
		temp_text = select_obj.text

		for ( t=select_index; t > target_index ;t--)
		{
			obj[t].value = obj[t-1].value
			obj[t].text = obj[t-1].text
		}
		dest_obj.value = temp_value
		dest_obj.text = temp_text
        }
        // 위로 이동
        else
        {
		select_obj = obj[select_index]
		dest_obj = obj[target_index]

		temp_value = select_obj.value
		temp_text = select_obj.text

		for ( t=select_index; t < target_index ;t++)
		{
			obj[t].value = obj[t+1].value
			obj[t].text = obj[t+1].text
		}
		dest_obj.value = temp_value
		dest_obj.text = temp_text
        }
        dest_obj.selected = true

	for (i=0 ;i <= obj.length-1 ;i++)
	{
		display_box=obj[i]
		display_order=frm["display_order[]"][i]
		display_order.value=display_box.value
	}

} // end of move_direct()

function move_first()
{
	selected_idx = document.frm.product_list.selectedIndex  ;

	if ( selected_idx == "-1" )
	{
		alert( "목록이 선택되지 않았습니다." ) ;
		return false ; 
	}	

	move_all( frm.product_list, 'up' ) ;
}

function move_last()
{
	selected_idx = document.frm.product_list.selectedIndex  ;

	if ( selected_idx == "-1" )
	{
		alert( "목록이 선택되지 않았습니다." ) ;
		return false ; 
	}	

	move_all( frm.product_list, 'down' ) ;
}

function move_prev()
{	
	selected_idx = document.frm.product_list.selectedIndex  ;

	if ( selected_idx == "-1" )
	{
		alert( "목록이 선택되지 않았습니다." ) ;
		return false ; 
	}	

	ret = move_one( frm.product_list, 'up' ) ;

	if ( ret == false )
		return false ;
}

function move_next()
{	
	selected_idx = document.frm.product_list.selectedIndex  ;

	if ( selected_idx == "-1" )
	{
		alert( "목록이 선택되지 않았습니다." ) ;
		return false ; 
	}	

	ret = move_one( frm.product_list, 'down' ) ;

	if ( ret == false )
		return false ;
}

function move_direct()
{
	if ( document.frm.direct_idx.value == "" )
	{
		alert("값이 입력되지 않았습니다.");
		document.frm.direct_idx.focus();
		return false; 
	}

	selected_idx = document.frm.product_list.selectedIndex  ;

	if ( selected_idx == "-1" )
	{
		alert( "목록이 선택되지 않았습니다." ) ;
		return false ; 
	}	

	direct_idx = document.frm.direct_idx.value ;

	ret = move_directs( frm.product_list, direct_idx ) ;

	if ( ret == false )
		return false ;

	document.frm.direct_idx.value = "" ;
}

function form_submit()
{
	document.frm.action = "product_display_order_a.php" ;
	document.frm.submit();
}

function order_reload()
{
	document.frm.action = "product_display_order_f.php" ;
	document.frm.submit();
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">제품순서변경</div>
	  <div class="panel-body">
		 디스플레이되는 상품의 순서를 변경하실 수 있습니다.
	  </div>
	</div>
	<?php include ("./product/product_searchbox.php"); ?>
	
	<form  action='<?php echo $PHP_SELF;?>' method='post' name="frm">
		<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey()?>">
		<input type="hidden" name='action' value='orderupdate'>
		<input type="hidden" name= menushow value=<?php echo $menushow;?>>
		<input type="hidden" name="theme"  value=<?php echo $theme;?>>
		<table class="table">
			<col width="320px">
			<col width="*">

			<tr>
				<td><select name="product_list" size="15" style="BORDER: #D0D0D0 1 solid; font-size:12px; color:#5E5E5E; HEIGHT: 300px; width: 100%">
<?php
$dbcon->get_select('m.UID, m.Name, m.OrderID, c.cat_name','wizMall m left join wizCategory c on m.Category=c.cat_no',$whereis, 'm.OrderID ASC');
$cnt = 1;
while( $list = $dbcon->_fetch_array()) :
	echo "<option value='".$list["UID"]."'>".$list["OrderID"]."[".$list["cat_name"]."] ".$list["Name"]."</option>\n";  
$cnt++;
endwhile;
?>
					</select>
				</td>
				<td>
					<button type="button" class="btn btn-default btn-xs" style="display: block;" onClick="move_first();"><span class="glyphicon glyphicon-fast-forward"></span></button>
					<button type="button" class="btn btn-default btn-xs" style="display: block;" onClick="move_prev();"><span class="glyphicon glyphicon-step-forward"></span></button>	
					<input type="text" name="direct_idx" class="w30">
					<button type="button" class="btn btn-default btn-xs" onClick="move_direct();">이동</button>
					<button type="button" class="btn btn-default btn-xs" style="display: block;" onClick="move_next();"><span class="glyphicon glyphicon-step-backward"></span></button>					
					<button type="button" class="btn btn-default btn-xs" style="display: block;" onClick="move_last();"><span class="glyphicon glyphicon-fast-backward"></span></button>	
				</td>
			</tr>
<?php
$dbcon->get_select('m.UID','wizMall m',$whereis, 'm.OrderID ASC');
//$cnt = 1;
while( $list = $dbcon->_fetch_array()) :	
   echo "<input type='hidden' name='display_order[]' value='".$list["UID"]."'>";
endwhile;
?>
			
		</table>
		<p class="text-center">
			<button type="submit" class="btn btn-primary">설정완료</button>
		</p>
	</form>

	
</div>
