<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop(Feedback);
?>
<h1>Feedback</h1>

<?php echo $_GET["ref"];?>
<?php 
ThisPage::renderBottom();
?>