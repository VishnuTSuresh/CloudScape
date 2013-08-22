var twidth=1306;
var currentwidthtype;
function dynamicLayout(){
	var browserWidth = $(document).width();
	if (browserWidth < twidth){
		if(currentwidthtype!="thin"){
			$(".groupwrapper").find(".entry").css("display","none");
			$("body").removeClass("wide").addClass("thin");
			$("#sideLeft").data("jsp").destroy();
			$("#AppTools").data("jsp").destroy();
		}
		currentwidthtype="thin";
	}
	if (browserWidth >= twidth){
		if(currentwidthtype!="wide"){
			$(".groupwrapper").find(".entry").css("display","block");
			$("body").removeClass("thin").addClass("wide");
			$("#sideLeft").jScrollPane({
				autoReinitialise:true,
				autoReinitialiseDelay:10,
			});
			$("#AppTools").jScrollPane({
				autoReinitialise:true,
				autoReinitialiseDelay:10,
			});
		}
		currentwidthtype="wide";
	}
	
}
$(document).ready(function(){
	var scrollable=$('.scroll-pane').jScrollPane({
		autoReinitialise:true,
		autoReinitialiseDelay:10,
	});
	dynamicLayout();
});
/*
 * if layout is thin and the group wrapper is hovered, all entry becomes display block and groupwrapper 
 * gets class clicked 
 */
$(document).ready(function(){
	$(".groupwrapper").hover(function(){
		if($("body").hasClass("thin")){
			$(this).find(".entrywrapper").addClass("clicked");
			$(this).find(".entry").css("display","block");
		}
	},function(){
		if($("body").hasClass("thin")){
			$(this).find(".entrywrapper").removeClass("clicked");
			$(this).find(".entry").css("display","none");
		}
	})
});
$(window).resize(dynamicLayout);