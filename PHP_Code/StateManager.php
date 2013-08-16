<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";

class StateManager{
	public static function authenticate($username, $password){
		$mysql=MySQL::getInstance();
		$conn=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
		$result=$conn->query("SELECT user_id FROM invisible WHERE username='$username' AND password='$password' LIMIT 1") or die($conn->error);
		$row=$result->fetch_array(MYSQLI_ASSOC);
		$result->free();
		if(isset($row[user_id])){
			$user=User::withUserId($row[user_id]);
			if($user->hasCredential(["REGISTERED"])){
				$conn->query("INSERT INTO login (user_id,uuid,expiry_time) VALUES($row[user_id],uuid(),'".date("Y-m-d H:i:s",strtotime("+1 hour"))."')") or die($conn->error);
				$result=$conn->query("SELECT token_no,uuid,expiry_time FROM login WHERE user_id='$row[user_id]' ORDER BY token_no DESC LIMIT 1") or die($conn->error);
				$row=$result->fetch_array(MYSQLI_ASSOC);
				$result->free();
				setcookie("token_no",$row["token_no"],strtotime($row['expiry_time']),"/");
				setcookie("uuid",$row["uuid"],strtotime($row['expiry_time']),"/");
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	public static function logout(){
		$mysql=MySQL::getInstance();
		$conn=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$conn->query("UPDATE login SET expiry_time=NOW() WHERE token_no='$_COOKIE[token_no]' AND uuid='$_COOKIE[uuid]'");
		setcookie("token_no","",time() - 3600,"/");
		setcookie("uuid","",time() - 3600,"/");
	}
}
?>