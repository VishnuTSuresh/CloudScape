<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
if(!preg_match("/\.+/", $_GET['path']."/".$_GET['name'])){
	mkdir("chest".$_GET['path']."/".$_GET['name']);
	$logFile = "log.txt";
	$fh = fopen($logFile, 'a') or die("can't open file");
	$stringData = $_GET['path']."/".$_GET['name']." ".$_SESSION['key']."\n";
	fwrite($fh, $stringData);
	fclose($fh);
	header("Location:../?path=".$_GET['path']);
	exit();
}
else{
	header("Location:../?error=1&path=".$_GET['path']);
	exit();
}
	
?>