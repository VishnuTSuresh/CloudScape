<?php
class Console{
	public static function log($message){
		$message=(string) $message;
		echo "<script type='text/javascript'>console.log('$message')</script>";
	}
}