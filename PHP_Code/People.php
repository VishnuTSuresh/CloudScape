<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class People{
	public static function get($index,$range=1){
		$users=null;
		MySQL::query("SELECT user_id FROM invisible LIMIT ?,?", [$index,$range], function  ($row) use(&$users){
			$users[]=User::withUserId($row["id"]);
		});
		return $users;
	}
}