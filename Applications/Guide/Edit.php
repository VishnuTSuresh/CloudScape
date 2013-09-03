<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once 'Guide.php';
ThisPage::allowsCredentials(["LOGIN"]);
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
	});
	$("#editor_form").submit(function(){
		$("#editor").val(tinyMCE.get("editor").getContent());
	});
 });
</script>
<h1>Guide</h1>

<?php
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
$clean_html = $purifier->purify($_POST["content"]);
echo $clean_html;
$ref=$_GET["ref"];
if($ref){
	$user=ThisPage::getUser();
	$Guide=new Guide($user);
	?>
	<h3>Edit &raquo; <?php echo implode(" &rsaquo; ",explode("|",$ref));?></h3>
	
	<form action="edit.php?ref=<?php echo $_GET["ref"]?>" id="editor_form" method=POST>
	<textarea id="editor" name=content>
	</textarea>
	<input type="submit" value="Submit"/>
	</form>
	<?php 
}
else{

}
ThisPage::renderBottom();
?>