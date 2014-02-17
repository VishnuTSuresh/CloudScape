<?php
/**
 * @author Vishnu T Suresh
 */
class OpenChest {
	public static function pathIsWithinChest($path) {
		$fullpath = self::fullpath ( $path );
		$chestpath = self::fullpath ( "" );
		$chestpathlength = strlen ( $chestpath );
		if (substr ( $fullpath, 0, $chestpathlength ) === $chestpath) {
			return true;
		}
		return false;
	}
	public static function fullpath($path) {
		$path = $_SERVER ["DOCUMENT_ROOT"] . "/OpenChest/folder with increadibly unguessable folder name/" . $path;
		return realpath ( $path );
	}
	public static function download($path,$name) {
		$folder=Folder::withPath($path);
		$file=File::getFile($folder, $name);
		$file->download();
	}
	private $user = null;
	public function OpenChest($user) {
		$this->user = $user;
	}
	public function savefile($path) {
		$folder = Folder::withPath ( $path );
		$file = File::newFile ( $folder, $_FILES ['file'] ['name'], $_FILES ['file'] ['tmp_name'] );
		if ($file) {
			header ( "Location:./?path=" . $path );
			exit ();
		} else {
			header ( "Location:./?em=".  base64_encode("File with same name alredy exist in this folder. Please rename either one of the files before uploading")."&path=" . $path );
			exit ();
		}
	}
	public function createFolder($path, $name) {
		ThisPage::allowsCredentials ( [ 
				"LOGIN" 
		] );
		if (Folder::withPath($path)->addNewFolder($name)) {
			header ( "Location:./?path=" . $path );
			exit ();
		} else {
			header("Location:./?em=".  base64_encode(
                                "Folder couldn't be added, Folder with same name alrerady exist in this folder."
                                )."&path=" . $path);
			exit ();
		}
	}
        public static function getClipBoard() {
            $token_no=isset($_COOKIE["token_no"])?intval($_COOKIE["token_no"]):null;
            if($token_no){
                $clipboard=array();
                MySQL::query("SELECT id,type,action FROM openchest_clipboard WHERE token_no=?",$token_no ,function($row) use(&$clipboard){
                    if($row["type"]=="file"){
                        $file=  File::withId($row["id"]);
                        
                        $clipboard[]=["object"=>$file,"type"=>"file","action"=>$row["action"]];
                    }else{
                        $folder=Folder::withId($row["id"]);
                        $clipboard[]=["object"=>$folder,"type"=>"folder","action"=>$row["action"]];
                    }
                });
                return $clipboard;
            }
            return null;
        }
}