<?php
/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$id = isset($_POST ["id"]) ? $_POST ["id"] : null;
$newname = isset($_POST ["newname"]) ? $_POST ["newname"] : null;
if ($id && $newname) {
	$folder = Folder::withId($id);
        $path=$folder->getParent()->getPath();
	if($folder&&$folder->rename($newname)){
                
                header("Location: ./?path=$path");
                exit();
	}
}
header("Location: ./?path=$path&em=".  base64_encode("Rename Failed. Make sure there isn't another folder with same name in this folder, or you might have entered an invalid character"));