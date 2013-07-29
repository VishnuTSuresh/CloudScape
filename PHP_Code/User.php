<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class User{
	private $user_id, $username, $firstname, $lastname;
	private function __construct($user_id){
		$this->user_id=$user_id;
	}
	public static function withUserId($user_id){
		$mysql=MySQL::getInstance();
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, $mysql->database, $mysql->port);
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
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, $mysql->database, $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$query="SELECT UPPER(name)AS credential FROM userid_credentials INNER JOIN credentials ON id=credential WHERE user_id=".$this->getUserId();
		$result=$mysqli->query($query) or die($mysqli->error.__LINE__);
		$credentials=array();
		while($row=$result->fetch_assoc())
		{
			 array_push($credentials,$row["credential"]);
		}
		array_push($credentials,"PUBLIC",$this->isLoggedIn()?"LOGIN":NULL);
		return $credentials;
	}
	//$credentials is array
	function hasCredential($reqcredentials){
		$usrcredentials=$this->getCredentials();
		$valid_credentials=array_intersect($reqcredentials,$usrcredentials);
		return (!empty($valid_credentials));
	}
	function isLoggedIn(){
		$mysql=MySQL::getInstance();
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, $mysql->database, $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$query="SELECT EXISTS ( SELECT * FROM login WHERE user_id=".$this->getUserId()." AND expiry_time>NOW() ORDER BY token_no DESC LIMIT 1)";
		$result=$mysqli->query($query) or die($mysqli->error.__LINE__);
		$row=$result->fetch_array();
		return (bool)$row[0];
	}
}
?>