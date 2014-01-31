<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
$request_id=isset($_REQUEST["rid"])?$_REQUEST["rid"]:null;
$notice_id=isset($_REQUEST["nid"])?$_REQUEST["nid"]:null;
if($request_id&&$notice_id){
	$noticeboard=new NoticeBoard();
	$notice=$noticeboard->get($notice_id);
	$return=["rid"=>$request_id,"content"=>$notice->getContent()];
	echo json_encode($return);
}
?>