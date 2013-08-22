<?php 
/*
 *@author Rajas Shah
 *@author Vishnu T Suresh
 */

/*
 * ERROR CODES:
 * 1) User with enrollment number not found
 * 2) User already registered
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
$enroll_no=intval($_GET['enrollment']);
if ($enroll_no!=0) 
{
	if($_GET["type"]=="POSTGRADUATE"){
		ThisPage::renderTop("PG Registration");
		$user = Postgraduate::withEnrollment($enroll_no);
		if(!$user)
		{
			header("Location: step1.php?errorcode=1&type=ug");
		}
		elseif ($user->hasCredential(["REGISTERED"])){
			header("Location: step1.php?errorcode=2&type=ug");
		}
		else{
			?>
					<h1>Registration > Postgraduate > <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
					<h2>
					Welcome <?php echo $user->getFirstName()." ".$user->getLastName();?>
					</h2>
					<p>
					Please enter the desired username and password.
					</p>
					<form action="step3.php?user_id=<?php echo $user->getUserId()?>" method=POST>
						<label for="username">Username:</label><input type="text" name="username" id="username" />
						<label for="password">Password:</label><input type="password" name="password" id="password" />
						<label for="confirm_pasword">Confirm Password:</label><input type="password" name="confirm_password" id="confirm_password" />
						<input type="submit" />
					</form>
				<?php
	}
	else
	{
		ThisPage::renderTop("UG Registration");
		$user = Undergraduate::withEnrollment($enroll_no);
		if(!$user)
		{
			header("Location: step1.php?errorcode=1&type=ug");
		}
		elseif ($user->hasCredential(["REGISTERED"])){
			header("Location: step1.php?errorcode=2&type=ug");
		}
		else{
		?>
			<h1>Registration > Undergraduate > <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
			<h2>
			Welcome <?php echo $user->getFirstName()." ".$user->getLastName();?>
			</h2>
			<p>
			Please enter the desired username and password.
			</p>
			<form action="step3.php?user_id=<?php echo $user->getUserId()?>" method=POST>
				<label for="username">Username:</label><input type="text" name="username" id="username" />
				<label for="password">Password:</label><input type="password" name="password" id="password" />
				<label for="confirm_pasword">Confirm Password:</label><input type="password" name="confirm_password" id="confirm_password" />
				<input type="submit" />
			</form>
		<?php
	 
			
		}
	}
} 
else
{
	header("Location: step1.php?errorcode=1");
}
ThisPage::renderBottom();
?>