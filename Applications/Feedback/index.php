<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop(Feedback);
$ref_array = array_filter(preg_split('(\/|\\\\)',$_GET['ref']));
$ref_string = implode(" &rsaquo; ", $ref_array);s
?>
<style type="text/css" rel="stylesheet">

</style>
<h1>Feedback</h1><h4>Feedback for  <?php  echo $ref_string;?></h4>
<form>
<table>
<tr><td>Type:<select><option>Suggestion</option><option>Bug / Complaint</option></select></td></tr>
<tr><td>Description:<textarea rows="4" cols="100" style="resize: none;"></textarea></td></tr>
<tr><td><input type="submit"></td></tr>
</table>
</form>
<?php 
ThisPage::renderBottom();
?>