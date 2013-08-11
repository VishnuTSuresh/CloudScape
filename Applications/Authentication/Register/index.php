<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/**
 * 
 * @author Rajas Shah
 *
 */
 if(isset($_GET['submit']))
 {
   header("Location: step1.php");   
 }

 ThisPage::renderTop("Register");
 ?>
<h1>Register</h1>
Select your category
<form name="register" action="step1.php" method="get">
<select name="type">
    <option value="ug">Undergraduate Student</option>
    <option value="pg">Postgraduate Student</option>
    <option value="phd">Research Scholar</option>
    <option value="fac">Faculty</option>
    <option value="sta">Staff</option>
</select>
<input type="submit" name="submit" value="Confirm">
</form>
<?php
 ThisPage::renderBottom();
 ?>