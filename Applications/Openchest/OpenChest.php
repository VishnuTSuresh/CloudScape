<?php
/**
 *
 * @author Abhas Mittal
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";

Class OpenChest
{
	private $branch;
	private $year;
	private $fileName;
	private $size;
	private $mysqli;
	
	public function __construct($fileName)
	{
		$this->fileName=$fileName;	
	}
	
	public function upload($path, $fileName, $size)
	{
		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		//echo $extension."<br>";
		//$path = $branch."/".$year."/";
		//echo $path."<br>";
		$filename = basename($fileName,".".$extension);
		//echo $filename;
			if($_FILES["file"]["error"]>0)
			{
				echo "Return Code: ".$_FILES["file"]["error"];
			}
			else
			{
				if(file_exists("chest/ ".$filename))
				{
					echo "The file with this name already exists";
				}
				else
				{
					$mysqli = MySQL::getConnection();
					move_uploaded_file($_FILES["file"]["tmp_name"],"chest/ ".$filename);
					$query = "INSERT INTO main.openchest (filePath, fileName, fileExtension) VALUE('$path', '$filename', '$extension')";
					$select = $mysqli->query($query);
					echo $select;
				}
			}
	}
	
	public function mkFolder($path, $folder)
	{	
		$mysqli = MySQL::getConnection();
		$query = "INSERT INTO main.folder (path,folderName) VALUES ('$path','$folder')";
		$mysqli->query($query);
	}
	
	public function download($file)
	{
		if (file_exists($file))
		{
    		header('Content-Description: File Transfer');
    		header('Content-Type: application/octet-stream');
    		header('Content-Disposition: attachment; filename='.$file);
    		header('Content-Transfer-Encoding: binary');
    		header('Expires: 0');
    		header('Cache-Control: must-revalidate');
    		header('Pragma: public');
    		header('Content-Length: ' . filesize($file));
    		ob_clean();
    		flush();
    		readfile($file);
    		exit;
		}
	}
}
?>