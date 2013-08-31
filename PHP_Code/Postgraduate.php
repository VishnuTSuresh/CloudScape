<?php
/*
 * @author Vishnu T Suersh
 * this is just copied from UG, change it when you have more info, ie do PG students have enrollment number?
 * or is it called something else?
 */
class Postgraduate extends User{
	protected $enroll_no;
	private function __construct($user_id){
		$this->user_id=$user_id;
		$this->type="POSTGRADUATE";
	}
	public static function withUserId($user_id){
		$mysql=MySQL::getConnection();
		$query="SELECT enroll_no,username,firstname,lastname FROM invisible INNER JOIN signup_pg ON invisible.user_id=signup_pg.user_id WHERE invisible.user_id=$user_id";
		$result=$mysql->query($query);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$user= new Postgraduate($user_id);
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
	public static function withEnrollment($enum){
		$mysqli=MySQL::getConnection();
		$query="SELECT user_id FROM signup_pg WHERE enroll_no=$enum";
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
		$username = $mysql->real_escape_string($this->getUserName());
		$enroll_no= $mysql->real_escape_string($this->getEnrollmentNumber());
		$firstname = $mysql->real_escape_string($this->getFirstName());
		$lastname = $mysql->real_escape_string($this->getLastName());
		$password = $mysql->real_escape_string($this->password);
	
		$passwordquery="";
		if($password){
			$passwordquery="password='$password'";
		}
		$mysql = MySQL::getConnection();
		$query = "UPDATE invisible INNER JOIN signup_pg on invisible.user_id = signup_pg.user_id SET username='$username', enroll_no=$enroll_no, firstname='$firstname', lastname='$lastname', $passwordquery WHERE invisible.user_id=$user_id";
		$result=$mysql->query($query);
		if($result){
			$this->addCredentials(["REGISTERED"]);
			return TRUE;
		}
		return FALSE;
	}
	public static function createNew($username,$password,$enroll_no,$firstname,$lastname){
		$mysqli=MySQL::getConnection();
		$query="INSERT INTO invisible SET username='$username', password='$password'";
		if($mysqli->query($query))
		{
			$user_id=$mysqli->insert_id;
			$query="INSERT INTO signup_pg SET user_id=$user_id, enroll_no=$enroll_no,firstname='$firstname',lastname='$lastname'";
			if($mysqli->query($query)){
				if($user=Postgraduate::withUserId($user_id)){
					if($user->addCredentials(["POSTGRADUATE"])){
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}
}