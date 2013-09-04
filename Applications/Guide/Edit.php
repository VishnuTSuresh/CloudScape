<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once 'Guide.php';
ThisPage::allowsCredentials(["LOGIN"]);
if($_POST["content"]){
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	$clean_html = $purifier->purify($_POST["content"]);
	$Guide=new Guide(ThisPage::getUser());
	if($Guide->add($_GET[ref],$clean_html)){
		header("Location:/Guide/index.php?ref=$_GET[ref]");
	}
	else if($Guide->edit($_GET[ref],$clean_html)){
		header("Location:/Guide/index.php?ref=$_GET[ref]");
	}
}
ThisPage::renderTop("Guide");
?>
<script type="text/javascript" src="/Resources/script/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="/Resources/script/tinymce/js/tinymce/tinymce.min.js"></script>
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
	
	
 });
</script>
<h1>Guide</h1>

<?php 
$ref=$_GET["ref"];
if($ref){
	$user=ThisPage::getUser();
	$Guide=new Guide($user);
	?>
	<h3>Edit &raquo; <?php echo implode(" &rsaquo; ",explode("|",$ref));?></h3>
	
	<form action="edit.php?ref=<?php echo $_GET["ref"]?>" id="editor_form" method=POST>
	<textarea id="editor" name=content><?php echo Guide::getData($_GET["ref"]);?></textarea>
	<input type="submit" value="Submit"/>
	</form>
	<?php 
}
else{

}
ThisPage::renderBottom();
?>