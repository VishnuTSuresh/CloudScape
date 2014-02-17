<?php
/**
* @author Vishnu T Suresh
*/
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop ( "Profile" );
$user_id=isset($_GET["user_id"])?$_GET["user_id"]:null;
if($user_id){
	$user=User::withUserId($user_id);
	if(ThisPage::getUser()&&(ThisPage::getUser()->getUserId()==$user_id)){
		?>
		<h1><?php echo "My "?>Profile</h1>
		<?php
	}
	else{
		?>
		<h1><a href="..">People</a> &rsaquo; <?php echo $user->getFirstName()." ".$user->getLastName()?></h1>
		<?php
	} 
	?>
	<style>
	<!--
	#profilecontainer{
		float:left;
		width:250px;
		background: #404040;
		padding:5px;
		color:#fff;
		margin:10px;
		-webkit-box-shadow: 0px 0px 10px 3px rgba(50, 50, 50, 0.5);
		-moz-box-shadow: 	0px 0px 10px 3px rgba(50, 50, 50, 0.5);
		box-shadow: 		0px 0px 10px 3px rgba(50, 50, 50, 0.5);
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
	}
	#profilecontainer b{
		font-weight: 600;
		
	}
	#profilepic{
		width:100%;
		height:240px;
		background-color: gray;
		background-image: url("Profile Pictures/default_male.jpg");
		background-position: center;
		background-repeat: no-repeat;
		background-attachment: scroll;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		-webkit-box-shadow: inset 0px 0px 10px 1px rgba(50, 50, 50, 0.5);
		-moz-box-shadow: 	inset 0px 0px 10px 1px rgba(50, 50, 50, 0.5);
		box-shadow: 		inset 0px 0px 10px 1px rgba(50, 50, 50, 0.5);
	}
	#profilecover{
		width:100%;
		height: 500px;
  		background-image: url("Profile Pictures/default_cover.jpg");
		background-position: center;
		background-repeat: no-repeat;
		background-attachment: scroll;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
	}
	.profilelegend{
		color:#888;
		font-style: italic;
		margin-top: 5px;
	}
	 .profilecomponent{
	 padding:5px;
	 	margin-top:5px;
	 	border-bottom:thin;
	 	border-bottom-style:dashed;
	 	border-bottom-color: #888;
	 }
	-->
	</style>
	<div id="profilecover">
	<div id="profilecontainer">
		<div id="profilepic"></div>
		<div class="profilecomponent"><span class="profilelegend">First Name:</span> <b><?php echo $user->getFirstName() ?></b></div>
		<div class="profilecomponent"><span class="profilelegend">Last Name:</span> <b><?php echo $user->getLastName() ?></b></div>
		<div class="profilecomponent"><span class="profilelegend">Enrollment Number:</span> <b><?php echo $user->getEnrollmentNumber() ?></b></div>
	</div>
	</div>
	<?php
}
ThisPage::renderBottom ();
?>