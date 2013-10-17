<?php
/**
 * @author Vishnu T Suresh
 *
 */
class Console{
	/**
	 * @param unknown $message
	 */
	public static function log($message){
		$message=(string) $message;
		echo "<script type='text/javascript'>console.log('$message')</script>";
	}
}