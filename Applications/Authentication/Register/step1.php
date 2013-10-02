<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
/*
*
*@author Rajas Shah
*@author Vishnu T Suresh
*Date Created: 08/08/13
*
*/
$title="";
$type="";
function printerror(){
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
	elseif(isset($_GET['errormessage'])){
	?>
		<div class='error'>
			<?php echo $_GET['errormessage'];?>
		</div>
	<?php 
	}
}
function printform($type){
	if($type=="POSTGRADUATE"){
		?>
			<form action="step2.php" method="get">
				<input type="hidden" name="type" value="POSTGRADUATE" />
				<label for="enrollment">Enrollment Number:</label>
				<input type="text" name="enrollment" id="enrollment" autofocus="autofocus"/>
				<input type="submit"/>
				<input type="reset"/>
			</form>
		<?php 
	}
	else
	{
		?>
		<form action="step2.php" method="get">
			<input type="hidden" name="type" value="UNDERGRADUATE" />
			<label for="enrollment">Enrollment Number:</label>
			<input type="text" name="enrollment" id="enrollment" autofocus="autofocus"/>
			<input type="submit"/>
			<input type="reset"/>
		</form>
	<?php 
	}
}
if($_GET['type']=="POSTGRADUATE"){
	$title="Postgraduate";
	$type="POSTGRADUATE";
}
else
{
	$title="Undergraduate";
	$type="UNDERGRADUATE";
}
ThisPage::renderTop("Register");
?>
<h1>Register &rsaquo; <?php echo $title;?></h1>
<?php 
printerror();
printform($type);
ThisPage::renderBottom()?>
