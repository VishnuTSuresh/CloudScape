<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop ( "People" );
$users = People::get ( 1, 100 );

?>
<h1>People</h1>
<div>
<?php
foreach ( $users as $user ) {
	?>
<a href="Profile?user_id=<?php echo $user->getUserId();?>" class="button" style="width: 200px; height: 30px; margin:10px;">
<?php
	echo $user->getFirstName ()." ".$user->getLastName();
	?>
</a>	
<?php
}
?>
</div>
<?php
ThisPage::renderBottom ();
?>