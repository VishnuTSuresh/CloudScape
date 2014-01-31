<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop ( "OpenChest" );
include 'openchest/content.php';
ThisPage::renderBottom ();
?>