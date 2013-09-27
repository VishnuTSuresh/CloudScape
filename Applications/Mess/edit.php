<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once 'Mess.php';
ThisPage::renderTop("Mess &raquo; Edit");
ThisPage::allowsCredentials(["LOGIN"]);
?>
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="stylesheet" href="/Resources/jquery-ui-1.10.3.custom.css" type="text/css"/>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript" src="/Resources/script/jquery-ui.min.js"></script>

<script type="text/javascript">
var Mess=Mess||{};
Mess.FoodList={
<?php 
	$food_list=Mess::getFoodList();
	while($food_item=$food_list->fetch_assoc()){
		echo($food_item["id"]);?>:{
	id:<?php echo($food_item["id"]);?>,
	name:"<?php echo($food_item["name"]);?>"
},
<?php
	}
?>
};
</script>
<h1>Mess &raquo; Edit Time Table</h1>
<?php 
$food_list=Mess::getFoodList();
?>
<form id="food_list_app">
<input type="text" placeholder="Search Food" id="food_search">
<ul id="food_list">
</ul>
<div  style="text-align:center"><span id="esctox" class=button>close</span></div>
</form>
<div class="form" id="mess_calendar"></div>
<div style="clear: both;"></div>
<table class="table">
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
<tr id="Breakfast">
	<td>Breakfast</td>
	<td class="period Monday"><div class="cell_container"></div></td>
	<td class="period Tuesday"><div class="cell_container"></div></td>
	<td class="period Wednesday"><div class="cell_container"></div></td>
	<td class="period Thursday"><div class="cell_container"></div></td>
	<td class="period Friday"><div class="cell_container"></div></td>
	<td class="period Saturday"><div class="cell_container"></div></td>
	<td class="period Sunday"><div class="cell_container"></div></td>
</tr>
<tr id="Lunch">
	<td>Lunch</td>
	<td class="period Monday"><div class="cell_container"></div></td>
	<td class="period Tuesday"><div class="cell_container"></div></td>
	<td class="period Wednesday"><div class="cell_container"></div></td>
	<td class="period Thursday"><div class="cell_container"></div></td>
	<td class="period Friday"><div class="cell_container"></div></td>
	<td class="period Saturday"><div class="cell_container"></div></td>
	<td class="period Sunday"><div class="cell_container"></div></td>
</tr>
<tr id="Dinner">
	<td>Dinner</td>
	<td class="period Monday"><div class="cell_container"></div></td>
	<td class="period Tuesday"><div class="cell_container"></div></td>
	<td class="period Wednesday"><div class="cell_container"></div></td>
	<td class="period Thursday"><div class="cell_container"></div></td>
	<td class="period Friday"><div class="cell_container"></div></td>
	<td class="period Saturday"><div class="cell_container"></div></td>
	<td class="period Sunday"><div class="cell_container"></div></td>
</tr>
</table>
<?php 
ThisPage::renderBottom();
?>