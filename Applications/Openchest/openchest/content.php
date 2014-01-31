<h2>OpenChest</h2>
<?php 

if(isset($_GET['error'])){
	echo "foldername cant have dots. sorry. security policy :(<br />";
}
$path=isset($_GET['path'])?$_GET['path']:"";
$name=isset($_GET['name'])?$_GET['name']:"";
	$path=str_replace("\\","/",$path);
	
	echo "<h3>";
	echo "<a href=\"index.php\">Chest</a>";
	$patharray=explode("/",$path);
	$pathtemp='';
	foreach ($patharray as $folder){
		echo "<a href=\"?path=$pathtemp$folder\">$folder / </a>";
		$pathtemp.=$folder."/";
	}
	echo "</h3>";
	if ($handle = opendir('openchest/chest/'.$path)) {
		?>
<fieldset>
<legend>Directory View</legend>
  		<?php 
	    $count=0;
	    while (false !== ($entry = readdir($handle))) {
			$count++;
			if($count>2){
				if(filetype("openchest/chest/$path/$entry")=="file"){
					echo "<a style='color:#006699' href=\"download.php?path=openchest/chest/$path/$entry\">".$entry."</a><br />";
				}
				else{
					echo "<a href=\"?path=$path/$entry\">$entry</a><br />";
				}
	        }
	    }
	    closedir($handle);
	    ?>
	    <div style="text-align:right">
	    <span style="color:#d50000;">Red is Folder</span>
	    <span style="color:#006699;">Blue is File</span>
	    </div>
</fieldset>

<fieldset>
<legend>Tools</legend>
	<fieldset>
		<legend>Upload File</legend>
		<form action="openchest/savefile.php" method='POST' enctype='multipart/form-data'>
			<input type="file" name="file"/>
			<input type=submit value="Upload" />
			<input type=hidden name="path" value="<?php echo $path?>"/>
		</form>
	</fieldset>
	<fieldset>
		<legend>Create New Folder</legend>
		<form action="openchest/createfolder.php">
			<input type="text" name="name" placeholder="Enter Folder Name Here"/>
			<input type=submit value ="Create Folder"/>
			<input type=hidden name="path" value="<?php echo $path?>"/>
		</form>
	</fieldset>
</fieldset>
	    <?php 
	}
	else{
		echo "Folder name seems to be incorrect.";
	}?>