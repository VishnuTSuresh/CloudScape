$(function()
{
	$(document).ready(function()
			{

			$(".dropdown").click(function()
			{
				var X=$(this).hasClass('dropdown_active');
				if(X==true)
				{
					$(".submenu").hide();
					$(this).removeClass('dropdown_active'); 
				}
				else
				{
					$(".submenu").show();
					$(this).addClass('dropdown_active');
				}
			});

			//Mouse click on sub menu
			$(".submenu").mouseup(function()
			{
			return false
			});

			//Mouse click on my account link
			$(".dropdown").mouseup(function()
			{
			return false
			});


			//Document Click
			$(document).mouseup(function()
			{
			$(".submenu").hide();
			$(".dropdown").removeClass('dropdown_active');
			});
			});
});