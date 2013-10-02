<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
require_once "Guide.php";
ThisPage::renderTop("Guide");
?>
<h1><a style="font:inherit;color:inherit;" href="/Guide">Guide</a></h1>
<?php
$ref=$_GET["ref"];
$id=$_GET["id"];
if($id){
	$meta=Guide::getMetaById($id);
	$ref=$meta["key"];
	
}
if($ref){
	function guide_callback($subject){
		$pattern="/\.php$|index\.php$/";
		$replacement="";
		return preg_replace($pattern, $replacement, $subject);
	}
	$key_arr=array_filter(array_map("guide_callback", preg_split("(\/|\\\\)", $ref)));
	$key=implode("/",$key_arr);
	$key_disp=implode("&rsaquo;",$key_arr);
	$user=ThisPage::getUser();
	?><h3>Guide for <?php echo $key_disp;?></h3><?php 
	
	$Guide=new Guide($user);
	if($id){
		?>
		<div class="error">This is an old revision of this page. It may differ significantly from the current revision. </div>
		<?php 
	}
	if($id){
		$data=Guide::getDataById($id);
	}
	else{
		$data=Guide::getData($key);
	}
	if($data){
if(!$history){
		if($user){?>
			<a href=edit.php?ref=<?php echo $key;?>>Edit</a><?php 
		}
		?>
		<a href=history.php?ref=<?php echo $key;?>>History</a><hr />
		<?php 
		}
		echo $data;
	}
	else{
		?><hr /><p>This guide is empty.<?php
		if($user){
			?><a href=edit.php?ref=<?php echo $key;?>> Click here</a> to add content to this page. Remember that everyone can see who made the edit.</p><?php 
		}
		else{
			?> Please login to edit this page.<?php
		}
	}
	?>
	
	<?php 
}
else{

}
ThisPage::renderBottom();
?>
