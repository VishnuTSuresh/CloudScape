<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Mess");
$ts=isset($_GET["ts"])?$_GET['ts']:date("d-M-Y");
$key=Mess::keyFromDate($ts);
?>
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="stylesheet" href="/Resources/jquery-ui-1.10.3.custom.css" type="text/css"/>
<script type="text/javascript" src="/Resources/script/jquery-ui.min.js"></script>
<script>
$(function(){
	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	$("#mess_calendar").datepicker({ 
		firstDay: 1,
		changeMonth: true,
		changeYear: true,
		onSelect: function(dateText, inst) { 
			window.location = "?ts="+dateText;
		},
		dateFormat: "d-M-yy",
		defaultDate: getParameterByName("ts"),
	})
});
</script>
<h1>Mess Time Table</h1>
<div id="mess_calender_container">
<div class="form" id="mess_calendar"></div>
</div>
<?php 
if(isset($_GET["id"])){
?>
<div class="error">This is an old revision of this timetable. It may differ significantly from the current revision.</div>

<?php
}
$food_list=MessFood::getFoodList();

$timetable=isset($_GET["id"])?Mess::getDataById($_GET["id"]):Mess::getData($key);
if($timetable){
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

$day=strtoupper(date("l",strtotime($ts)));
	foreach ($timetable as $period=>$meals)
	{
		?><tr><td><?php echo $period;?></td><?php
		foreach ($meals as $meal=>$food_items)
		{
			?><td class="period index <?php if($meal==$day){echo "today";}?>"><div class="cell_container"><?php
			foreach ($food_items as $food_item)
			{
				?>
				<div ><?php echo $food_list[$food_item]["name"];?></div>
				<?php 
			}
			?></div></td><?php
		}
		?></tr><?php
	}
?>
</table>
<?php
}
else{
?>
<div class="warning">Time Table for this week has not been uploaded yet. You can do it by clicking Edit Time Table in the Appilcation bar (You must be logged in).</div>
<?php
}
ThisPage::renderBottom(
	["appTools"=>
				[
					["name"=>"Edit Time Table","credentials"=>["LOGIN"],"url"=>"Edit.php","query"=>["ts"=>date("d-M-Y",strtotime($key))]],
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
