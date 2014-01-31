// <?php
// /*
//  * @author Vamshedhar Reddy
//  * @author Abhas Mittal
//  */
// require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
// ThisPage::renderTop("OpenChest");
// ?>
<!-- <style rel="stylesheet"> -->
/* table */
/* { */
/* 	border-collapse: collapse;text-align: left; */

/* } */
/* th */
/* { */
/* 	font-size: 20px; */
/* 	font-weight:normal; */
/* 	color: #777; */
/* 	padding: 10px 10px; */
/* 	border-bottom: 2px solid #777;  */
/* } */
/* td */
/* { */
/* 	vertical-align: top; */
/* 	font-size: 18px; */
/* 	padding: 8px; */
/* } */
/* td p */
/* { */
/* 	font-size: 14px; */
/* 	padding: 10px; */
/* 	margin-left: 30px; */
/* 	display: none; */
/* } */
/* #details:hover */
/* { */
/* 	cursor: pointer; */
/* } */
/* table .odd */
/* { */
/* 	background: #F5F5F5;  */
/* } */
/* .ui-tooltip { */
/* 	background: #FFF; */
/* 	padding: 5px; */
/* 	position: absolute; */
/* 	z-index: 9999; */
/* 	max-width: 300px; */
/* 	-webkit-box-shadow: 0 0 5px #aaa; */
/* 	box-shadow: 0 0 5px #aaa; */
/* 	border-radius: 3px; */
/* 	-webkit-border-radius: 3px; */
/* } */
<!-- </style> -->
<!-- <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />--> -->
<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
<!-- <script type="text/javascript"> -->
// <!--
// $(document).ready(function(){
// 	$(document).tooltip();
// 	$("img#details").click(function(){
// 		var id =  this.getAttribute("value");
// 		$("p:not(p#"+id+")").slideUp();	
// 		$("p#"+id).slideToggle();
// 	});
// });
// //-->
<!-- </script> -->
// <?php 
// function creatFolder(){
// ?>
<!-- 	<br /> -->
	<form action="?ref=<?php echo $_GET['ref']; ?>" autocomplete="off" method="post" enctype="multipart/form-data">
<!-- 	<fieldset><legend>Create Folder</legend> -->
<!-- 	<label for="folder">Folder Name: </label><input type="text" placeholder="Enter your folder name here..." name="folder" /> -->
<!-- 	<input type="submit" name="folderSubmit" value="Create Folder" /> -->
<!-- 	</fieldset> -->
<!-- 	</form> -->
// <?php 
// }
// function uploadFile(){
// ?>
<!-- 	<br /> -->
	<form action="?ref=<?php echo $_GET['ref']; ?>" autocomplete="off" method="post" enctype="multipart/form-data">
<!-- 	<fieldset><legend>Upload File</legend> -->
<!-- 	Filename: <input type="file" name="file" id="file" /> -->
	<input type="hidden" name="path" value="<?php echo $_GET['ref']; ?>" />
