<?php

/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["LOGIN"]);
$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : null;
$action = isset($_REQUEST["action"]) ? (
        ($_REQUEST["action"] == "Copy") ? "copy" : (
                ($_REQUEST["action"] == "Cut") ? "cut" : (
                        ($_REQUEST["action"] == "Paste") ? "paste" : "remove")
                )
        ) : null;
$token_no = isset($_COOKIE["token_no"]) ? intval($_COOKIE["token_no"]) : null;
if ($id && $type && $action && $token_no) {
    if ($type == "file") {
        $file = File::withId($id);
        $path = $file->getParent()->getPath();
        if ($action == "copy") {
            $file->copy();
        } elseif ($action == "cut") {
            $file->cut();
        } else {
            $file->removeFromClipboard();
        }
    } else {
        $folder = Folder::withId($id);
        $path = $folder->getParent()->getPath();
        if ($action == "copy") {
            $folder->copy();
        } elseif ($action == "cut") {
            $folder->cut();
        } else {
            $folder->removeFromClipboard();
        }
    }
} elseif ($action == "paste" && $token_no) {
    $id = isset($_REQUEST["current_folder_id"]) ? $_REQUEST["current_folder_id"] : null;
    $em = array();
    if ($id != null) {
        $destination = Folder::withId($id);
        foreach (OpenChest::getClipBoard() as $entry) {
            if ($entry["action"] == "cut") {
                if ($entry["object"]->moveTo($destination)) {
                    MySQL::query("DELETE FROM openchest_clipboard WHERE token_no=? AND type=? AND id=?", [$token_no, $entry["type"], $entry["object"]->getId()]);
                } else {
                    $em[] = "File/Folder Couldn't be moved. Make sure destination does not contain File/Folder of same name";
                }
            } else {
                if($entry["type"]=="file"){
                    if($entry["object"]->copyTo($destination)){
                        MySQL::query("DELETE FROM openchest_clipboard WHERE token_no=? AND type=? AND id=?", [$token_no, "file", $entry["object"]->getId()]);
                    }
                    else{
                        $em[] = "File/Folder Couldn't be copied. Make sure destination does not contain File/Folder of same name";
                    }
                }
            }
        }
    }
}
if (sizeof($em)) {
    header("Location:$_SERVER[HTTP_REFERER]&em=" . base64_encode(implode(", ", $em)));
} else {
    header("Location:$_SERVER[HTTP_REFERER]");
}
?>