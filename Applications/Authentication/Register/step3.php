<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/*
 * @author Vishnu T Suresh
 */

if(isset($_GET["user_id"]))
{
	$user=User::withUserId($_GET["user_id"]);
	if(FALSE){
		
	}
	elseif($user->hasCredential(["UNDERGRADUATE"])){
		$mysql=MySQL::getConnection();
		$username=$mysql->real_escape_string($_POST["username"]);
		$password=$mysql->real_escape_string($_POST["password"]);
		$user->setUserName($username);
		$user->setPassword($password);
		if($user->save()){
			ThisPage::renderTop("UG Registration");
			?>
			<h1>Registration > Undergraduate > <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
			<p>Congratulations, you can now login.</p>
			<?php
			ThisPage::renderBottom();
		}
		else{
			header("Location:step2.php");
		}
	}
	else{
		header("Location:./");
	}
}
else{
	header("Location:./");
}
?>