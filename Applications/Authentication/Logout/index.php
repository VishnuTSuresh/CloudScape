<?php
	require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
	StateManager::logout();
	header("Location: /Authentication/Login/");
?>