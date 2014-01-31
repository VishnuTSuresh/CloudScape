<?php 
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

$mysql=MySQL::getInstance();
$conn=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
$user_id=ThisPage::getUser()->getUserId();

$query="REPLACE INTO userid_credentials SET user_id=$user_id, credential=$_POST[credential]";
$result=$conn->query($query)or die($conn->error.__LINE__);

header("Location: /Authentication/Credentials/");
?>
