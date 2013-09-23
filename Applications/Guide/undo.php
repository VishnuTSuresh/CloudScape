<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once "Guide.php";
ThisPage::renderTop("Undo");
ThisPage::allowsCredentials(["LOGIN"]);
$curruser=ThisPage::getUser();
$id=$_GET["id"];
$meta=Guide::getMetaById($id);
if($_POST["submit"]&&$id){
	$comment=$_POST["comment"];
	$Guide=new Guide($curruser);
	if($Guide->undo($id, $comment)){
		header("location:History.php?ref=".$meta["key"]);
	}
	else{
		echo "<h1>UNDO FAILED FOR SOME UNKNOWN REASON</h1>";
	}
}
$revuser=User::withUserId($meta["user_id"]);
?>
<h1>Guide &raquo; Undo</h1>
<h3>Undo guide for <?php echo implode("&rsaquo;",preg_split("(\/|\\\\)", $meta["key"]));?> to revision #<?php echo $id?> originally authored by <?php echo $revuser->getFirstName()." ".$revuser->getLastName();?></h3>
<form method=POST>
Comment (State why you are performing this undo) :
<textarea name=comment>

</textarea>
<input type="submit" name="submit" value="Submit">
</form>
<?php 
ThisPage::renderBottom();
?>