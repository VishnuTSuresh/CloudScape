<?php

require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);

$path = isset($_GET["path"]) ? $_GET["path"] : "";
$name = isset($_GET["name"]) ? $_GET["name"] : null;
$user = ThisPage::getUser();
if ($name && $user) {
    $openChest = new OpenChest($user);
    $openChest->createFolder($path, $name);
}

?>