<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
?>

<?php 
$mysql=MySQL::getConnection();
$result=$mysql->query("SELECT password FROM invisible WHERE userid=".$_GET["uid"]."");
while($row=$result->fetch_assoc())
{
	echo $row["password"];
}
?>