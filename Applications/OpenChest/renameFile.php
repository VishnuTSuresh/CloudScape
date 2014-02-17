<?php

/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$id = isset($_POST ["id"]) ? $_POST ["id"] : null;
$newname = isset($_POST ["newname"]) ? $_POST ["newname"] : null;
if ($id && $newname) {
    $file = File::withId($id);
    $folder = $file->getParent();
    $path=$folder->getPath();
    if ($file&&$file->rename($newname)){
        header("Location: ./?path=$path");
                exit();
    }
        
}
header("Location: ./?path=$path&em=".  base64_encode("Rename Failed. Make sure there isn't another file with same name in this folder, or you might have entered an invalid character"));
?>