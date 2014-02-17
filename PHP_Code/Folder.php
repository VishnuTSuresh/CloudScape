<?php

/**
 * @author Vishnu T Suresh
 */
class Folder {

    private $path;
    private $id;
    private $description;

    private function Folder($path) {
        $this->path = $path;
        $id = 0;
        $description = null;
        $path_components = explode("\\", $path);
        foreach ($path_components as $component) {
            MySQL::query("SELECT id FROM openchest_folders WHERE parent_id=? AND name=?", [$id, $component], function($row) use (&$id) {
                $id = intval($row["id"]);
            });
        }
        MySQL::query("SELECT description FROM openchest_folders WHERE id=?", $id, function($row) use(&$description) {
            $description = $row["description"];
        });
        $this->id = intval($id);
        $this->description = $description;
    }

    public static function withPath($path) {
        if (OpenChest::pathIsWithinChest($path)) {
            $path = substr(OpenChest::fullpath($path), strlen(OpenChest::fullpath("")));
            $folder = new Folder($path);
            return $folder;
        } else {
            return false;
        }
    }

    public static function withId($id) {
        $parent_id = null;
        $name = null;
        if ($id == 0) {
            return Folder::withPath("");
        }
        MySQL::query("SELECT parent_id,name FROM openchest_folders WHERE id=?", $id, function($row) use(&$name, &$parent_id) {
            $parent_id = intval($row["parent_id"]);
            $name = $row["name"];
        });
        return Folder::withPath(Folder::withId($parent_id)->getPath() . "\\" . $name);
    }

    public function getId() {
        return intval($this->id);
    }

    public function getName() {
        if ($this->path) {
            return substr($this->path, strlen($this->getParent()->getPath()) + 1);
        } else {
            return "";
        }
    }

    public function getPath() {
        return $this->path;
    }

    public function getFullPath() {
        $path = OpenChest::fullpath($this->path);
        return $path;
    }

    public function addNewFolder($name, $description = "None") {
        if (strpbrk($name, "\\/?%*:|\"<>") == false && !is_dir($this->getFullPath() . "\\" . $name)) {
            mkdir($this->getFullPath() . "\\" . $name);
            $user_id = ThisPage::getUser()->getUserId();
            MySQL::query("INSERT INTO openchest_folders (parent_id,name,description,user_id) VALUES (?,?,?,?)", [$this->id, $name, $description, $user_id]);
            return true;
        }
        return false;
    }

    public function hasFile($name) {
        return is_file($this->getFullPath() . "\\" . $name);
    }

    public function getParent() {
        $path = $this->getPath();
        $parentPath = substr($path, 0, strlen($path) - strlen(strrchr($path, "\\")));
        return Folder::withPath($parentPath);
    }

    public function moveTo(Folder $folder) {
        if ($this->id != 1) {
            $targetpath = $folder->getFullPath();
            $targetname = $targetpath . "/" . $this->getName();
            if (!is_dir($targetname)) {
                if (rename($this->getFullPath(), $targetname)) {
                    MySQL::query("UPDATE openchest_folders SET parent_id=? WHERE id=?", [$folder->getId(), $this->id]);
                    return true;
                }
            }
        }
        return false;
    }

    public function rename($newname) {
        if (strpbrk($newname, "\\/?%*:|\"<>") == false && $this->id != 1) {
            $parent = $this->getParent();
            $newPath = $parent->getFullPath() . "\\" . $newname;
            if (!is_dir($newPath) && rename($this->getFullPath(), $newPath)) {
                MySQL::query("UPDATE openchest_folders SET name=? WHERE id=?", [$newname, $this->id]);
                $this->path = Folder::withPath($parent->getPath() . "\\" . $newname)->getPath();
                return true;
            }
        }
        return false;
    }

    public function delete() {
        if ($this->id != 1) {
            if (!$this->isWithin(Folder::withId(1))) {
                $destination = Folder::withId(1);
                if ($this->moveTo($destination)) {
                    return true;
                }
            } elseif (ThisPage::getUser()->hasCredential(["ADMIN"])) {
                if(rmdir($this->getFullPath())){
                    MySQL::query("DELETE FROM openchest_folders WHERE id=?", $this->getId());
                    MySQL::query("DELETE FROM openchest_clipboard WHERE id=? AND type=?", [$this->getId(),"folder"]);
                    return true;
                }
            }
        }
        return false;
    }

    public function copy() {
        if ($this->id != 1) {
            $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
            if ($token_no) {
                MySQL::query("REPLACE INTO openchest_clipboard (token_no,action,type,id) VALUES (?,?,?,?)", [$token_no, "copy", "folder", $this->id]);
            }
        }
    }

    public function cut() {
        if ($this->id != 1) {
            $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
            if ($token_no) {
                MySQL::query("REPLACE INTO openchest_clipboard (token_no,action,type,id) VALUES (?,?,?,?)", [$token_no, "cut", "folder", $this->id]);
            }
        }
    }

