<?php 
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("OpenChest");
?>
<h2>OpenChest</h2>
<link rel="stylesheet" href="/resources/jquery-ui-1.10.3.custom.css" type="text/css" "/>
<link rel="stylesheet" href="style.css" type="text/css"/>
<script type="text/javascript"
src="/resources/script/jquery-ui.min.js"></script>
<script type="text/javascript"
src="/resources/script/jstorage.js"></script>
<script type="text/javascript" src="script.js"></script>
<?php
if (isset($_GET ['em'])) {
    ?>
<div class="error"><?php echo base64_decode($_GET["em"]); ?></div>
        <?php
}
$path = isset($_GET ['path']) ? $_GET ['path'] : "";
$name = isset($_GET ['name']) ? $_GET ['name'] : "";
$path = str_replace("\\", "/", $path);
$user = ThisPage::getUser();
echo "<h3>";
$currentFolder = Folder::withPath($path);
$path = $currentFolder->getPath();
if ($currentFolder) {
    $breadCrumb = $currentFolder->getPathBreadCrumb();
    foreach ($breadCrumb as $folder) {
        $breadcrumbname=($folder->getName()!="")?$folder->getName():"Chest";
        echo "<a class='button' href=\"?path=" . $folder->getPath() . "\">" . $breadcrumbname . "</a><b>&rsaquo;</b>";
    }
}
echo "</h3>";
$contents = $currentFolder->getContents();
if (is_array($contents)) {
    ?>
    <script type="text/javascript">
    <!--
        var openchestpath = "<?php echo str_replace("\\", "/", $path); ?>";
    //-->
    </script>
    
    <fieldset>
        <legend>Directory View</legend>
    <?php $currentFolder->renderDirectory(); ?>
        <div style="text-align: right;clear:both;">
            <span style="color: #d50000;">Red is Folder</span> <span
                style="color: #006699;">Blue is File</span>
        </div>
        <?php
    if ($user) {
        $clipboard = OpenChest::getClipBoard();
        if (count($clipboard)) {
            ?>
            <fieldset>
                <legend>Clip Board</legend>
                <div id="clipboard">
                    <?php
                    $evenodd = "even";
                    foreach ($clipboard as $entry) {
                        $type = $entry["type"];
                        if ($type == "file") {
                            $file = $entry["object"];
                            $id = $file->getId();
                            $text = $file->getParent()->getPath() . "\\" . $file->getFullName();
                        } else {
                            $folder = $entry["object"];
                            $id = $folder->getId();
                            $text = $folder->getPath();
                        }
                        ?>
                        <div class="<?php echo $evenodd; ?>" style="float: left; width: 100%;clear: both">
                            <span style="float: left;margin: 6px;">
                                <span> <?php echo $entry["action"]; ?> </span>
                                <span> <?php echo $text; ?> </span>
                            </span>
                            <form action="clipboard.php" method="get" style="float: right">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <input type="hidden" name="type" value="<?php echo $type ?>">
                                <input type="submit" name="action" value="Remove From Clipboard">
                            </form>
                        </div>
                        <?php
                        $evenodd = $evenodd == "even" ? "odd" : "even";
                    }
                    ?>
                </div>
                <form action="clipboard.php" style="clear: both">
                    <input type="hidden" name="current_folder_id" value="<?php echo $currentFolder->getId()?>">
                    <input type="submit" name="action" value="Paste">
                </form>
            </fieldset>
        <?php }
    } ?>
    </fieldset>
    <?php if ($user) { ?>
        <fieldset>
            <legend>Tools</legend>
            <fieldset style="float:left">
                <legend>Upload File</legend>
                <form action="savefile.php" method='POST'
                      enctype='multipart/form-data'>
                    <input type="file" name="file" /> <input type=submit value="Upload" />
                    <input type=hidden name="path" value="<?php echo $path ?>" />
                </form>
            </fieldset>
            <fieldset style="float:left">
                <legend>Create New Folder</legend>
                <form action="createfolder.php">
                    <input type="text" name="name" placeholder="Enter Folder Name Here" />
                    <input type=submit value="Create Folder" /> <input type=hidden
                                                                       name="path" value="<?php echo $path ?>" />
                </form>
            </fieldset>
        </fieldset>
        <?php
    }
} else {
    echo "Folder name seems to be incorrect.";
}
ThisPage::renderBottom();
?>