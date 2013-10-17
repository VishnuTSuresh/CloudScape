<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
/**
 * 
 * @author Vishnu T Suresh
 *
 */
class ThisPage{
	/*
	 * When this function is encountered php checks if the user of this page has any of the credentials that are passed as parameter. If he doesnt have even one of the credentials, he is redirected to login page.
	 * 
	 * @param	array	$credentials	An array of all the credentials that are allowed access to this page.
	 */
	public static function allowsCredentials($credentials){
		$user=ThisPage::getUser();
		if($user){
			if(!($user->hasCredential($credentials))){
				header("Location:/Authentication/Login");
			}
		}
		else{
			header("Location:/Authentication/Login");
		}
	}
	public static function getUser(){
		$token_no=isset($_COOKIE["token_no"])?$_COOKIE["token_no"]:NULL;
		$uuid=isset($_COOKIE["uuid"])?$_COOKIE["uuid"]:NULL;
		if(isset($token_no)){
			$mysql=MySQL::getInstance();
			$sql=new mysqli($mysql->domain, $mysql->username, $mysql->password,$mysql->database, $mysql->port);
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$query="SELECT user_id FROM login WHERE token_no='$token_no' AND uuid='$uuid' AND expiry_time >'".date("Y-m-d H:i:s")."' ORDER BY token_no DESC LIMIT 1";
			$result=$sql->query($query);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					return User::withUserId($row["user_id"]);
				}
			}
			else {
				return NULL;
			}
		}
	}
	public static function renderTop($title){
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>CS &rsaquo; <?php echo $title?></title>
		
		<link rel="stylesheet" href="/resources/style.css" type="text/css""/>
		<link type="text/css" href="/resources/jquery.jscrollpane.css" rel="stylesheet"/>
		<link rel="stylesheet" href="/resources/style.layout.css" type="text/css"/>
		
		<script type="text/javascript" src="/resources/script/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/resources/script/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="/resources/script/mwheelIntent.js"></script>
		<script type="text/javascript" src="/resources/script/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" src="/resources/script/init.js"></script>
 		<script type="text/javascript" src="/resources/dynamiclayout.js"></script>
		
		</head>
		<body>
		<div id="wrapper">
		<div id="header">
        <div id="logo"><a href="/Home">CloudScape</a></div>
        <?php $user=ThisPage::getUser();
        if($user){
        ?>
        <div class="dropdown">
		<a class="account" ><?php 
        echo $user->getFirstName()." ";
        echo $user->getLastName();
        ?></a>
		
		<div class="submenu">
		<ul class="root">
		<li ><a href=/Profiles">Profiles</a></li>
      	<li ><a href=/Preferences">Preferences</a></li>
      	<li ><a href=/RegistrationDetails">Registration Details</a></li>
      	<li ><a href=/ChangePassword">Change Password</a></li>
      	<li ><a href="/Authentication/Logout">Logout</a></li>
		</ul>
		</div>
		
		</div>
        <?php }
        else
		{?>
			<div class="dropdown">
			<a href="/Authentication/Register" class=account>Register</a>
			</div>
  <?php }?>
		</div><!-- #header-->
		<div id="middle">
		<div id="container">
		<div id="content">	
		<?php 
	}
	private static function displaySBentry($credentials){
		if(!is_array($credentials))$credentials=explode(',', $credentials);
		$credentials=array_unique(array_map(null, $credentials));
		$display=FALSE;
		$user=NULL;
		$user_is_loggedin=!is_null($user=ThisPage::getUser());
		$link_is_public=in_array("PUBLIC",$credentials);
		$link_requires_login=in_array("LOGIN",$credentials);
		$user_has_credential=(!is_null($user))?$user->hasCredential($credentials):FALSE;
		if($link_is_public){
			$display=TRUE;
		}
		else if($link_requires_login&&$user_is_loggedin){
			$display=TRUE;
		}
		else if($user_has_credential){
			$display=TRUE;
		}
		return $display;
	}
	public static function renderBottom($options=NULL){
		?>
		</div><!-- #content-->
		</div><!-- #container-->
		<div class="sidebar scroll-pane" id="sideLeft">
		<?php 
		$layout=simplexml_load_file("$_SERVER[DOCUMENT_ROOT]/../resources/layout.xml");
		foreach($layout->leftbar->group as $group ){
		?>
		<div class="groupwrapper">
		<div class="group"><?php echo $group["name"]?></div>
			<div class="entrywrapper">
			<?php 
				foreach ($group->entry as $entry){
					$credentials=$entry["credentials"];
					$display=static::displaySBentry($credentials);
					if($display==TRUE){
						?>
						<div class="entry"><a href="<?php echo $entry["url"]?>" ><span class="text"><?php echo $entry?></span></a></div>
						<?php 
					}
				}
			?>
			</div>
		</div>
		<?php
		}
		?>
		</div><!-- .sidebar#sideLeft -->
		<div class="sidebar" id="sideRight">
		<div id="AppBar" >
		<div id="AppBarTitle">Application Bar</div>
		<div id="AppTools" class="scroll-pane">
		<?php 
		$appTools=[];
		if(isset($options))$appTools=$options["appTools"];
		if(is_array($appTools))foreach ($appTools as $tool){
			if(is_array($tool)){
				$url=$tool["url"];
				$query=isset($tool["query"])?$tool["query"]:null;
				$credentials=$tool["credentials"];
				$display=static::displaySBentry($credentials);
				if($display==TRUE){
					$query_string="";
					if(is_array($query))foreach ($query as $key=>$value){
						$query_string.="&".$key."=".$value;
					}
					$absurl=$url;
					if(strncmp($url, "\\",1)){
						$pattern="/^".preg_quote($_SERVER['DOCUMENT_ROOT'])."/";
						$absurl=preg_replace($pattern, "",getcwd())."\\".$url;
					}
					?><div class="entry"><a href="<?php echo $absurl;?>?ref=<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?><?php echo $query_string;?>"><span class="text"><?php echo $tool["name"]?></span></a></div><?php
				}
			}	
		}
		
		$current_dir=getcwd();
		$orig_dir=getcwd();
		$reached_doc_root=false;
		$exit=false;
		while(!$exit){
			$apptools=@simplexml_load_file($current_dir."\AppTools.xml");
			if($apptools){
				foreach ($apptools->tool as $tool){
					$url=$tool["url"];
					$credentials=$tool["credentials"];
					$display=static::displaySBentry($credentials);
					if($display==TRUE){
						$absurl=$url;
						if(strncmp($url, "\\",1)){
							$pattern="/^".preg_quote($_SERVER['DOCUMENT_ROOT'])."/";
							$absurl=preg_replace($pattern, "",getcwd())."\\".$url;
						}
					?><div class="entry"><a href="<?php echo $absurl;?>?ref=<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>"><span class="text"><?php echo $tool?></span></a></div><?php
					}
				}
			}
			chdir(dirname(getcwd()));
			$current_dir=getcwd();
			if($reached_doc_root){
				$exit=true;
			}
			if($current_dir==$_SERVER['DOCUMENT_ROOT']){
				$reached_doc_root=true;
			}
		}
		chdir($orig_dir);
		?>
		</div>
		</div>
		
		</div><!-- .sidebar#sideRight -->
	
		</div><!-- #middle-->
	
		
	
		</div><!-- #wrapper -->
		</body>
		</html>
		<?php 
	}
}?>
