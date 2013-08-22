<?php
	require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
	ThisPage::allowsCredentials(["LOGIN"]);
	StateManager::logout();
	header("Location: /Authentication/Login/");
?>
