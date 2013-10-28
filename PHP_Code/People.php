<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class People{
	public static function get($index){
		$id=null;
		MySQL::query("SELECT user_id FROM invisible LIMIT ?,1", $index, function  ($row) use(&$id){
			$id=$row["user_id"];
		});
		return User::withUserId($id);
	}
}