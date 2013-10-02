<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
/*
 * @author Vishnu T Suresh
 */

if(isset($_GET["user_id"]))
{
	$user=User::withUserId($_GET["user_id"]);
	if($user->hasCredential(["POSTGRADUATE"])){
		$mysql=MySQL::getConnection();
		$username=$mysql->real_escape_string($_POST["username"]);
		$password=$mysql->real_escape_string($_POST["password"]);
		$user->setUserName($username);
		$user->setPassword($password);
		if($user->save()){
			ThisPage::renderTop("UG Registration");
			?>
			<h1>Register &rsaquo; Postgraduate &rsaquo; <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
			<p>Congratulations, you can now <a href="Authentication/Login">login</a>.</p>
			<?php
			ThisPage::renderBottom();
		}
		else{
			header("Location:step2.php");
		}
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
			<h1>Register &rsaquo; Undergraduate &rsaquo; <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
			<p>Congratulations, you can now <a href="Authentication/Login">login</a>.</p>
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
