<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
/*
 *
*@author Vamshedhar Reddy C
*Date Created: 01/09/13
*
*/
ThisPage::renderTop(Feedback);
function ref_clean($subject){
	$pattern = "/\.php$|index\.php$/";
	$replacements = "";
	return preg_replace($pattern, $replacement, $subject);
}
$ref_array = array_filter(array_map("ref_clean", preg_split('(\/|\\\\)',$_GET['ref'])));
$ref_string = implode(" &rsaquo; ", $ref_array);s
?>
<h1>Feedback</h1>
<h4>Feedback for  <?php  echo $ref_string;?></h4>
<form action="thankyou.php" method="post">
<table>
<tr><td>Type:
<select name="type">
	<option value="suggestion">Suggestion</option>
	<option value="bug">Bug / Complaint</option>
</select></td></tr>
<tr><td>Description:<textarea name="description" rows="6" cols="100" style="resize: none;" placeholder="Your Feedback goes here..."></textarea></td></tr>
<tr><td><input type="submit" value="Submit" name="submit"></td></tr>
</table>
</form>
<?php 
ThisPage::renderBottom();
?>