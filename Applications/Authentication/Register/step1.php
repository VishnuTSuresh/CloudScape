<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/*
*
*@Author Rajas Shah
*Date Created: 08/08/13
*
*/
ThisPage::renderTop("UG Registration");
?>
<h1>Undergraduate Registration</h1>
<form action="step2.php" method="post">
	<input type="hidden" name="type" value="<?php echo $_GET['type'];?>" />
	<label for="enrollment">Enrollment Number:</label>
	<input type="text" name="enrollment" id="enrollment" autofocus="autofocus"/>
	<input type="submit" name="step1" id="submit" />
	<input type="reset" name="reset" id="reset" />
</form>
<?php ThisPage::renderBottom()?>