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
		$mysql = MySQL::getConnection();
		
		$user_id = $this->getUserId();
		$username = $mysql->real_escape_string($this->getUserName());
		$enroll_no= $mysql->real_escape_string($this->getEnrollmentNumber());
		$firstname = $mysql->real_escape_string($this->getFirstName());
		$lastname = $mysql->real_escape_string($this->getLastName());
		$password = $mysql->real_escape_string($this->password);
		
		$passwordquery="";
		if($password){
			$passwordquery="password='$password'";
		}
		
		$query = "UPDATE invisible INNER JOIN signup_ug on invisible.user_id = signup_ug.user_id SET username='$username', enroll_no=$enroll_no, firstname='$firstname', lastname='$lastname', $passwordquery WHERE invisible.user_id=$user_id";
		$result=$mysql->query($query);
		if($result){
			$this->addCredentials(["REGISTERED"]);
			return TRUE;
		}
		return FALSE;
	}
	public static function createNew($username,$password,$enroll_no,$firstname,$lastname,$year_of_joining,$programme_id){
		$mysqli=MySQL::getConnection();
		$query="INSERT INTO invisible SET username='$username', password='$password'";
		if($mysqli->query($query))
		{
			$user_id=$mysqli->insert_id;
			$query="INSERT INTO signup_ug SET user_id=$user_id, enroll_no=$enroll_no,firstname='$firstname',lastname='$lastname',year_of_joining=$year_of_joining,programme_id=$programme_id";
			if($mysqli->query($query)){
				if($user=Undergraduate::withUserId($user_id)){
					if($user->addCredentials(["UNDERGRADUATE"])){
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}
} 
?>