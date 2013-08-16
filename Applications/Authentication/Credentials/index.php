<?php 
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::requiresCredentials(["LOGIN"]);
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
foreach($credentials as $credential)
{
?>
<li><?php echo $credential?> <a href="removecred.php?credential=<?php echo $credential?>">&times;</a></li>
<?php
}
?>
</ul>
<ul>
<?php
	$conn=MySQL::getConnection();
	$query="select id, name from credentials";
	$result=$conn->query($query);
	while($row = $result->fetch_assoc()) {
?>

<li><a href=index.php?credential=<?php echo $row["id"];?>><?php echo $row["name"];?></a></li>
<?php 
	}
?>
</ul>
<?php 
}else{
$conn=MySQL::getConnection();
$query="select name from credentials where id=$_GET[credential]";
$result=$conn->query($query);
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
<tr><td colspan=2><input type="hidden" name="credential" value="<?php echo $_GET['credential'];?>" /><input type="submit" /><td></tr>
</form>
</tbody>
</table>
<?php 
}
ThisPage::renderBottom();
?>