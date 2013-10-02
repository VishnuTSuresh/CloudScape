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
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$enroll_no=intval($_GET['enrollment']);
ThisPage::renderTop("Register");
$user=null;
if ($enroll_no!=0) 
{
	if($_GET["type"]=="POSTGRADUATE"){
		$user = Postgraduate::withEnrollment($enroll_no);
		if(!$user)
		{
			header("Location: step1.php?errorcode=1&type=pg");
		}
		elseif ($user->hasCredential(["REGISTERED"])){
			header("Location: step1.php?errorcode=2&type=pg");
		}
		else{
			?>
					<h1>Register &rsaquo; Postgraduate &rsaquo; <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
				<?php
		}
	}
	else
	{
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
			<h1>Register &rsaquo; Undergraduate &rsaquo; <?php echo $user->getFirstName()." ".$user->getLastName();?></h1>
		<?php
	 
			
		}
	}
} 
else
{
	header("Location: step1.php?errorcode=1");
}
?>
<script type="text/javascript">
$(document).ready(function(){
	var available=false;
	var passwordsmatch=true;
	function checkall(){
		var submitbutton=$("#step2submit");
		if(available==true&&passwordsmatch==true){
			submitbutton.prop('disabled',false);
		}
		else{
			submitbutton.prop('disabled',true);
		}
	}
	var username=$("#username");
	username.change(function(){
		var value=username.val(),infodiv=$("#usernameavailable");
		infodiv.removeClass();
		infodiv.addClass("plain");
		infodiv.html("<img src='/Resources/images/ajax-loader.gif' >");
		if(value.length>0){
			$.get("checkusername.php?username="+value,function(data){
				infodiv.html("");
				if(data==1)
				{
					available=true;
					infodiv.removeClass().addClass("success").html("Username is available");
				}
				else{
					available=false;
					infodiv.removeClass().addClass("error").html("Username is not available. Please chose a different username");
				}
				checkall();
			});
		}
		else{
			infodiv.removeClass();
			infodiv.addClass("error");
			infodiv.html("Username can't be blank. Please enter a username that is atleast one character long");
			checkall();
		}
	});
	$("#password, #confirm_password").keyup(function(){
		var passval=$("#password").val();
		var confval=$("#confirm_password").val();
		var passmatch=$("#passmatch");
		if(passval==confval){
				if(passval == ""){
					passwordsmatch=false;
					passmatch.removeClass().addClass("error").html("Passwords can't be empty.");
				} else {
					passwordsmatch=true;
					passmatch.removeClass().addClass("success").html("Passwords match");
				}
			
		}
		else{
			passwordsmatch=false;
			passmatch.removeClass().addClass("error").html("Passwords don't match");
		}
		checkall();
	});
});
</script>
<h2>
Welcome <?php echo $user->getFirstName()." ".$user->getLastName();?>
</h2>
<p>
Please enter the desired username and password.
</p>
<form action="step3.php?user_id=<?php echo $user->getUserId()?>" method="POST"  autocomplete="off">
	<label for="username">Username:</label><input type="text" name="username" id="username"/>
	<div id="usernameavailable"></div>
	<label for="password">Password:</label><input type="password" name="password" id="password" />
	<label for="confirm_pasword">Confirm Password:</label><input type="password" name="confirm_password" id="confirm_password" />
	<div id="passmatch"></div>
	<input type="submit" id="step2submit" disabled=disabled/>
</form>
<?php
ThisPage::renderBottom();
?>
