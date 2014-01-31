<?php
require_once 'OpenChest.php';
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$path=isset($_POST["path"])?$_POST["path"]:null;
$user=ThisPage::getUser();
if($path&&$user){
	$openChest=new OpenChest($user);
	$openChest->savefile($path);
}
?>