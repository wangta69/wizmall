<?php


	function get_current_theme(){
		return "default";
	}
	
	function get_header(){
		global $dbcon, $common;
		$theme	= get_current_theme();
		ob_start();
		@include_once getcwd()."/modules/theme/".$theme."/header.php";
		//echo getcwd()."/modules/theme/".$theme."/header.php";
		//exit;
		$output	= ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	
	function get_footer(){
		global $dbcon, $common;
		$theme	= get_current_theme();
		ob_start();
		@include_once getcwd()."/modules/theme/".$theme."/footer.php";
		$output	= ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/**
	 * get sider bar
	 */
	function get_sider(){
		global $dbcon, $common;
		$theme	= get_current_theme();
		ob_start();
		@include_once getcwd()."/modules/theme/".$theme."/sider.php";
		$output	= ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	function get_topgnb(){
		
		global $dbcon, $common;
		$theme	= get_current_theme();
		ob_start();
		@include_once getcwd()."/modules/theme/".$theme."/topgnb.php";
		$output	= ob_get_contents();
		ob_end_clean();
		return $output;
		
	}
	
	
	function get_content(){
		global $dbcon, $common, $mall, $navy_params, $cfg;
		$theme	= get_current_theme();
		$type	= $navy_params["type"];
		$proc	= $navy_params["proc"];
		$skin	= $navy_params["skin"];
		ob_start();

		//$navy_params	= array("type"=>$_GET["type"], "proc"=>$_GET["proc"], "skin"=>$_GET["skin"]);
		switch($type){
			case "html":
				@include_once getcwd()."/modules/html/".$theme."/".$proc.".php";
				break;
			case "product":
				switch($proc){
					case "view":
						//echo getcwd()."/modules/shop/".$theme."/product_view.php";
						@include_once getcwd()."/modules/shop/".$theme."/product_view.php";
						break;
					default : //list
						@include_once getcwd()."/modules/shop/".$theme."/product_list.php";
						break;
				}
				break;
			default:
				@include_once getcwd()."/modules/theme/".$theme."/content.php";
				break;
		}
		switch($navy_params["proc"]){
			case "product_view":
				//echo getcwd()."/modules/shop/".$theme."/product_view.php";
				@include_once getcwd()."/modules/shop/".$theme."/product_view.php";
				break;
			case "product_list":
				@include_once getcwd()."/modules/shop/".$theme."/product_list.php";
				break;
			default:
				
				break;
		}
		
		$output	= ob_get_contents();
		ob_end_clean();
		return $output;
	}
