<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
class MySQL
{
	public $domain,$port,$username,$password,$database;
	private static $instance,$mysqli;
	private function __construct(){
		$MySQL=simplexml_load_file("$_SERVER[DOCUMENT_ROOT]/../resources/MySQL.xml");
		$this->domain=$MySQL->domain;
		$this->port=(int)$MySQL->port;
		$this->username=$MySQL->username;
		$this->password=$MySQL->password;
		$this->database=$MySQL->database;
	}
	public static function getInstance(){
		
		if(!isset(MySQL::$instance))
		{
			MySQL::$instance = new MySQL();
		}
		return MySQL::$instance;
	}
	public static function getConnection(){
		$mysql=MySQL::getInstance();
		if(!isset(MySQL::$mysqli))
		{
			MySQL::$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, $mysql->database, $mysql->port);
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		return MySQL::$mysqli;
	}
	public static function query($query,$parameters,$callback){
		$mysql=static::getConnection();
		$result=null;
		if(is_array($parameters)&&(sizeof($parameters)>0)){
			$stmt=$mysql->prepare($query);
			$type="";
			$r_parameters=[];
			foreach ($parameters as $parameter){
				$r_parameters[]=&$parameter;
				switch (gettype($parameter)){
					case "integer":
						$type.="i";
						break;
					case "string":
						$type.="s";
						break;
					case "double":
						$type.="d";
						break;
				}
			}
			array_unshift($r_parameters, $type);
			call_user_func_array([$stmt,"bind_param"],$r_parameters);
			$stmt->execute();
			$result=$stmt->get_result();
		}
		else{
			$result=$mysql->query($query);
		}
		
		if(!$callback||is_bool($result))return $result;
		if(is_object($result)){
			while($row=$result->fetch_assoc()){
				$callback($row);
			}
			$result->data_seek(0);
			return $result;
		}
	}
}
?>