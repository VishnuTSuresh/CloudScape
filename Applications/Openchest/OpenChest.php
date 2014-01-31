<?php
class OpenChest {
	// public static $root="/O"
	public static function download($path) {
		if ($path != null && is_file ( $path )) {
			// echo $path;
			// echo is_file($path)?"file":"not file";
			// echo "Content-disposition: attachment; filename=\"" . basename($path) . "\"";
			header ( 'Content-Type: application/octet-stream' );
			header ( "Content-Transfer-Encoding: Binary" );
			header ( "Content-disposition: attachment; filename=\"" . basename ( $path ) . "\"" );
			readfile ( $path );
		}
	}
	private $user = null;
	public function OpenChest($user) {
		$this->user = $user;
	}
	public function savefile($path) {
		if (! preg_match ( "/\.+/", $path )) {
			$target_Path = "chest" . $path . "/";
			$target_Path = $target_Path . basename ( $_FILES ['file'] ['name'] );
			move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $target_Path );
			
// 			$logFile = "log.txt";
// 			$fh = fopen ( $logFile, 'a' ) or die ( "can't open file" );
// 			$stringData = $_POST ['path'] . "/" . basename ( $_FILES ['file'] ['name'] ) . " " . $_SESSION ['key'] . "\n";
// 			fwrite ( $fh, $stringData );
// 			fclose ( $fh );
			
			header ( "Location:../?path=" . $_POST ['path'] );
			exit ();
		} else {
			header ( "Location:../hp?error=1&path=" . $_POST ['path'] );
			exit ();
		}
		
		header ( "Location:../?path=" . $_POST ['path'] );
		exit ();
	}
}