var Mess=Mess||{};
Mess.selected_cell=null;
//creates Mess.FoodList and the food list in html
function init_foodlist(){
	Mess.forEachFood(function(food_item){
		var food_name=food_item.name;
		var food_id=food_item.id;
		var element=$("<li />").data("id",food_id).addClass("food_item").text(food_name);
		$("ul#food_list").append(element);
		food_item.element=element;
		element.click(function(){
			if(Mess.selected_cell){
				var food_item=Mess.FoodList[$(this).data("id")];
				Mess.selected_cell.addItem(food_item);
			}
		});
	});
}
//creates Mess.TimeTable.Monday.Breakfast etc
function init_cell(day,period){
	var cell={
		items:{
			
		},
		addItem:function(item){
			var self=this;
			var items=self.items;
			if(!items[item.id]){
				var entry_element=$("<div />").text(item.name).addClass("entered_item");
				entry_element.click(function(){
					self.removeItem(items[item.id]);
				});
				var input=$("<input type='hidden' name=M["+day.slice(0,2)+"]["+period.slice(0,1)+"][] />").val(item.id);
				entry_element.append(input);
				items[item.id]={
					id:item.id,
					name:item.name,
					element:entry_element,
				};
				self.element.find(".cell_container").append(entry_element);
			}
		},
		removeItem:function(item){
			if(this.items[item.id]){
				this.items[item.id].element.remove();
				delete(this.items[item.id]);
			}
		},
		element:$("table.table tr#"+period+" td.period."+day),
	};
	cell.element.click(function(){
		Mess.selected_cell?Mess.selected_cell.element.removeClass("period_selected").addClass("period"):null;
		$(this).removeClass("period").addClass("period_selected");
		Mess.selected_cell=cell;
		$("#food_list_app").dialog("open");
	});
	return cell;
};
function a(){
	$.each(Mess.TimeTable,function(index, value){
		$.each(value,function(index, val){
			$.each(val.items,function(index, va){
				console.log(va.name);
			});
		});
	});
}
//initialize food search
function init_foodsearch(){
	$("#food_search").keyup(function(){
		var search_term=$.trim($(this).val());
		Mess.forEachFood(function(food_item){
			if($.trim(food_item.name).toLowerCase().search($.trim(search_term.toLowerCase()))>=0){
				food_item.element.show();
			}
			else{
				food_item.element.hide();
			}
		});
		
	});
}
$(function(){
	var validator= new FormValidator("mess_form",
			[{
				 name:"comment",
				 display:"Comment",
				 rules: 'required|min_length[10]'
			}],
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
	$("#food_list_app").dialog({ 
		autoOpen: false, 
		closeOnEscape: true,
		draggable: false,
		resizable:false,
		"z-index":5,
	}).parent().draggable();
	$("#esctox").click(function(){
		$("#food_list_app").dialog("close");
		Mess.selected_cell?Mess.selected_cell.element.removeClass("period_selected").addClass("period"):null;
		Mess.selected_cell=null;
	});
	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	$("#mess_calendar").datepicker({ 
		firstDay: 1,
		changeMonth: true,
		changeYear: true,
		onSelect: function(dateText, inst) { 
			window.location = "Edit.php?ts="+dateText;
		},
		dateFormat: "d-M-yy",
		defaultDate: getParameterByName("ts"),
	});
	$("#mess_form").submit(function(){
		
	});
	//creates Mess.forEachFood
	Mess.forEachFood=function(callback_func){
		for(var food_name in Mess.FoodList){
			callback_func(Mess.FoodList[food_name]);
		}
	};
	
	Mess.TimeTable={};
	
	Mess.TimeTable.Monday={};
	Mess.TimeTable.Monday.Breakfast=init_cell("Monday","Breakfast");
	Mess.TimeTable.Monday.Lunch=init_cell("Monday","Lunch");
	Mess.TimeTable.Monday.Dinner=init_cell("Monday","Dinner");
	
	Mess.TimeTable.Tuesday={};
	Mess.TimeTable.Tuesday.Breakfast=init_cell("Tuesday","Breakfast");
	Mess.TimeTable.Tuesday.Lunch=init_cell("Tuesday","Lunch");
	Mess.TimeTable.Tuesday.Dinner=init_cell("Tuesday","Dinner");
	
	Mess.TimeTable.Wednesday={};
	Mess.TimeTable.Wednesday.Breakfast=init_cell("Wednesday","Breakfast");
	Mess.TimeTable.Wednesday.Lunch=init_cell("Wednesday","Lunch");
	Mess.TimeTable.Wednesday.Dinner=init_cell("Wednesday","Dinner");
	
	Mess.TimeTable.Thursday={};
	Mess.TimeTable.Thursday.Breakfast=init_cell("Thursday","Breakfast");
	Mess.TimeTable.Thursday.Lunch=init_cell("Thursday","Lunch");
	Mess.TimeTable.Thursday.Dinner=init_cell("Thursday","Dinner");
	
	Mess.TimeTable.Friday={};
	Mess.TimeTable.Friday.Breakfast=init_cell("Friday","Breakfast");
	Mess.TimeTable.Friday.Lunch=init_cell("Friday","Lunch");
	Mess.TimeTable.Friday.Dinner=init_cell("Friday","Dinner");
	
	Mess.TimeTable.Saturday={};
	Mess.TimeTable.Saturday.Breakfast=init_cell("Saturday","Breakfast");
	Mess.TimeTable.Saturday.Lunch=init_cell("Saturday","Lunch");
	Mess.TimeTable.Saturday.Dinner=init_cell("Saturday","Dinner");
	
	Mess.TimeTable.Sunday={};
	Mess.TimeTable.Sunday.Breakfast=init_cell("Sunday","Breakfast");
	Mess.TimeTable.Sunday.Lunch=init_cell("Sunday","Lunch");
	Mess.TimeTable.Sunday.Dinner=init_cell("Sunday","Dinner");
	init_foodlist();
	init_foodsearch();
	$("ul#food_list").jScrollPane({
		autoReinitialise:true,
	});
	$.each(Mess.TimeTableJSON,function(period, days){
		$.each(days,function(day, meal){
			$.each(meal,function(index, food){
				var item=Mess.FoodList[food];
				if(item)
				Mess.TimeTable[day][period].addItem(item);
			});
		});
	});
});