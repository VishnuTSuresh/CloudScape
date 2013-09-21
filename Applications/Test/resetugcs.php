<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
$mysql=MySQL::getConnection();
$result=$mysql->query("TRUNCATE TABLE guide");
if($result){
	echo "guide delete success<br />";
}
else{
	echo "guide delete fail<br />";
}
$result=$mysql->query("TRUNCATE TABLE user_generated_content_system");
if($result){
	echo "ugcs delete success<br />";
}
else{
	echo "ugcs delete fail<br />";
}
?>