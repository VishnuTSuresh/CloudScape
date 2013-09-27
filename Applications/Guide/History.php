<?php
require_once "$_SERVER[DOCUMENT_ROOT]/PHP_Code/__autoload.php";
require_once "Guide.php";
ThisPage::renderTop("Guide");
?>
<h1>Guide</h1>
<?php
$ref=$_GET["ref"];
$page=$_GET["p"]?$_GET["p"]:1;
$curr_user=ThisPage::getUser();
?>
<h3>History &raquo; <?php echo implode(" &rsaquo; ",explode("/",$ref));?></h3>
<table class="table" style="width: 100%;">
  <tr>
  	<th>Id</th>
    <th>Creation Date</th>
    <th>User</th>
    <th>Comment</th>
    <th>Branch Node</th>
    <?php if($curr_user){?><th>Undo</th><?php }?>
    <th>Action</th>
    
  </tr>
<?php 
$history=Guide::history($ref,10*$page);
$first_loop=true;
while($row=$history->fetch_assoc()){
?>
  <tr>
  	<td><a href="index.php?ref=<?php echo $ref;?><?php echo $first_loop?"":"&id=".$row["id"];?>"><?php echo $row["id"]?></a></td>
    <td><?php echo $row["creation_time"]?></a></td>
    <td><?php 
    $user=User::withUserId($row["user_id"]);
    if(!($row["action"]=="UNDO")){
    	echo $user->getFirstName()." ".$user->getLastName();
    }
    else{
    	$meta=Guide::getMetaById($row["branch_node"]);
    	$orig_author=User::withUserId($meta["user_id"]);
    	echo $user->getFirstName()." ".$user->getLastName()." (undo)<br />
    		".$orig_author->getFirstName()." ".$orig_author->getLastName()." (original)";
    	
    }?></td>
    <td><?php echo $row["comment"]?></td>
    <td><?php echo $row["branch_node"]?></td>
    <?php if($curr_user){?><td style="text-align: center;"><?php 
    if(!$first_loop){
    	?><a style="font-size: 1.5em;" href='undo.php?id=<?php echo $row["id"] ?>'>&#9100;</a>
  <?php }?>
  	</td><?php }?>
  	<td><?php echo $row["action"]?></td>
  </tr>
<?php
$first_loop=false;
}?>
</table>
<a href="History.php?ref=<?php echo $ref;?>&p=<?php echo ++$page;?>">more</a>
<?php ThisPage::renderBottom()?>