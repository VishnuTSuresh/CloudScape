$(function(){
	var validator= new FormValidator("add_food",
		[{
			 name:"comment",
			 display:"Comment",
			 rules: 'required|min_length[10]'
		},
		{
			 name:"name",
			 display:"Name",
			 rules: 'required'
		},
		],
	function(errors,evt){
		if (errors.length > 0) {
	        var errorString = '';
	        
	        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
	            errorString += errors[i].message + '<br />';
	        }
	        
	        $("#error_box").addClass("error").html(errorString);
	        if (evt && evt.preventDefault) {
	            evt.preventDefault();
	        } else if (event) {
	            event.returnValue = false;
	        }
	    }  
		
	});
	$("#new_food_name").val($("#food_list_select option:selected").text());
	$("#food_list_select").change(function(){
		$("#new_food_name").val($("#food_list_select option:selected").text());
	});
});