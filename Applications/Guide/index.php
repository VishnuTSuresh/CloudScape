<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
ThisPage::renderTop("Guide");
?>
<h1><a style="font:inherit;color:inherit;" href="/Guide">Guide</a></h1>
<?php
$ref=$_GET["ref"];
if($ref){
	function guide_callback($subject){
		$pattern="/\.php$/";
		$replacement="";
		return preg_replace($pattern, $replacement, $subject);
	}
	$key_arr=array_map("guide_callback", array_filter(preg_split("(\/|\\\\)", $ref)));
	$key=implode("|",$key_arr);
	$key_disp=implode("&rsaquo;",$key_arr);
	$user=ThisPage::getUser();
	?>
	<h3>Guide for <?php echo $key_disp;?></h3>
	<?php 
}
else{

}
ThisPage::renderBottom();
?>