<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class NoticeBoard{
	private $user;
	public function NoticeBoard($user=null){
		if(is_subclass_of($user,"User")||get_class($user)=="User"){
			$this->user=$user;
		}
		else{
			$this->user=null;
		}
	}
	public function addNotice(Notice $notice){
		if($this->user){
			$title=$notice->getTitle();
			$content=$notice->getContent();
			$post_date=$notice->getPostDate();
			$user_id=$this->user->getUserId();
			MySQL::query("INSERT INTO noticeboard (title,content,post_date,user_id) VALUES (?,?,?,?)",[$title,$content,$post_date,$user_id]);
		}
	}
}