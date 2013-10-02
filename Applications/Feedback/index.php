<?php
/*
 *
*@author Vamshedhar Reddy C
*Date Created: 01/09/13
*
*/
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop(Feedback);
function ref_clean($subject){
	$pattern = "/\.php$|index\.php$/";
	$replacements = "";
	return preg_replace($pattern, $replacement, $subject);
}
$ref_array = array_filter(array_map("ref_clean", preg_split('(\/|\\\\)',$_GET['ref'])));
$ref_string = implode(" &rsaquo; ", $ref_array);s
?>
<script type="text/javascript">
$(document).ready(function(){
	var feedback=false;
	function checkall(){
		var submitbutton=$("#submitFeedback");
		if(feedback==true){
			submitbutton.prop('disabled',false);
		}
		else{
			submitbutton.prop('disabled',true);
		}
	}
	var description=$("#description");
	var count=$("#count");
	description.keyup(function(){

		var length = description.val().length;	
		if(length > 0){
			count.html(1000 - length);
			feedback = true;
		} else {
			count.html(1000);
			feedback = false;
		}
		checkall();
	});
});
</script>
<?php 
	if (isset($_GET['ref'])) {
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
		<tr>
			<td>
				Description:
				<textarea name="description" id="description" maxlenght="1000" rows="6" cols="100" style="resize: none;" placeholder="Your Feedback goes here..."></textarea>
				<input type="hidden" name="ref" value="<?php echo $_GET['ref']?>" />
			</td>
		</tr>
		<tr align="right"><td><div id="count" style="display: inline;">1000</div> characters left.</td></tr>
		<tr><td><input type="submit" value="Submit" name="submit" id="submitFeedback"  disabled=disabled></td></tr>
		</table>
		</form>
		<?php
	} else {
		header("Location: ../Home/");
	}
?>

<?php 
ThisPage::renderBottom();
?>
