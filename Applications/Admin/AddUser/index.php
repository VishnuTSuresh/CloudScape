<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(["ADMIN"]);
ThisPage::renderTop("Admin");
?>
<h1>Admin &rsaquo; Add User</h1>
<?php if(isset($_GET["type"])){
	if($_GET["type"]=="POSTGRADUATE")
	{?>
		<form action="add.php" method="POST">
		<fieldset>
		<legend>Postgraduate:</legend>
		<table>
		<tr><td><label for="enroll_no">Enrollment number</label></td><td><input type="text" name="enroll_no" id="enroll_no"/></td></tr>
		<tr><td><label for="firstname">First Name</label></td><td><input type="text" name="firstname" id="firstname"/></td></tr>
		<tr><td><label for="lastname">Last Name</label></td><td><input type="text" name="lastname" id="lastname"/></td></tr>
			    <input type="hidden" name="type" value="POSTGRADUATE">
			    <tr><td colspan=2><input type="submit" value="Add User" /></td></tr>
			    </table>
			  </fieldset>
			</form>
			<?php
	}else{
	?>
	<form action="add.php" method="POST">
	  <fieldset>
	    <legend>Undergraduate:</legend>
	    <table>
	    <tr><td><label for="enroll_no">Enrollment number</label></td><td><input type="text" name="enroll_no" id="enroll_no"/></td></tr>
	    <tr><td><label for="firstname">First Name</label></td><td><input type="text" name="firstname" id="firstname"/></td></tr>
	    <tr><td><label for="lastname">Last Name</label></td><td><input type="text" name="lastname" id="lastname"/></td></tr>
	    <tr><td><label for="year_of_joining">Year of Joining</label></td><td><input type="text" name="year_of_joining" id="year_of_joining"/></td></tr>
	    <tr><td><label for="programme_id">Programme</label></td><td>
	    <select name="programme_id" id="programme_id">
	    <?php 
	    $mysql=MySQL::getConnection();
	    $query="SELECT id,name FROM programmes";
	    $result=$mysql->query($query);
	    while($row=$result->fetch_assoc()){
			?>
			<option value=<?php echo $row["id"];?>><?php echo $row["name"];?></option>
			<?php 
		}
	    ?></select></td></tr>
	    <input type="hidden" name="type" value="UNDERGRADUATE">
	    <tr><td colspan=2><input type="submit" value="Add User" /></td></tr>
	    </table>
	  </fieldset>
	</form>
	<?php
	}
}else{
?>

<form action="index.php">
<p>Only users added to database will be able to register</p>
  <fieldset>
    <legend>Select type:</legend>
    <table>
    <tr><td><input type="radio" name=type value="UNDERGRADUATE" checked="checked" /></td><td>Undergraduate</td></tr>
    <tr><td><input type="radio" name=type value="POSTGRADUATE" /></td><td>Postgraduate</td></tr>
    <tr><td colspan=2><input type="submit" /></td></tr>
    </table>
  </fieldset>
</form>
<?php 
}
ThisPage::renderBottom();
?>
