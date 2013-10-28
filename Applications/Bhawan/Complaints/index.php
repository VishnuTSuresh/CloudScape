<?php 
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::allowsCredentials(array("LOGIN"));
ThisPage::renderTop("Bhawan");

//user details

$user=ThisPage::getUser();
$user_id=$user->getUserId();
$mysql=MySQL::getConnection();
?>
 <?php
   $sql="SELECT id,complaint,admin_status,student_status,final_status,time FROM bhawan_complaints WHERE user_id=$user_id AND student_status=0" ;
   $result= $mysql->query($sql);
 ?> 
      <form>
   	<table>
	    <?php
		while($row=$result->fetch_assoc())
		{
		?>
		<tr>
		<td>
		<?php echo($row["id"])?>
		</td>
		<td>
		<?php echo($row["complaint"])?>
		</td>
		<td>
		<?php echo($row["time"])?>
		</td>
		<td>
		<?php 
		if($row["admin_status"]==0)
		echo("unresolved");
		else
		echo("resolved");
		?>
		</td>
		<td>
		<?php 
		echo("unresolved");
		?>
		</td>
		<td>
		<?php 
		if($row["final_status"]==0)
		echo("unresolved");
		else
		echo("resolved");
		?>
		</td>
		<td>
		<input type="submit" class="submit button" name="student_status" value="resolved"/>
		</td>
		<?php		
	    }
		?>
		</table>
		
		complaint:
	   <textarea name="d"></textarea>
	   <input type="submit" class="submit button" name="add" value="add complaint">
	   </form>
	   
	    <?php
       //Insert Values
           if(isset($_REQUEST["add"])) 
           {
           $sql1="INSERT INTO bhawan_complaints VALUES($user_id,0,0,0,'$_REQUEST[d]',NOW())"; 
           $mysql->query($sql1);
           }
         ?>  
	  
      
<?php 
   

               
           ThisPage::renderBottom();
?>