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
}
?>