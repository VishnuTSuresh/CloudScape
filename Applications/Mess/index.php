<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Mess");
$key=Mess::keyFromDate(isset($_GET["ts"])?$_GET[ts]:null);
?>
<link rel="stylesheet" href="style.css" type="text/css"/>
<h1>Mess Time Table</h1>

<?php 
if(isset($_GET["id"])){
?>
<div class="error">This is an old revision of this timetable. It may differ significantly from the current revision.</div>
<?php
}
?>
<table class="table" id="mess_time_table">
<tr>
	<td></td>
	<td>Monday</td>
	<td>Tuesday</td>
	<td>Wednesday</td>
	<td>Thursday</td>
	<td>Friday</td>
	<td>Saturday</td>
	<td>Sunday</td>
</tr>
<?php
$timetable=isset($_GET["id"])?Mess::getDataById($_GET["id"]):Mess::getData($key);
foreach ($timetable as $period=>$meals)
{
	?><tr><td><?php echo $period;?></td><?php
	foreach ($meals as $meal=>$food_items)
	{
		?><td class="period"><div class="cell_container"><?php 
		foreach ($food_items as $food_item)
		{
			?>
			<div ><?php echo $food_item;?></div>
			<?php 
		}
		?></div></td><?php
	}
	?></tr><?php
}?>
</table>
<?php
ThisPage::renderBottom(
	["appTools"=>
				[
					["name"=>"Edit Time Table","credentials"=>["LOGIN"],"url"=>"Edit.php"],
					["name"=>"Edit Food Items","credentials"=>["LOGIN"],"url"=>"Food"],
					["name"=>"History","credentials"=>["PUBLIC"],"url"=>"\\UGCS\\History\\",
						"query"=>[
							"k"=>base64_encode($key),
							"c"=>base64_encode("Mess"),				
						]]
				]
	]
);
?>
