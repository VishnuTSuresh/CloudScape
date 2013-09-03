<?php
function __autoload($classname){
	require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/$classname.php";
}
require_once "$_SERVER[DOCUMENT_ROOT]\PHP_Code\HTMLPurifier\library\HTMLPurifier.auto.php";
?>