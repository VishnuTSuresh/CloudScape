<?php

/**
 * @author Vishnu T Suresh
 */
class File {

    private $id;
    private $folder;
    private $name;
    private $extension;
    private $description;

    private function File(Folder $folder, $name) {
        $this->folder = $folder;
        $this->name = $name;
        $id = null;
        $description = null;
        MySQL::query("SELECT id,description FROM openchest_files WHERE name=? AND parent_id=?", [$name, $folder->getId()], function ($row) use(&$id, &$description) {
            $id = $row["id"];
            $description = $row["description"];
        });
        $this->id = $id;
        $this->description = $description;
        $this->extension = substr(strrchr($name, "."), 1);
    }

    public function getName() {
        return substr($this->name, 0, strlen($this->name) - strlen($this->extension) - 1);
    }

    public function getFullName() {
        return $this->name;
    }

    public function getExtension() {
        return $this->extension;
    }

    public function getFullPath() {
        return $this->folder->getFullPath() . "\\" . $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public static function newFile(Folder $folder, $name, $contentPath, $description = "None") {
        $user_id = ThisPage::getUser()->getUserId();
        $folderPath = $folder->getFullPath();
        $newpathname = $folderPath . "/" . $name;
        if (is_file($contentPath) && !is_file($newpathname)) {
            rename($contentPath, $newpathname);
            MySQL::query("INSERT INTO openchest_files (parent_id,name,description,user_id) VALUES (?,?,?,?)", [$folder->getId(), $name, $description, $user_id]);
            return self::getFile($folder, $name);
        } else {
            unlink($contentPath);
            return null;
        }
    }

    public static function getFile(Folder $folder, $name) {
        $path = $folder->getFullPath();
        if (is_file($path . "/" . $name)) {
            $file = new File($folder, $name);
            return $file;
        } else {
            return false;
        }
    }

    public static function withId($id) {
        $parent_id = null;
        $name = null;
        MySQL::query("SELECT parent_id,name FROM openchest_files WHERE id=?", $id, function($row) use(&$parent_id, &$name) {
            $parent_id = $row["parent_id"];
            $name = $row["name"];
        });
        $folder = Folder::withId($parent_id);
        return File::getFile($folder, $name);
    }

    public function moveTo(Folder $folder) {
        $targetpath = $folder->getFullPath();
        $targetname = $targetpath . "/" . $this->name;
        if (!is_file($targetname)) {
            if (rename($this->getFullPath(), $targetname)) {
                MySQL::query("UPDATE openchest_files SET parent_id=? WHERE id=?", [$folder->getId(), $this->id]);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function copyTo(Folder $folder) {
        $targetpath = $folder->getFullPath();
        $targetname = $targetpath . "/" . $this->name;
        $user = ThisPage::getUser();
        if (!is_file($targetname) && $user) {
            if (copy($this->getFullPath(), $targetname)) {
                MySQL::query("INSERT INTO openchest_files (parent_id,name,description,user_id) VALUES (?,?,?,?)", [$folder->getId(), $this->name, $this->description, $user->getUserId()]);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function rename($newName) {
        if (!$this->folder->hasFile($newName . "." . $this->extension)) {
            $fullname = $newName . "." . $this->extension;
            $newPath = $this->folder->getFullPath() . "\\" . $fullname;
            if (rename($this->getFullPath(), $newPath)) {
                MySQL::query("UPDATE openchest_files SET name=? WHERE id=?", [$fullname, $this->id]);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function delete() {
        if (!$this->isWithin(Folder::withId(1))) {
            $destination = Folder::withId(1);
            if ($this->moveTo($destination)) {
                return true;
            }
        } elseif (ThisPage::getUser()->hasCredential(["ADMIN"])) {
            
            if (unlink($this->getFullPath())) {
                MySQL::query("DELETE FROM openchest_files WHERE id=?", $this->getId());
                MySQL::query("DELETE FROM openchest_clipboard WHERE id=? AND type=?", [$this->getId(),"file"]);
                return true;
            }
        }
        return false;
    }

    public function copy() {
        $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
        if ($token_no) {
            MySQL::query("REPLACE INTO openchest_clipboard (token_no,action,type,id) VALUES (?,?,?,?)", [$token_no, "copy", "file", $this->id]);
        }
    }

    public function cut() {
        $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
        if ($token_no) {
            MySQL::query("REPLACE INTO openchest_clipboard (token_no,action,type,id) VALUES (?,?,?,?)", [$token_no, "cut", "file", $this->id]);
        }
    }

    public function removeFromClipboard() {
        $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
        if ($token_no) {
            MySQL::query("DELETE FROM openchest_clipboard WHERE token_no=? AND type=? AND id=?", [$token_no, "file", $this->id]);
        }
    }

    public function isWithin(Folder $folder) {
        if ($folder->getId() == 0) {
            return true;
        }
        $parent = $this->getParent();
        do {
            if ($parent->getId() == $folder->getId())
                return true;
            $parent = $parent->getParent();
        }while ($parent->getId() != 0);
        return false;
    }

    public function getParent() {
        return $this->folder;
    }

    public function download() {
        flush();
        $path = $this->folder->getFullPath();
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $this->name . "\"");
        readfile($this->getFullPath());
    }

}