<!-- 	<input type="submit" name="fileSubmit" value="Upload File" /> -->
<!-- 	</fieldset> -->
<!-- 	</form> -->
// <?php }?>
<!-- <h1>Openchest</h1> -->
<!-- <div class="form"> -->
<!-- <table width="100%"> -->
<!-- 	 <tr> -->
<!-- 		<th> -->
<!-- 		Openchest &rsaquo; PEM &rsaquo; IV Year &rsaquo; ERP -->
<!-- 		</th> -->
<!-- 		<th width="20px;"></th> -->
<!-- 		<th width="20px;"></th> -->
<!-- 		<th width="20px;"></th> -->
<!-- 		<th width="20px;"></th> -->
<!-- 	</tr> -->
<!-- 	<tbody> -->
<!-- 	<tr class="odd"> -->
<!-- 		<td> -->
<!-- 			Pulp and Paper Technology -->
<!-- 			<p id="1"> -->
<!-- 				<strong>Description: </strong>Saharanpur Campus, formerly known as the School of Paper Technology was established by the Government of India in 1964,  -->
<!-- 				with an aid from the Royal Swedish Government. This School was managed by a Society created by U.P. Government until its  -->
<!-- 				merger with the then University of Roorkee in 1978. Saharanpur Campus is well planned and developing Campus acquiring 25  -->
<!-- 				acres of land with the distance of around 50 kms from the Roorkee campus. -->
<!-- 			</p> -->
<!-- 		</td> -->
<!-- 		<td><img id="details" value="1" title="Details" alt="Details" src="images/details.png" width="20px"></td> -->
<!-- 		<td><img title="Edit" alt="Edit" src="images/edit.png" width="20px"></td> -->
<!-- 		<td><img title="Download" alt="Download" src="images/download.png" width="20px"></td> -->
<!-- 		<td><img title="Delete" alt="Delete" src="images/delete.png" width="20px"></td> -->
<!-- 	</tr> -->
<!-- 	<tr> -->
<!-- 		<td> -->
<!-- 			Polymer Science and Technology -->
<!-- 			<p id="2"> -->
<!-- 				Saharanpur Campus, formerly known as the School of Paper Technology was established by the Government of India in 1964,  -->
<!-- 				with an aid from the Royal Swedish Government. This School was managed by a Society created by U.P. Government until its  -->
<!-- 				merger with the then University of Roorkee in 1978. Saharanpur Campus is well planned and developing Campus acquiring 25  -->
<!-- 				acres of land with the distance of around 50 kms from the Roorkee campus. -->
<!-- 			</p> -->
<!-- 		</td> -->
<!-- 		<td><img id="details" value="2" alt="Details" src="images/details.png" width="20px"></td> -->
<!-- 		<td><img alt="Edit" src="images/edit.png" width="20px"></td> -->
<!-- 		<td><img alt="Download" src="images/download.png" width="20px"></td> -->
<!-- 		<td><img  alt="Delete" src="images/delete.png" width="20px"></td> -->
<!-- 	</tr> -->
<!-- 	<tr class="odd"> -->
<!-- 		<td> -->
<!-- 			Process Engineering With MBA -->
<!-- 			<p id="3"> -->
<!-- 				Saharanpur Campus, formerly known as the School of Paper Technology was established by the Government of India in 1964,  -->
<!-- 				with an aid from the Royal Swedish Government. This School was managed by a Society created by U.P. Government until its  -->
<!-- 				merger with the then University of Roorkee in 1978. Saharanpur Campus is well planned and developing Campus acquiring 25  -->
<!-- 				acres of land with the distance of around 50 kms from the Roorkee campus. -->
<!-- 			</p> -->
<!-- 		</td> -->
<!-- 		<td><img id="details" value="3" alt="Details" src="images/details.png" width="20px"></td> -->
<!-- 		<td><img alt="Edit" src="images/edit.png" width="20px"></td> -->
<!-- 		<td><img alt="Download" src="images/download.png" width="20px"></td> -->
<!-- 		<td><img  alt="Delete" src="images/delete.png" width="20px"></td> -->
<!-- 	</tr> -->
<!-- 	<tr> -->
<!-- 		<td> -->
<!-- 			Others -->
<!-- 			<p id="4"> -->
<!-- 				Saharanpur Campus, formerly known as the School of Paper Technology was established by the Government of India in 1964,  -->
<!-- 				with an aid from the Royal Swedish Government. This School was managed by a Society created by U.P. Government until its  -->
<!-- 				merger with the then University of Roorkee in 1978. Saharanpur Campus is well planned and developing Campus acquiring 25  -->
<!-- 				acres of land with the distance of around 50 kms from the Roorkee campus. -->
<!-- 			</p> -->
<!-- 		</td> -->
<!-- 		<td><img id="details" value="4" alt="Details" src="images/details.png" width="20px"></td> -->
<!-- 		<td><img alt="Edit" src="images/edit.png" width="20px"></td> -->
<!-- 		<td><img alt="Download" src="images/download.png" width="20px"></td> -->
<!-- 		<td><img  alt="Delete" src="images/delete.png" width="20px"></td> -->
<!-- 	</tr> -->
<!-- 	<tr class="odd"> -->
<!-- 		<td> -->
<!-- 			Recycle Bin -->
<!-- 			<p id="5"> -->
<!-- 				Saharanpur Campus, formerly known as the School of Paper Technology was established by the Government of India in 1964,  -->
<!-- 				with an aid from the Royal Swedish Government. This School was managed by a Society created by U.P. Government until its  -->
<!-- 				merger with the then University of Roorkee in 1978. Saharanpur Campus is well planned and developing Campus acquiring 25  -->
<!-- 				acres of land with the distance of around 50 kms from the Roorkee campus. -->
<!-- 			</p> -->
<!-- 		</td> -->
<!-- 		<td><img id="details" value="5" alt="Details" src="images/details.png" width="20px"></td> -->
<!-- 		<td><img alt="Edit" src="images/edit.png" width="20px"></td> -->
<!-- 		<td><img alt="Download" src="images/download.png" width="20px"></td> -->
<!-- 		<td><img  alt="Delete" src="images/delete.png" width="20px"></td> -->
<!-- 	</tr> -->
<!-- 	</tbody> -->
<!-- </table> -->
<!-- </div> -->
// <?php
// uploadFile();
// creatFolder();
// ThisPage::renderBottom();
// ?>
