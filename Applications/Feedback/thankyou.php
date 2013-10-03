<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Thank You");
if (isset($_POST['submit'])) {
	$user=ThisPage::getUser();
	if ($user != NULL){
		$userID = $user->getUserId();
	} else {
		$userID = 0;
	}
	$mysql=MySQL::getConnection();
	$description=$mysql->real_escape_string($_POST["description"]);
	$ref=$mysql->real_escape_string($_POST["ref"]);
	$type = $mysql->real_escape_string($_POST["type"]);
	if ($mysql->query("INSERT INTO feedback SET reference='$ref', type='$type', description='$description', user_id='$userID'")) {
		?>
		<h1>Thank You :)</h1><br>
		<div id="thankyou" class="success">Thank You for your valuable feeback. We will get back to you soon.<br><br>- Regards IMG.</div>
		<?php 
	} else {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
} else {
	header("Location: ../Home/");
} 
ThisPage::renderBottom();
?>
