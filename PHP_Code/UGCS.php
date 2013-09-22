<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";

Class UGCS{
	protected static $tblnm="user_generated_content_system",$appname="";
	protected $user=NULL;
	public function __construct($user){
		$this->user=$user;
	}
	protected function appAddBinding($key,$data){
		$value=NULL;
		return $value;
	}
	public function add($key,$data,$comment){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$comment=$mysqli->real_escape_string($comment);
		$query="SELECT `key` FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."'";
		$result=$mysqli->query($query);
		
		if(intval($result->num_rows)==0){
			$value=$this->appAddBinding($key,$data);
			$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id,comment)
			VALUES ('".static::$appname."', '$key',$value,NOW(),".$this->user->getUserId().",'$comment')";
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
	public function edit($key,$data,$comment){
		Console::log($comment);
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$comment=$mysqli->real_escape_string($comment);
		$query="SELECT branch_node FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$value=$this->appEditBinding($key,$data);
			$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id, branch_node,`comment`)
			VALUES ('".static::$appname."', '$key',$value,NOW(),".$this->user->getUserId().",".$row['branch_node'].",'$comment')";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	public function delete($key){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$query="SELECT branch_node FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id, branch_node)
			VALUES ('".static::$appname."', '$key',NULL,NOW(),".$this->user->getUserId().",".$row['branch_node'].")";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	public static function getKeysLike($regexp){
		$mysqli=MySQL::getConnection();
		$query="SELECT `key` FROM ".$tblnm." WHERE `key` REGEXP '$regexp' AND app_name='".$appname."' ORDER BY `key` ASC";
		$result=$mysqli->query($query);
		return $result;
	}
	protected static function appGetDataBinding($value){
		$data=NULL;
		return $data;
	}
	public static function getData($key,$history){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$history=$history?$history:0;
		$query="SELECT `value` FROM ".self::$tblnm." WHERE `key` = '$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT $history,1";
		$result=$mysqli->query($query);
		if($result){
			$row=$result->fetch_assoc();
			$value=$row["value"];
			
			$data=static::appGetDataBinding($value);
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
	//not yet implemented. current apps dont require it.
	}
	public static function history($key,$limit){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$query="SELECT creation_time,user_id,branch_node,comment FROM ".self::$tblnm." WHERE `key` = '$key' AND app_name='".static::$appname."' ORDER BY creation_time DESC LIMIT $limit";
		$result=$mysqli->query($query);
		if($result){
			return $result;
		}
		else{
			return false;
		}
	}
}
?>