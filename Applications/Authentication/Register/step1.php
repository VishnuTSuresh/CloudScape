<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/*
*
*@author Rajas Shah
*@author Vishnu T Suresh
*Date Created: 08/08/13
*
*/
ThisPage::renderTop("UG Registration");
if($_GET['type']=="something"){
	
}
else
{
	?>
	
	<h1>Undergraduate Registration</h1>
	
	<?php 
	if(isset($_GET['errorcode']))
	{
		if($_GET['errorcode']==1){
			?>
			<div class='error'>
				Enrollment number is invalid, Please contact administrator if you believe the enrollment number is valid
			</div>
			<?php 
		}
		if($_GET['errorcode']==2){
			?>
			<div class='error'>
				User seems to be already registered. If this is your enrollment number and you are positive you have not registered, please contact administartor.
			</div>
			<?php 
		}
	}
	?>

	<form action="step2.php" method="get">
		<input type="hidden" name="type" value="<?php echo $_GET['type'];?>" />
		<label for="enrollment">Enrollment Number:</label>
		<input type="text" name="enrollment" id="enrollment" autofocus="autofocus"/>
		<input type="submit"/>
		<input type="reset"/>
	</form>
<?php 
}
ThisPage::renderBottom()?>