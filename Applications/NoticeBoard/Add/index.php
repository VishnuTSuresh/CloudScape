<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
ThisPage::renderTop("Add Notice");
if(isset($_POST["add_notice"])){
	$user=ThisPage::getUser();
	if($user){
		$title=isset($_POST["title"])?$_POST["title"]:null;
		$content=isset($_POST["content"])?$_POST["content"]:null;
		$post_date=null;
		if(isset($_POST["post_date_bool"])){
			$post_date=isset($_POST["post_date"])?$_POST["post_date"]:null;
		}
		if($title&&$content){
			
			$notice=new Notice(["title"=>$title,"content"=> $content,"post_date"=>$post_date,"user"=>$user]);
			$noticeboard=new NoticeBoard($user);
			$noticeboard->addNotice($notice);
		}
	}
}
?>
<link rel="stylesheet" href="/Resources/jquery-ui-1.10.3.custom.css" type="text/css"/>
<script type="text/javascript" src="/Resources/script/jquery-ui.min.js"></script>
<script type="text/javascript" src="/Resources/script/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="/Resources/script/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/Resources/script/validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#editor").tinymce({
		plugins: [
		          "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
		          "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		          "save table contextmenu directionality emoticons template paste textcolor"
		 ],
		 init_instance_callback : function() {
		   }
	});
	var calender=$("#notice_calender");
	calender.datepicker({ 
		firstDay: 1,
		changeMonth: true,
		changeYear: true,
		onSelect: function(dateText, inst) { 
			$("#post_date").val(dateText);
		},
		dateFormat: "d-M-yy",
	});
	calender.hide();
	$("#post_date_bool").button().change(function(){
		if($(this).is(":checked")){
			calender.show();
		}
		else{
			calender.hide();
		}
	});
	var validator= new FormValidator("add_notice",
		[{
			 name:"title",
			 display:"Title",
			 rules: 'required|min_length[5]'
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
});
</script>
<h1><a href="../">Notice Board</a> &raquo; Add Notice</h1>
<form name="add_notice" method="post">
Title:
<input type="text" name="title">
Content:
<textarea name="content" id="editor"></textarea>
<br />
<input class="button" type="checkbox" id="post_date_bool" name="post_date_bool" value="true"><label for="post_date_bool">Postpone the display of this notice to a later date?</label><br />
<br />
<div id="notice_calender" class="button"></div>
<br />
<input type="hidden" name="post_date" id="post_date">
<div id="error_box"></div>
<input type="submit" name="add_notice" value="Add"> 
</form>
<?php 
ThisPage::renderBottom();
?>