<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$path=isset($_GET["path"])?$_GET["path"]:"";
$folder=  Folder::withPath($path);
if($folder){
    $name=isset($_GET["name"])?$_GET["name"]:null;
    $path=$folder->getPath();
    if($name){
        $file=File::getFile($folder, $name);
        if($file){
            $file->download();
        }
        else{
            header("Location:.?path=$path&em=".base64_encode("Incorrect File Name"));
            exit();
        }
    }
    else{
        header("Location:.?path=$path&em=".base64_encode("Incorrect name"));
         exit();
    }
}
else{
    header("Location:.?em=".base64_encode("incorrect path"));
    exit();
}

?>