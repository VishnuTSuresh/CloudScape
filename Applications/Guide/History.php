<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once "Guide.php";
ThisPage::renderTop("Guide");
?>
<h1>Guide</h1>
<?php
$ref=$_GET["ref"];
?>
<h3>History &raquo; <?php echo implode(" &rsaquo; ",explode("/",$ref));?></h3>
<table border="1px">
  <tr>
    <th>Creation Date</th>
    <th>User</th>
    <th>Comment</th>
    <th>Branch Node</th>
  </tr>
<?php 
$history=Guide::history($ref,10);
$history_no=0;
while($row=$history->fetch_assoc()){
?>
  <tr>
    <td><a href="index.php?ref=<?php echo $ref;?>&h=<?php echo $history_no;?>"><?php echo $row["creation_time"]?></a></td>
    <td><?php $user=User::withUserId($row["user_id"]);
    echo $user->getFirstName()." ".$user->getLastName()?></td>
    <td><?php echo $row["comment"]?></td>
    <td><?php echo $row["branch_node"]?></td>
  </tr>
<?php 
	$history_no++;
}?>
</table>
<?php ThisPage::renderBottom()?>