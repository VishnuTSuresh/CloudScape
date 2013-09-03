<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";

Class UGCS{
	protected $tblnm="user_generated_content_system",$app_name="",$user=NULL;
	public function __construct($user){
		$this->user=$user;
	}
	protected function appAddBinding($key,$data){
		$value=NULL;
		return $value;
	}
	public function add($key,$data){
		$value=appAddBinding($key,$data);
		$mysqli=MySQL::getConnection();
		$query="SELECT `key` FROM $tblnm WHERE `key`='$key' AND app_name='$app_name'";
		$result=$mysqli->query($query);
		if($result->num_rows==0){
			$query="INSERT INTO $tblnm (app_name, `key`, `value`,creation_time,user_id)
			VALUES ('$app_name', '$key',$value,NOW(),".$user->getUserId().")";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	protected function appEditBinding($key,$data){
		$value=NULL;
		return $value;
	}
	public function edit($key,$data){
		$value=appEditBinding($key,$data);
		$mysqli=MySQL::getConnection();
		$query="SELECT branch_node FROM $tblnm WHERE `key`='$key' AND app_name='$app_name' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$query="INSERT INTO $tblnm (app_name, `key`, `value`,creation_time,user_id, branch_node)
			VALUES ('$app_name', '$key',$value,NOW(),".$user->getUserId().",".$row['branch_node'].")";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	public function delete($key){
		$mysqli=MySQL::getConnection();
		$query="SELECT branch_node FROM $tblnm WHERE `key`='$key' AND app_name='$app_name' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$query="INSERT INTO $tblnm (app_name, `key`, `value`,creation_time,user_id, branch_node)
			VALUES ('$app_name', '$key',NULL,NOW(),".$user->getUserId().",".$row['branch_node'].")";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	public static function getKeysLike($regexp){
		$mysqli=MySQL::getConnection();
		$query="SELECT `key` FROM $tblnm WHERE `key` REGEXP '$regexp' AND app_name='$app_name' ORDER BY `key` ASC";
		$result=$mysqli->query($query);
		return $result;
	}
	protected function appGetDataBinding($value){
		$data=NULL;
		return $data;
	}
	public static function getData($key){
		$mysqli=MySQL::getConnection();
		$query="SELECT `value` FROM $tblnm WHERE `key` = $key AND app_name='$app_name' ORDER BY creation_time DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($result){
			$row=$result->fetch_assoc();
			$value=$row["value"];
			$data=appGetDataBinding($value);
			if($data){
				return $data;
			}
			return false;
		}
		else{
			return false;
		}
	}
	protected function appGetMetaBinding($value){
		$data=NULL;
		return $data;
	}
	public static function getMeta($key){
	
	}
}
?>