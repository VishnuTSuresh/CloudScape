<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

Class UGCS{
	protected static $tblnm="user_generated_content_system",$appname="";
	protected $user=NULL;
	public function __construct($user){
		$this->user=$user;
	}
	protected function appAddBinding($key,$data){
		$value=NULL;
		return $value;
	}
	public function add($key,$data,$comment){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$comment=$mysqli->real_escape_string($comment);
		$query="SELECT `key` FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."'";
		$result=$mysqli->query($query);
		
		if(intval($result->num_rows)==0){
			$value=$this->appAddBinding($key,$data);
			if($value!==false){
				$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id,comment,action)
				VALUES ('".static::$appname."', '$key',$value,NOW(),".$this->user->getUserId().",'$comment','ADD')";
				$mysqli->query($query);
				return true;
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	protected function appEditBinding($key,$data){
		
		$value=NULL;
		return $value;
	}
	public function edit($key,$data,$comment){
		Console::log($comment);
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$comment=$mysqli->real_escape_string($comment);
		$query="SELECT branch_node FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$value=$this->appEditBinding($key,$data);
			$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id, branch_node,`comment`)
			VALUES ('".static::$appname."', '$key',$value,NOW(),".$this->user->getUserId().",".$row['branch_node'].",'$comment')";
			$mysqli->query($query);
			return true;
		}
		else{
			return false;
		}
	}
	protected function appDeleteBinding($key){

	}
	public function delete($key,$comment){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$comment=$mysqli->real_escape_string($comment);
		$query="SELECT branch_node FROM ".self::$tblnm." WHERE `key`='$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($row=$result->fetch_assoc()){
			$query="INSERT INTO ".self::$tblnm." (app_name, `key`, `value`,creation_time,user_id, branch_node,comment,action)
			VALUES ('".static::$appname."', '$key',NULL,NOW(),".$this->user->getUserId().",".$row['branch_node'].",'$comment','DELETE')";
			if($mysqli->query($query)){
				$this->appDeleteBinding($key);
			}			
			return true;
		}
		else{
			return false;
		}
	}
	protected function appUndoBinding($key,$value){
	}
	public function undo($id,$comment){
		$mysqli=MySQL::getConnection();
		$id=$mysqli->real_escape_string($id);
		$query="INSERT INTO ".self::$tblnm." 
				(app_name,
				`key`,
				value,
				creation_time,
				user_id,
				branch_node,
				comment,
				action)
				 
				SELECT 
				'".static::$appname."',
				`key`,
				value,
				NOW(),
				".$this->user->getUserId().",
				id,
				'$comment',
				'UNDO'
				FROM ".self::$tblnm." 
				WHERE id = $id";
		$result=$mysqli->query($query);
		if($result){
			$query="SELECT key,value FROM ".self::$tblnm." WHERE id = $id";
			$result1=$mysqli->query($query);
			$row=$result1->fetch_assoc();
			$this->appUndoBinding($row["key"],$row["value"]);
		}
		return $result;
	}
	public static function getKeysLike($regexp){
		$mysqli=MySQL::getConnection();
		$query="SELECT `key` FROM ".$tblnm." WHERE `key` REGEXP '$regexp' AND app_name='".$appname."' ORDER BY `key` ASC";
		$result=$mysqli->query($query);
		return $result;
	}
	protected static function appGetDataBinding($value){
		$data=NULL;
		return $data;
	}
	public static function getData($key){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$query="SELECT `value` FROM ".self::$tblnm." WHERE `key` = '$key' AND app_name='".static::$appname."' ORDER BY id DESC LIMIT 1";
		$result=$mysqli->query($query);
		if($result){
			$row=$result->fetch_assoc();
			$value=$row["value"];
			
			$data=static::appGetDataBinding($value);
			if($data){
				return $data;
			}
			return false;
		}
		else{
			return false;
		}
	}
	public static function getDataById($id){
		$mysqli=MySQL::getConnection();
		$id=$mysqli->real_escape_string($id);
		$query="SELECT `value` FROM ".self::$tblnm." WHERE id = '$id'";
		$result=$mysqli->query($query);
		if($result){
			$row=$result->fetch_assoc();
			$value=$row["value"];
				
			$data=static::appGetDataBinding($value);
			if($data){
				return $data;
			}
			return false;
		}
		else{
			return false;
		}
	}
	protected static function appGetMetaBinding($value){
		$data=NULL;
		return $data;
	}
	public static function getMeta($key){
	//not yet implemented. current apps dont require it.
	}
	public static function getMetaById($id){
		$mysqli=MySQL::getConnection();
		$id=$mysqli->real_escape_string($id);
		$query="SELECT 
				`key`,
				value,
				creation_time,
				user_id,
				branch_node,
				comment,
				action 
				
				FROM ".self::$tblnm." 
				
				WHERE id=$id";
		$result=$mysqli->query($query);
		if($result){
			$meta1=$result->fetch_assoc();
			$meta2=static::appGetMetaBinding($meta1["value"]);
			($meta2)?$meta=array_merge($meta1,$meta2):$meta=$meta1;
			unset($meta["value"]);		
			return $meta;
		}
		else{
			return false;
		}
	}
	public static function history($key,$limit){
		$mysqli=MySQL::getConnection();
		$key=$mysqli->real_escape_string($key);
		$query="SELECT id,creation_time,user_id,branch_node,comment,action FROM ".self::$tblnm." WHERE `key` = '$key' AND app_name='".static::$appname."' ORDER BY creation_time DESC LIMIT $limit";
		$result=$mysqli->query($query);
		if($result){
			return $result;
		}
		else{
			return false;
		}
	}
	public static function renderHistory($key,$page){
		$curr_user=ThisPage::getUser();
		?>
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
		$history=self::history($key,10*$page);
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
		    	$meta=self::getMetaById($row["branch_node"]);
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
		<?php 
	}
}
?>
