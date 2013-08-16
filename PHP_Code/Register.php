<?php
/*
 * Author: Rajas Shah
 */
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
class Register
{
	private $userId, $fname, $lname;
	public function __construct($userId)
	{
		$this->userId = $userId;	
	}
	function checkEnum(){
		/*
		 * 1. Connect to database
		 * 2. Check if entered Enrollement/Employee number is available in master database according to the user type
		 * 3. If valid return positive else error
		 * 		 
		*/
		
	}
}
?>