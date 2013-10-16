<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Mess Food");
ThisPage::allowsCredentials(["LOGIN"]);
$id=isset($_GET["id"])?$_GET["id"]:null;
$key=isset($_GET["ref"])?$_GET["ref"]:1;
$user=ThisPage::getUser();
if(isset($_POST["edit_food"])){
	$key=$_POST["key"];
	$new_food_name=$_POST["new_food_name"];
	$comment=$_POST["comment"];
	$MessFood=new MessFood($user);
	$MessFood->edit($key, $new_food_name, $comment);
}
if(isset($_POST["delete_food"])){
	$key=$_POST["key"];
	$comment=$_POST["comment"];
	echo $key,$comment;
	$MessFood=new MessFood($user);
	$MessFood->delete($key, $comment);
}
?>
<script type="text/javascript" src="/Resources/script/validate.min.js"></script>
<script>
$(function(){
var validator2= new FormValidator("edit_food",
			[{
				 name:"comment",
				 display:"Comment",
				 rules: 'required|min_length[10]'
			},
			{
				 name:"new_food_name",
				 display:"Name",
				 rules: 'required'
			},
			],
		function(errors,evt){
			if (errors.length > 0) {
		        var errorString = '';
		        
		        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
		            errorString += errors[i].message + '<br />';
		        }
		        
		        $("#error_box").addClass("error").html(errorString);
		        if (evt && evt.preventDefault) {
		            evt.preventDefault();
		        } else if (event) {
		            event.returnValue = false;
		        }
		    }  
			
		});
});
</script>
<h1>Mess &rsaquo; Food &rsaquo; Edit</h1>
<?php if($id){
	?><div class='warning'>This is an old name for this food. Current name may be different</div><?php 
}?>
<?php $name=MessFood::getData($key);
$oldname=null;
if(!$name){
?><div class='warning'>This food item has been deleted. You can either undo to previous state or give it a new name below.</div><?php
MessFood::renderHistory($key);
if($id)$oldname=MessFood::getDataById($id);
}
?>
<form method="post" name="edit_food">
Food #<?php echo $key;?> <br />
Name:
<input type="text" name="new_food_name" value="<?php echo $name,$oldname; ?>" placeholder="<?php echo $name?"":"Give a new name"?>">
Comment:
<input type="text" name="comment">
<div id="error_box"></div>
<input type="hidden" name="key" value="<?php echo $key;?>">
<input type="submit" name="edit_food" value="Update"><?php if($name){?><input type="submit" name="delete_food" value="Delete"><?php }?>
</form>
<?php 
if($name){
}
ThisPage::renderBottom();
?>