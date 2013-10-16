<?php
$autoload_phpcode=function ($classname){
	switch ($classname){
		case "Guide":
			require_once "$_SERVER[DOCUMENT_ROOT]/Guide/Guide.php";
			break;
		case "Mess":	
			require_once "$_SERVER[DOCUMENT_ROOT]/Mess/Mess.php";
			break;
		case "MessFood":
			require_once "$_SERVER[DOCUMENT_ROOT]/Mess/Food/MessFood.php";
			break;
		default:
			require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/$classname.php";
	}
};
spl_autoload_register($autoload_phpcode);
require_once "$_SERVER[DOCUMENT_ROOT]\..\PHP_Code\HTMLPurifier\library\HTMLPurifier.auto.php";
?>
