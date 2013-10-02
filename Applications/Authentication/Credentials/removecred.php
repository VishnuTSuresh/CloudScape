<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$user=ThisPage::getUser();
if(isset($_GET["credential"])){
	$user->removeCredentials([$_GET["credential"]]);
}
header("Location:./");
?>
