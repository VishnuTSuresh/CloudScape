<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("People");
?>
<h1>People</h1>
<div>
<div class="button" style="width: 200px; height: 100px;">
<?php 
$user=People::get(1);
echo $user[0]->getFirstName();
?>
</div>	
</div>
<?php 
ThisPage::renderBottom();
?>