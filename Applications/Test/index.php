<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

?>

<?php
$foodlist=[];
		MySQL::query("SELECT `key`, name,current FROM mess_food WHERE current=?",1, function($row) use (&$foodlist){
			$foodlist[$row["key"]]=["name"=>$row["name"],"state"=>$row["current"]];
			echo $row["name"]."<br />";
		});

?>
