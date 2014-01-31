<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$cmd=isset($_REQUEST["cmd"])?$_REQUEST["cmd"]:null;
if($cmd=="get-records"){
?>
{
	"status"	: "success",
	"records"	: [
	<?php 
	$total=0;
	$limit=isset($_REQUEST["limit"])?$_REQUEST["limit"]:100;
	$offset=isset($_REQUEST["offset"])?$_REQUEST["offset"]:0;
	$notice_board=new NoticeBoard();
	$notices=$notice_board->get($offset,$limit);
	foreach ($notices as $notice)
	{
		$total++;
		?>
		{
			recid:<?php echo $notice->getId()?>,
			uploader:"<?php echo $notice->getUser()->getFirstName()." ".$notice->getUser()->getLastName();?>",
			title:"<?php echo $notice->getTitle();?>",
			date:"<?php echo $notice->getPostDate() ?>",
		},
		<?php
	}
	?>
	],
	"total": <?php echo $total;?>,
}
<?php
}
?>