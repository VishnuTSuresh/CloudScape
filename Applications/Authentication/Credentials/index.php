<?php 
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop("Credentials");
?>
<h1>Credentials</h1>
<?php
if(!isset($_GET["credential"]))
{
?>
You currently have the following credentials:
<ul>
<?php 
$thisuser=ThisPage::getUser();
$credentials=$thisuser->getCredentials();
while($row1=$credentials->fetch_assoc())
{
?>
<li><?php echo $row1["name"]?></li>
<?php
}
$credentials->free();
?>
</ul>
<ul>
<?php
	$mysql=MySQL::getInstance();
	$conn=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
	$query="select id, name from credentials";
	$result=$conn->query($query)or die($conn->error.__LINE__);
	while($row = $result->fetch_assoc()) {
?>

<li><a href=index.php?credential=<?php echo $row["id"];?>><?php echo $row["name"];?></a></li>
<?php 
	}
?>
</ul>
<?php 
}else{
$mysql=MySQL::getInstance();
$conn=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
$query="select name from credentials where id=$_GET[credential]";
$result=$conn->query($query)or die($conn->error.__LINE__);
$row = $result->fetch_assoc();
$result->free();
?>
<table>
<thead><?php echo $row["name"];?></thead>
<tbody>
<form action="authenticate.php" method="post">
<tr>
<td>Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr><td colspan=2><input type="hidden" name="credential" value="<?php echo $_GET[credential];?>" /><input type="submit" /><td></tr>
</form>
</tbody>
</table>
<?php 
}
ThisPage::renderBottom();
?>