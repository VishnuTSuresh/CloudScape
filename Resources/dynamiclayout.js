var twidth=1306;
var currentwidthtype;
function dynamicLayout(){
	var browserWidth = $(document).width();
	if (browserWidth < twidth){
		if(currentwidthtype!="thin"){
			$(".groupwrapper").children(".entry").css("display","none");
			$("body").removeClass("wide").addClass("thin");
			$("#sideLeft").data("jsp").destroy();
			$("#AppBar").data("jsp").destroy();
		}
		currentwidthtype="thin";
	}
	if (browserWidth >= twidth){
		if(currentwidthtype!="wide"){
			$(".groupwrapper").children(".entry").css("display","block");
			$("body").removeClass("thin").addClass("wide");
			$("#sideLeft").jScrollPane({
				autoReinitialise:true,
				autoReinitialiseDelay:10,
			});
			$("#AppBar").jScrollPane({
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
$(document).ready(function(){
	$(".groupwrapper").hover(function(){
		if($("body").hasClass("thin")){
			$(this).addClass("clicked");
			$(this).children(".entry").css("display","block");
		}
	},function(){
		if($("body").hasClass("thin")){
			$(this).removeClass("clicked");
			$(this).children(".entry").css("display","none");
		}
	})
});
$(window).resize(dynamicLayout);