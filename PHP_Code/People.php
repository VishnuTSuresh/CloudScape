<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class People{
	public static function get($page,$limit){
		$index=($page-1)*$limit;
		$range=$limit;
		$users=null;
		MySQL::query("SELECT user_id as id FROM invisible LIMIT ?,?", [$index,$range], function  ($row) use(&$users){
			$users[]=User::withUserId($row["id"]);
		});
		return $users;
	}
}