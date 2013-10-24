<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
require_once 'Guide.php';
ThisPage::allowsCredentials(["LOGIN"]);
if($_POST["content"]){
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	$clean_html = $purifier->purify($_POST["content"]);
	$Guide=new Guide(ThisPage::getUser());
	if($Guide->add($_GET[key],$clean_html,$_POST["comment"])){
		header("Location:/Guide/index.php?ref=$_GET[key]");
	}
	else if($Guide->edit($_GET[key],$clean_html,$_POST["comment"])){
		
		header("Location:/Guide/index.php?ref=$_GET[key]");
	}
}
ThisPage::renderTop("Guide");
?>
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
	var validator= new FormValidator("editor_form",[{name:"comment",display:"Comments",rules: 'required|min_length[10]'}],function(errors,evt){

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
<h1>Guide</h1>

<?php 
$ref=$_GET["key"];
if($ref){
	$user=ThisPage::getUser();
	$Guide=new Guide($user);
	?>
	<h3>Edit &raquo; <?php echo implode(" &rsaquo; ",explode("/",$ref));?></h3>
	
	<form name="editor_form" action="edit.php?key=<?php echo $_GET["key"]?>" id="editor_form" method=POST>
	<textarea id="editor" name=content><?php echo Guide::getData($_GET["key"]);?></textarea>
	Comments:
	<textarea id="comment" name=comment></textarea>
	<div id="error_box"></div>
	<input type="submit" value="Submit" title="Please enter comment"/>
	</form>
	<?php 
}
else{

}
ThisPage::renderBottom();
?>
