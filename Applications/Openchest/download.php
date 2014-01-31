<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once 'OpenChest.php';

$path=null;
if(isset($_GET["path"]))$path=$_GET["path"];
if($path){
	OpenChest::download($path);
}
?>