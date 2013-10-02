<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$username=$_GET["username"];
$user=User::withUserName($username);
if(!$user){
	echo 1;
}
else{
	echo 0;
}
?>
