<?php
/*
 *
*@author Vamshedhar Reddy C
*Date Created: 01/09/13
*
*/
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Feedback");
function ref_clean($subject){
	$pattern = "/\.php$|index\.php$/";
	$replacements = "";
	return preg_replace($pattern, $replacement, $subject);
}
$ref_array = array_filter(array_map("ref_clean", preg_split('(\/|\\\\)',$_GET['ref'])));
$ref_string = implode(" &rsaquo; ", $ref_array);
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
	$user=ThisPage::getUser();
	if ($user != NULL){
		$admin = $user->hasCredential(["ADMIN"]);
	} else {
		$admin = FALSE;
	}
	if ($admin) {
		if (isset($_POST['Review'])) {
			$mysql=MySQL::getConnection();
			$feedbackID = $_POST['feedbackID'];
			if ($mysql->query("UPDATE feedback SET review=1 WHERE feedback_id=$feedbackID")) {
				?>
					<div id="thankyou" class="success">Feeback updated as Reviewed.</div>
					<?php 
				} else {
					echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
		}
		?>
<style rel="stylesheet">
table
{
	border-collapse: collapse;text-align: left;
}
th
{
	font-size: 14px;
	font-weight: bold;
	color: #777;
	padding: 10px 8px;
	border-bottom: 2px solid #777;
}
td
{
	border-bottom: 1px solid #D3D3D3;
	padding: 6px 8px;
}
tbody tr:hover td
{
	color: #000;
}

</style>
		<h1>Feedbacks List</h1>
		<div class="form">
		<table width="100%">
		<tr><th>ID</th><th>Reference</th><th>Type</th><th>Description</th><th>User</th><th width="40px"></th></tr>
		<tbody>
		<?php 
		$mysql=MySQL::getConnection();
		$result = $mysql->query("SELECT * FROM feedback WHERE review=0");
		while ($row = $result->fetch_array()) {
			?>
			<form action="" method="post">
			<tr>
				<td><?php echo $row[0];?></td>
				<td><?php echo $row[1];?></td>
				<td><?php echo $row[2];?></td>
				<td><?php echo $row[3];?></td>
				<td>
				<?php
				if ($row[4] != 0) {
					$user=User::withUserId($row[4]);
					echo $user->getFirstName()." ".$user->getLastName()."<br>(".$user->getEnrollmentNumber().")";
				} else {
					echo "Offline";
				}
				?>
				</td>
				<td>
					<input type="hidden" name="feedbackID" value="<?php echo $row[0];?>" >
					<input type="submit" value="Reviewed" name="Review">
				</td>
			</tr>
			</form>
			<?php 
		}
		?>
		</tbody>
		</table>
		</div>
		<?php 
	} else {

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
					<textarea name="description" id="description" maxlength="1000" rows="6" cols="100" style="resize: none;" placeholder="Your Feedback goes here..."></textarea>
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
	}
?>

<?php 
ThisPage::renderBottom();
?>
