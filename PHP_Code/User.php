<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class User{
	protected $user_id, $username, $firstname, $lastname, $password, $type;
	private function __construct($user_id){
		$this->user_id=$user_id;
	}
	public static function withUserId($user_id){
		$user=new User($user_id);
		if($user->hasCredential(["UNDERGRADUATE"])){
			$ug=Undergraduate::withUserId($user_id);
			return $ug;
		}
		elseif($user->hasCredential(["POSTGRADUATE"])){
			$pg=Postgraduate::withUserId($user_id);
			return $pg;
		}
		else{
			return NULL;
		}
	}
	public static function withUserName($username){
		$mysql=MySQL::getConnection();
		$query="SELECT user_id FROM invisible WHERE username='$username'";
		$result=$mysql->query($query);
		if($result)
		{
			if($result->num_rows){
				$row=$result->fetch_assoc();
				$user=User::withUserId($row["user_id"]);
				return $user;
			}
		}
		return NULL;
				
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
	function setPassword($password){
		$this->password=$password;
	}
	function getUserName($escape){
		$username=$this->username;
		if($escape)
			$username=htmlentities($username);
		return $username;
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
	function getType(){
		return $this->type;
	}
	function getCredentials(){
		$mysql=MySQL::getConnection();
		$query="SELECT UPPER(name) AS credential FROM userid_credentials INNER JOIN credentials ON id=credential WHERE user_id=".$this->getUserId();
		$result=$mysql->query($query);
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
	function addCredentials($credentials){
		$mysql=MySQL::getConnection();
		foreach ($credentials as $credential){
			$mysql->query("INSERT INTO userid_credentials SET user_id=".$this->getUserId().", credential=".Credentials::getIdFrom($credential));
			return TRUE;
		}
		return FALSE;
	}
	function removeCredentials($credentials){
		$mysql=MySQL::getConnection();
		foreach ($credentials as $credential){
			$cred_id=Credentials::getIdFrom($credential);
			$mysql->query("DELETE FROM userid_credentials WHERE user_id=".$this->getUserId()." AND credential=$cred_id");
		}
	}
	function isLoggedIn(){
		$mysql=MySQL::getInstance();
		$mysqli= new mysqli($mysql->domain, $mysql->username, $mysql->password, $mysql->database, $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$query="SELECT EXISTS ( SELECT * FROM login WHERE user_id=".$this->getUserId()." AND expiry_time>NOW() ORDER BY token_no DESC LIMIT 1)";
		$result=$mysqli->query($query);
		$row=$result->fetch_array();
		return (bool)$row[0];
	}
}
?>