<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class Mess extends UGCS{
	public static function getFoodList(){
		$mysql=MySQL::getConnection();
		$query="SELECT id,name FROM mess_items";
		$result=$mysql->query($query);
		return $result;
	}
}
?>