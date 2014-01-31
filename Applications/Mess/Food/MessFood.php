<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
/**
 *
 * @author Vishnu T Suresh
 *        
 */
class MessFood extends UGCS {
	protected static $appname = "MESS_FOOD";
	protected static $homepage = "/Mess/Food/Edit.php";
	public static function getNewKey() {
		$key = 0;
		MySQL::query ( "SELECT `key` FROM mess_food ORDER BY `key` DESC LIMIT 1", [ ], function ($row) use(&$key) {
			$key = $row ["key"] + 1;
		} );
		return $key;
	}
	public static function getFoodList() {
		$foodlist = [ ];
		MySQL::query ( "SELECT `key`, name,current FROM mess_food WHERE current=1 OR current=-1", [ ], function ($row) use(&$foodlist) {
			$foodlist [$row ["key"]] = [ 
					"name" => $row ["name"],
					"state" => $row ["current"] 
			];
		} );
		return $foodlist;
	}
	protected function appAddBinding($key, $name) {
		$id = false;
		$mysql = MySQL::getConnection ();
		$name = $mysql->real_escape_string ( htmlspecialchars ( $name ) );
		$key = intval ( $key );
		$query = "INSERT INTO mess_food SET `key`=$key,name='$name', current=1";
		if ($mysql->query ( $query )) {
			$id = $mysql->insert_id;
		}
		return $id;
	}
	protected function appEditBinding($key, $name) {
		$id = false;
		$mysql = MySQL::getConnection ();
		$key = intval ( $key );
		$query = "UPDATE mess_food SET current=0 WHERE `key`=$key";
		$mysql->query ( $query );
		$name = $mysql->real_escape_string ( htmlspecialchars ( $name ) );
		$query = "INSERT INTO mess_food SET `key`=$key,name='$name', current=1";
		if ($mysql->query ( $query )) {
			$id = $mysql->insert_id;
		}
		return $id;
	}
	protected static function appGetDataBinding($value) {
		$data = NULL;
		MySQL::query ( "SELECT name FROM mess_food WHERE id=?", [ 
				$value 
		], function ($row) use(&$data) {
			$data = $row ["name"];
		} );
		return $data;
	}
	protected static function appGetMetaBinding($value) {
		$data = NULL;
		return $data;
	}
	protected function appDeleteBinding($key) {
		MySQL::query ( "UPDATE mess_food SET current=-1 WHERE `key`=? AND current=1", $key );
	}
	protected function appUndoBinding($key, $value) {
		MySQL::query ( "UPDATE mess_food SET current=0 WHERE `key`=?", $key );
		MySQL::query ( "UPDATE mess_food SET current=1 WHERE id=?", $value );
	}
}