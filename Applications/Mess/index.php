<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
require_once "Mess.php";
ThisPage::renderTop("Mess");
ThisPage::addToAppTools([
"name"=>"Edit Time Table",
"credentials"=>["LOGIN"],
"url"=>"Edit.php"
]);
$key=Mess::keyFromDate($_GET["ts"]);
echo $key;
?><pre><?php

print_r(Mess::getData($key));
?>
</pre>
<?php 
ThisPage::renderBottom();
?>
