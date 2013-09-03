<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class Guide extends UGCS{
	public function __construct($user){
		$this->user=$user;
		$this->app_name="GUIDE";
	}
	protected function appAddBinding($key,$data){
		$mysql=MySQL::getConnection();
		$query="INSERT INTO guide SET content=$data";
		$mysql->query($query);
		return $mysql->insert_id;
	}
	protected function appEditBinding($key,$data){
		$mysql=MySQL::getConnection();
		$query="INSERT INTO guide SET content=$data";
		$mysql->query($query);
		return $mysql->insert_id;
	}
	protected function appGetDataBinding($value){
		$mysql=MySQL::getConnection();
		$query="SELECT content FROM guide WHERE id=$value LIMIT 1";
		$result=$mysql->query($query);
		if($result){
			$row=$result->fetchassoc();
			$data=$row["content"];
			return $data;
		}
		else{
			return false;
		}
	}
}
?>