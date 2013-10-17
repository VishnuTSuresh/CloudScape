<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$class=base64_decode($_GET["c"]);
ThisPage::renderTop("$class History");
?>
<h1><?php echo $class?>&rsaquo;History</h1>
<?php
$page=isset($_GET["p"])?$_GET["p"]:1;
$key=base64_decode($_GET["k"]);
$class::renderHistory($key,$page);
?>

<a href="?k=<?php echo $_GET["k"];?>&p=<?php echo ++$page;?>&c=<?php echo $_GET["c"]?>">more</a>
<?php ThisPage::renderBottom()?>