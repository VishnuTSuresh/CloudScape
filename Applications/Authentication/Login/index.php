<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop("Login");
$username="";
$password="";
$message="";
if(isset($_POST["username"])&&isset($_POST["password"])){
	$username="$_POST[username]";
	$password="$_POST[password]";
	if(StateManager::authenticate($username, $password)){
	    header('Location: /Home/');
	}	
  	else
  	{
  		$message="username or password incorrect";
  	}
}
?>
<link rel="stylesheet" href="StyleSheet.css" type="text/css" media="screen, projection" />
<h1 class="title">Login</h1>
<div class="login_background">
<img src="images/1.jpg?w=1200&h=500&mode=crop" />
</div>
<div id="login">
<form action="" method="POST">
  <label for="username">Username:</label><br />
  <input type="text" name="username" id="username" value="<?php echo $username?>"></input><br />
  <label for="password">Password:</label><br />
  <input type="password" name="password"  id="password" value="<?php echo $password?>"></input><br />
  <div class="error"><?php echo $message?></div><br />
  <input type="submit"></input>
  <a href="../Register/index.php">Register</a>
</form>
</div>

<?php ThisPage::renderBottom();?>