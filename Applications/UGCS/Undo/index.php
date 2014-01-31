<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

ThisPage::allowsCredentials(["LOGIN"]);
$classname=base64_decode($_GET["c"]);
ThisPage::renderTop("$classname Undo");

$curruser=ThisPage::getUser();
$id=$_GET["id"];

if($classname){
	$UGCS=new $classname($curruser);
	$meta=$UGCS::getMetaById($id);
	if(isset($_POST["submit"])&&$id){
		$comment=$_POST["comment"];
		if($UGCS->undo($id, $comment)){
			//header("location: /UGCS/History?c=".$_GET["c"]."&k=".base64_encode($meta["key"]));
		}
		else{
			echo "<h1>UNDO FAILED FOR SOME UNKNOWN REASON</h1>";
		}
	}
	else{
		$revuser=User::withUserId($meta["user_id"]);
		?>
		<h1><?php echo $classname;?> &rsaquo; Undo</h1>
		<h3>Undo <?php echo $classname;?> for <?php echo implode("&rsaquo;",preg_split("(\/|\\\\)", $meta["key"]));?> to revision #<?php echo $id?> originally authored by <?php echo $revuser->getFirstName()." ".$revuser->getLastName();?></h3>
		<form method=POST>
		Comment (State why you are performing this undo) :
		<textarea name=comment></textarea>
		<input type="submit" name="submit" value="Submit">
		</form>
		<?php 
	}
}
ThisPage::renderBottom();
?>
