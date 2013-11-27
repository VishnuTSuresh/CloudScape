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
			$user_id=$notice->getUser()->getUserId();
			MySQL::query("INSERT INTO noticeboard (title,content,post_date,user_id) VALUES (?,?,?,?)",[$title,$content,$post_date,$user_id]);
		}
	}
	public function get(){
		$result=[];
		if(func_num_args()==1){
			$id=intval(func_get_arg(0));
			MySQL::query("SELECT title,content,post_date,user_id FROM noticeboard WHERE id=?", $id,
				function($row) use (&$result,$id){
					$result=new Notice(["id"=>$id, "title"=>$row["title"], "content"=>$row["content"], "post_date"=>$row["post_date"], "user"=>User::withUserId($row["user_id"])]);
				}
			);
		}
		else{
			$offset=func_get_arg(0);
			$limit=func_get_arg(1);
			MySQL::query(
				"SELECT id,title,content,post_date,user_id FROM noticeboard WHERE post_date <= NOW()  ORDER BY id DESC LIMIT ?,?",
				[$offset,$limit],
				function($row) use (&$result){
					$result[]=new Notice(["id"=>$row["id"], "title"=>$row["title"], "content"=>$row["content"], "post_date"=>$row["post_date"], "user"=>User::withUserId($row["user_id"])]);
				}
			);
		}
		return $result;
	}
}