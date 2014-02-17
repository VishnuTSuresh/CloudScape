<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
require_once "MessFood.php";
ThisPage::renderTop("Mess Food");
ThisPage::allowsCredentials(["LOGIN"]);
$user=ThisPage::getUser();
if(isset($_POST["add_food"])){
	$key=MessFood::getNewKey();
	$name=$_POST["name"];
	$comment=$_POST["comment"];
	$MessFood=new MessFood($user);
	$MessFood->add($key, $name, $comment);
}
?>
<style>
form{
	width:300px;
	margin:15px;
}
#food_container{
background: url('food.jpg') center center;background-size: 100%; padding:15px;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
}
#food_list_select .deleted{
	background: #FFC0CB;
}
</style>
<script type="text/javascript" src="/Resources/script/validate.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<h1>Mess &rsaquo; Food</h1>
<div id="food_container">
<form class="form" method="post" id="add_food" name="add_food">
	<div>Add Food Item</div>
	<input type="text" name="name" placeholder="name">
	<div>Comment:</div>
	<input type="text" name="comment" value="Adding new food">
	<div id="error_box"></div>
	<input type="submit" name="add_food">
</form>
<form class="form" method="get" action="Edit.php">
Edit Food:
	<select name="ref" id="food_list_select">
		<?php 
		$foodlist=MessFood::getFoodList();
		foreach($foodlist as $key=>$data){
			?><option value="<?php echo $key;?>" class="<?php if($data["state"]==-1)echo("deleted");?>"><?php echo $data["name"];?></option>
			<?php 
		}
		?>
	</select>
	<input type="submit" value="Edit">
</form>
</div>
<?php
ThisPage::renderBottom();
?>