    public function removeFromClipboard() {
        $token_no = isset($_COOKIE["token_no"]) ? $_COOKIE["token_no"] : null;
        if ($token_no) {
            MySQL::query("DELETE FROM openchest_clipboard WHERE token_no=? AND type=? AND id=?", [$token_no, "folder", $this->id]);
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

    public function getPathBreadCrumb() {
        $folder = $this;
        $chest = Folder::withPath("");
        $breadCrumb = array();
        while ($folder->getPath() != $chest->getPath()) {
            $breadCrumb[] = $folder;
            $folder = $folder->getParent();
        }
        $breadCrumb[] = $chest;
        $breadCrumb = array_reverse($breadCrumb);
        return $breadCrumb;
    }

    public function getContents() {
        if ($handle = opendir($this->getFullPath())) {
            $contents = array();
            $count = -2;
            $entry = readdir($handle);
            while (false !== $entry) {
                if ($count >= 0) {

                    $fullpath = $this->getFullPath() . "\\" . $entry;
                    if (is_file($fullpath)) {
                        $contents[] = [
                            "type" => "file",
                            "object" => File::getFile($this, $entry)
                        ];
                    } elseif (is_dir($fullpath)) {
                        $path = $this->getPath() . "\\" . $entry;
                        $contents[] = [
                            "type" => "folder",
                            "object" => Folder::withPath($path)
                        ];
                    }
                }
                $entry = readdir($handle);
                $count++;
            }
            closedir($handle);
            return $contents;
        } else {
            return false;
        }
    }

    public function renderDirectory() {
        $contents = $this->getContents();
        $path = $this->getPath();
        $user = ThisPage::getUser();
        foreach ($contents as $index => $content) {
            $entryclass = ($index % 2 == 0) ? "even" : "odd";
            ?>
            <div class="openchestentry <?php echo $entryclass; ?>" class>

                <?php
                if ($content["type"] == "file") {
                    $file = $content["object"];
                    $entry = $file->getFullName();
                    $name = $file->getName();
                    $id = $file->getId();
                    $type = "file";
                    $renameUrl = "renameFile.php";
                    $icon = "_blank.png";
                    if (is_file("icon/" . $file->getExtension() . ".png")) {
                        $icon = $file->getExtension() . ".png";
                    }
                    ?>
                    <a class='openchestlink' style='color:#006699' href="download.php?path=<?php echo $path; ?>&name=<?php echo $entry; ?>">
                        <img src="icon/<?php echo $icon; ?>" style="vertical-align: middle">
                        <?php echo $entry; ?></a>
                        <?php
                } else {

                    $folder = $content["object"];
                    $entry = $folder->getName();
                    $name = $entry;
                    $id = $folder->getId();
                    $type = "folder";
                    $renameUrl = "renameFolder.php";
                    $icon = "folder.png";
                    if ($folder->getId() == 1) {
                        $icon = "recyclebin.png";
                    }
                    ?>
                    <a class='openchestlink'  style='color:#d50000' href="?path=<?php echo $path; ?>/<?php echo $entry; ?>">
                        <img src="icon/<?php echo $icon; ?>" style="vertical-align: middle">
                        <?php echo $entry; ?></a>   
                        <?php
                }
                //Folder with id 1 is Recycle Bin. It shouldnt be moved or renamed.
                if ($user && !($type == "folder" && $folder->getId() == 1)) {
                    ?>
                    <?php if (!$content["object"]->isWithin(Folder::withId(1)) || $user->hasCredential(["ADMIN"])) { ?>
                        <form action="delete.php" method="get">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="type" value="<?php echo $type ?>">
                            <input class="openchestcutcopy" type="submit" name="action" value="Delete"></input>
                        </form>
                        <?php
                    }
                    ?>
                    <span class="openchestrename">
                        <button>Rename</button>
                        <form style="display: none;" action="<?php echo $renameUrl; ?>" method="post">
                            <table style="width:100%;text-align: center;">
                                <tr><td>
                                        <input type="hidden" name="id" value="<?php echo $id ?>"> 
                                        <input type="text" name="newname" value="<?php echo $name; ?>">
                                    </td></tr>
                                <tr><td>
                                        <input type="submit" value="Rename">
                                    </td></tr>
                            </table>
                        </form>
                    </span>
                    <form action="clipboard.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="type" value="<?php echo $type ?>">
                        <input class="openchestcutcopy" type="submit" name="action" value="Cut"></input>
                    </form>
                    <?php
                    if ($type == "file") {
                        ?>
                        <form action="clipboard.php" method="get">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="type" value="<?php echo $type ?>">
                            <input class="openchestcutcopy" type="submit" name="action" value="Copy"></input>
                        </form>
                    <?php } ?>
                <?php }
                ?>
                <br />
            </div>
            <?php
        }
    }

}
?>