<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/**
 *
 * @author Vishnu T Suresh
 *
 */
class User{
	private $user_id, $username, $firstname, $lastname;
	private function __construct($user_id){
		$this->user_id=$user_id;
	}
	public static function withUserId($user_id){
		$mysql=MySQL::getInstance();
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, "information services website", $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$query="SELECT username,firstname,lastname FROM invisible INNER JOIN signup_ug ON invisible.user_id=signup_ug.user_id WHERE invisible.user_id=$user_id";
		$result=$mysqli->query($query) or die($sql->error.__LINE__);;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				
				$user= new User($user_id);
				$user->setUserName($row["username"]);
				$user->setFirstName($row["firstname"]);
				$user->setLastName($row["lastname"]);
				return $user;
			}
		}
		else {
			return NULL;
		}
	}
	function setUserName($username){
		$this->username=$username;
	}
	function setFirstName($firstname){
		$this->firstname=$firstname;
	}
	function setLastName($lastname){
		$this->lastname=$lastname;
	}
	function getUserName(){
		return $this->username;
	}
	function getUserId(){
		return $this->user_id;
	}
	function getFirstName(){
		return $this->firstname;
	}
	function getLastName(){
		return $this->lastname;
	}
	function getCredentials(){
		$mysql=MySQL::getInstance();
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, "information services website", $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$query="SELECT name,id FROM userid_credentials INNER JOIN credentials ON credentials.id=userid_credentials.credential WHERE user_id=".$this->getUserId();
		$result=$mysqli->query($query) or die($sql->error.__LINE__);
		return $result;
	}
}
?>