<?php
	require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
	ThisPage::requiresCredentials(["LOGIN"]);
	StateManager::logout();
	header("Location: /Authentication/Login/");
?>