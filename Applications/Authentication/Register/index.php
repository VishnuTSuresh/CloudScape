<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/**
 * 
 * @author Vishnu T Suresh
 * @author Rajas Shah
 * 
 */
 ThisPage::renderTop("Register");
 ?>
 <link rel="stylesheet" href="style.css" type="text/css" media="screen, projection"/>
<h1>Register</h1>
<p>Select your category</p>
<form name="register" action="step1.php" method="get">
<table id="registerhome">
<tr><td><input type="radio" name="type" value="UNDERGRADUATE" checked="checked" ></td><td>Undergraduate Student</td></tr>
<tr><td><input type="radio" name="type" value="POSTGRADUATE" ></td><td>Postgraduate Student</td></tr>
<!-- <tr><td><input type="radio" name="type" value="ug" ></td><td>Research Scholar</td></tr>
<tr><td><input type="radio" name="type" value="ug" ></td><td>Faculty</td></tr>
<tr><td><input type="radio" name="type" value="ug" ></td><td>Staff</td></tr>-->
<tr><td colspan="2"></td></tr>
<tr><td colspan="2"><input type="submit"></td></tr>
</table>
</form>
<?php
 ThisPage::renderBottom();
 ?>