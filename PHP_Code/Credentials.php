<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
class Credentials{
	public static function getIdFrom($credential){
		$mysql=MySQL::getConnection();
		$query="SELECT id FROM credentials WHERE UPPER(name)='$credential'";
		$result=$mysql->query($query);
		while($row=$result->fetch_assoc()){
			return $row["id"];
		}
	}
}
?>