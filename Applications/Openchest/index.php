<?php
/*
 * @author Abhas Mittal
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("OPENCHEST");
?>
<h1>Openchest</h1>
<form action="?ref=<?php echo $_GET['ref']; ?>" method="post" enctype="multipart/form-data">
<fieldset><legend>Upload File</legend>
Filename: <input type="file" name="file" id="file" />
<input type="hidden" name="path" value="<?php echo $_GET['ref']; ?>" />
<input type="submit" name="fileSubmit" value="Upload File" />
</fieldset>
</form>

<br />
<form action="?ref=<?php echo $_GET['ref']; ?>" method="post" enctype="multipart/form-data">
<fieldset><legend>Create Folder</legend>
<label for="folder">Folder Name: </label><input type="text" name="folder" />
<input type="hidden" name="path" value="<?php echo $_GET['ref']; ?>" />
<input type="submit" name="folderSubmit" value="Make Folder" />
</fieldset>
</form>
<?php 
ThisPage::renderBottom();
?>
