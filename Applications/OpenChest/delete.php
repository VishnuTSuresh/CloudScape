<?php

/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : null;
$userisadmin=  ThisPage::getUser()->hasCredential(["ADMIN"]);
if ($id && $type) {
    if ($type == "file") {
        $file = File::withId($id);
        if (!$file->isWithin(Folder::withId(1))||$userisadmin) {
            if ($file->delete()) {
                header("Location:$_SERVER[HTTP_REFERER]");
                exit();
            }
        }
    } else {
        $folder = Folder::withId($id);
        if (!$folder->isWithin(Folder::withId(1))||$userisadmin) {
            if ($folder->delete()) {
                header("Location:$_SERVER[HTTP_REFERER]");
                exit();
            }
        }
    }
}
header("Location:$_SERVER[HTTP_REFERER]&em=" . base64_encode("Delete Unsuccessful, Recycle bin might already contain a file/folder with same name. Please rename this file/folder"));
