/*     
	2/4/09
	Form Validator
	Jquery plugin for form validation and quick contact forms
	Copyright (C) 2009 Jeremy Fry. www.jeremy-fry.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

jQuery.iFormValidate = {
	build : function(user_options)
	{
		var defaults = {
			ajax: true,
			validCheck: false,
			phpFile:"/js/formvalidator/send.php"
		};
		return $(this).each(
			function() {
			var options = $.extend(defaults, user_options); 
			if(options.validCheck){
				var $inputs = $(this).find(":input").filter(":not(:submit)").filter(":not(:checkbox)").filter(":not(.novalid)");
			}else{
				var $inputs = $(this).find(":input").filter(":not(:submit)").filter(":not(:checkbox)");
			}
			//catch the submit
			$(this).submit(function(){
				//we need to do a seperate analysis for checboxes
				var $checkboxes = $(this).find(":checkbox");
				
				//we test all our inputs
				var isValid = jQuery.iFormValidate.validateForm($inputs);
				//if any of them come back false we quit
				if(!isValid){
					return false;
				}
				if(options.ajax){
					var data = {};
					$inputs.each(function(){
						data[this.name] = this.value;
					});
					$checkboxes.each(function(){
						if($(this).is(':checked')){
							data[this.name] = this.value;
						}else{
							data[this.name] = "";
						}
					});	
					$(this).parent('div').fadeOut("slow", function(){
						$(this).load(options.phpFile, data, function(){
							$(this).fadeIn("slow");
						});
					});
					return false;
				}else{
					return true;
				}
			});
			
			$inputs.bind("keyup", jQuery.iFormValidate.validate);
			$inputs.filter("select").bind("change", jQuery.iFormValidate.validate);
		});
	},
	validateForm : function($inputs)
	{
		var isValid = true; //benifit of the doubt?
		$inputs.filter(".is_required").each(jQuery.iFormValidate.validate);
		if($inputs.filter(".is_required").hasClass("invalid")){isValid=false;}
		return isValid;
	},
		
	validate : function(){
		//password check for wether vpassword == vpasswordconfirm
		//var $password = $("#"+formId).find(".vpassword");
		//var $passwordconfirm = $("#"+formId).find(".vpasswordconfirm");
		var $val = $(this).val();
		var isValid = true;
		//Regex for DATE
		if($(this).hasClass('vdate')){
			var Regex = /^([\d]|1[0,1,2]|0[1-9])(\-|\/|\.)([0-9]|[0,1,2][0-9]|3[0,1])(\-|\/|\.)\d{4}$/;
			isValid = Regex.test($val);
		//Regex for Email
		}else if($(this).hasClass('vemail')){
			var Regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!Regex.test($val)){isValid = false;}		
		//Regex for Phone
		}else if($(this).hasClass('vphone')){
			var Regex = /^\(?[2-9]\d{2}[ \-\)] ?\d{3}[\- ]?\d{4}$/;
			var Regex2 = /^[2-9]\d{9}$/;
			if((!Regex.test($val))&&(!Regex2.text($val))){isValid = false;}
		//Check for U.S. 5 digit zip code
		}else if($(this).hasClass('vzip')){
			var Regex = /^\d{5}$/;
			if(!Regex.test($val)){isValid = false;}
		//Check for state
		}else if($(this).hasClass('vstate')){
			var Regex = /^[a-zA-Z]{2}$/;
			if(!Regex.test($val)){isValid = false;}
		//Check for name	
		}else if($(this).hasClass('vname')){
			var Regex = /^[a-zA-Z\ ']*$/;
			if(!Regex.test($val)){isValid = false;}
		//Check for not empty empty
		}else if($(this).hasClass('vpasswordconfirm')){
			//we need to find the other password field and check it
			$el = $(this);
			//locate the form so we can search for the other field
			while($el.attr("tagName").toLowerCase() != "form"){$el = $el.parent();}
			$el = $el.find(".vpassword");
			//store text of other password field
			var checkValue = $el.val();
			//comapre and set the other to red if appropriate, or green
			if($val != checkValue){isValid= false;$el.removeClass("valid").addClass("invalid");
			}else{$el.removeClass("invalid").addClass("valid");}
		}else if($(this).hasClass('vpassword')){
			$el = $(this);
			while($el.attr("tagName").toLowerCase() != "form"){$el = $el.parent();}
			$el = $el.find(".vpasswordconfirm");
			var checkValue = $el.val();
			if($val != checkValue){isValid= false;$el.removeClass("valid").addClass("invalid");
			}else{$el.removeClass("invalid").addClass("valid");}
		}else if($val.length === 0){
			isValid = false;
		}
		
		if(isValid){
			$(this).removeClass("invalid").addClass("valid");
		}else{
			$(this).removeClass("valid").addClass("invalid");
		}
	}	
}
jQuery.fn.FormValidate = jQuery.iFormValidate.build;
