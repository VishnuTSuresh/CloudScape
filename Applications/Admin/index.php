<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["ADMIN"]);
ThisPage::renderTop("Admin");
?>
<h1>Admin</h1>

<?php 
ThisPage::renderBottom();
?>
