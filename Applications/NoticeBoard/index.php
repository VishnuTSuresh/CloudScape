<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
ThisPage::renderTop("Notice Board");
?>
<h1>Notice Board</h1>
<?php ThisPage::renderBottom();?>
