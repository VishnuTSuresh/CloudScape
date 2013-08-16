<?php
/*
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class Undergraduate extends User{
	protected $enroll_no;
	private function __construct($user_id){
		$this->user_id=$user_id;
		$this->type="UNDERGRADUATE";
	}
	public static function withUserId($user_id){
		$mysql=MySQL::getConnection();
		$query="SELECT enroll_no,username,firstname,lastname FROM invisible INNER JOIN signup_ug ON invisible.user_id=signup_ug.user_id WHERE invisible.user_id=$user_id";
		$result=$mysql->query($query);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$user= new Undergraduate($user_id);
				$user->setEnrollmentNumber($row["enroll_no"]);
				$user->setUserName($row["username"]);
				$user->setFirstName($row["firstname"]);
				$user->setLastName($row["lastname"]);
				$user->setPassword(NULL);
				return $user;
			}
		}
		else {
			return NULL;
		}
	}
	public static function withEnrollment($enum){ //Created by Rajas for registration purpose
		$mysqli=MySQL::getConnection();
		$query="SELECT user_id FROM signup_ug WHERE enroll_no=$enum";
		$result=$mysqli->query($query);
		while($row = $result->fetch_assoc()){
			return User::withUserId($row["user_id"]);
		}
		return NULL;
	}
	function setEnrollmentNumber($enroll_no){
		$this->enroll_no=$enroll_no;
	}
	function getEnrollmentNumber(){
		return $this->enroll_no;
	}
	function save(){
		$user_id = $this->getUserId();
		$username = $this->getUserName();
		$enroll_no= $this->getEnrollmentNumber();
		$firstname = $this->getFirstName();
		$lastname = $this->getLastName();
		$password = $this->password;
		
		$passwordquery="";
		if($password){
			$passwordquery="password='$password'";
		}
		$mysql = MySQL::getConnection();
		$query = "UPDATE invisible INNER JOIN signup_ug on invisible.user_id = signup_ug.user_id SET username='$username', enroll_no=$enroll_no, firstname='$firstname', lastname='$lastname', $passwordquery WHERE invisible.user_id=$user_id";
		$result=$mysql->query($query);
		if($result){
			$this->addCredentials(["REGISTERED"]);
			return TRUE;
		}
		return FALSE;
	}
} 
?>