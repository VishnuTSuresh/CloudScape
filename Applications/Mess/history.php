<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
require_once "Mess.php";
ThisPage::renderTop("Guide");
?>
<h1>Mess>>History</h1>
<?php
$page=$_GET["p"]?$_GET["p"]:1;
$key=Mess::keyFromDate($_GET["ts"]);
Mess::renderHistory($key,$page);
?>

<a href="History.php?ref=<?php echo $ref;?>&p=<?php echo ++$page;?>">more</a>
<?php ThisPage::renderBottom()?>
