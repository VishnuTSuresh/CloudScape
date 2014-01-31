<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class Notice{
	private $id,$title,$content,$post_date,$user;
	public function Notice($notice=["id"=>null,"title"=>null,"content"=>null,"postdate"=>null,"user"=>null]){
		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		$this->title = $purifier->purify($notice["title"]);
		$this->content=$purifier->purify($notice["content"]);
		$this->post_date=date("Y-m-d",$notice["post_date"]?strtotime($notice["post_date"]):time());
		$this->user=$notice["user"];
		$this->id=isset($notice["id"])?$notice["id"]:null;
	}
	public function getId(){
		return $this->id;
	}
	public function getTitle(){
		return $this->title;
	}
	public function getContent(){
		return $this->content;
	}
	public function getPostDate(){
		return $this->post_date;
	}
	public function getUser(){
		return $this->user;
	}
}
?>