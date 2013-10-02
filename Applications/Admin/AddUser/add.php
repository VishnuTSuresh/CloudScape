<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
if($_POST["type"]=="UNDERGRADUATE"){
	$username=bin2hex(openssl_random_pseudo_bytes(5));
	$password=bin2hex(openssl_random_pseudo_bytes(5));
	$enroll_no=$_POST["enroll_no"];
	$firstname=$_POST["firstname"];
	$lastname=$_POST["lastname"];
	$year_of_joining=$_POST["year_of_joining"];
	$programme_id=$_POST["programme_id"];
	if(Undergraduate::createNew($username, $password, $enroll_no, $firstname, $lastname, $year_of_joining, $programme_id)){
		echo "success";
	}
	else{
		echo "fail";
	}
}
elseif($_POST["type"]=="POSTGRADUATE"){
	$username=bin2hex(openssl_random_pseudo_bytes(5));
	$password=bin2hex(openssl_random_pseudo_bytes(5));
	$enroll_no=$_POST["enroll_no"];
	$firstname=$_POST["firstname"];
	$lastname=$_POST["lastname"];
	if(Postgraduate::createNew($username, $password, $enroll_no, $firstname, $lastname)){
		echo "success";
	}
	else{
		echo "fail";
	}
}
else{

}
?>
