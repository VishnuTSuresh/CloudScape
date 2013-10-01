<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class Mess extends UGCS{
	public static function getFoodList(){
		$mysql=MySQL::getConnection();
		$query="SELECT id,name FROM mess_items";
		$result=$mysql->query($query);
		return $result;
	}
	public static function keyFromDate($date){
		$timestamp=strtotime($date);
		$timestamp=$timestamp?$timestamp:$date;
		$key=date("o\WW",$timestamp);
		if($key)return $key;
		return date("o\WW");
	}
}
?>