<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class Guide extends UGCS{
	protected static $appname="GUIDE";
	public function __construct($user){
		$this->user=$user;
	}
	protected function appAddBinding($key,$data){
		$mysql=MySQL::getConnection();
		$data=$mysql->real_escape_string($data);
		$query="INSERT INTO guide SET content='$data'";
		$mysql->query($query);
		return $mysql->insert_id;
	}
	protected function appEditBinding($key,$data){
		$mysql=MySQL::getConnection();
		$data=$mysql->real_escape_string($data);
		$query="INSERT INTO guide SET content='$data'";
		$mysql->query($query);
		return $mysql->insert_id;
	}
	protected static function appGetDataBinding($value){
		$mysql=MySQL::getConnection();
		$value=$mysql->real_escape_string($value);
		$query="SELECT content FROM guide WHERE id=$value LIMIT 1";
		$result=$mysql->query($query);
		if($result){
			$row=$result->fetch_assoc();
			$data=$row["content"];
			return $data;
		}
		else{
			return false;
		}
	}
	protected static $homepage="/Guide/";
}
?>
