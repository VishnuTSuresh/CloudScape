<?php
/*
 * @author Abhas Mittal
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop("OPENCHEST");
?>
<h1>OPENCHEST</h1>
<form action="?path=<?php echo $_GET['path']; ?>" method="post" enctype="multipart/form-data">
<fieldset><legend>Upload File</legend>
Filename: <input type="file" name="file" id="file" />
<input type="hidden" name="path" value="<?php echo $_GET['path']; ?>" />
<input type="submit" name="fileSubmit" value="Upload File" />
</fieldset>
</form>

<br />
<form action="?path=<?php echo $_GET['path']; ?>" method="post" enctype="multipart/form-data">
<fieldset><legend>Create Folder</legend>
Make Folder: <input type="text" name="folder" />
<input type="hidden" name="path" value="<?php echo $_GET['path']; ?>" />
<input type="submit" name="folderSubmit" value="Make Folder" />
</fieldset>
</form>
<?php 
ThisPage::renderBottom();
?>
