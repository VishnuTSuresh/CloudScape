<?php 
/*
 * Author: Rajas Shah
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
if (isset($_POST['step1'])) {
	$register = User::withEnrollment($_POST["enrollment"],$_POST["type"]);
	if($register->getRegistered()==0)
	{
		ThisPage::renderTop("UG Registration");
?>
		
<?php
 
		ThisPage::renderBottom();
	}
	else 
		header("Location: step1.php");
} 
?>