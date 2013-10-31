<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class Notice{
	private $title,$content,$post_date;
	public function Notice($title,$content,$post_date=null){
		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		$this->title = $purifier->purify($title);
		$this->content=$purifier->purify($content);
		$this->post_date=date("Y-m-d",$post_date?strtotime($post_date):time());
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
}
?>