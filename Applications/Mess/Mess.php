<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
class Mess extends UGCS{
	protected static $appname="MESS_TIMETABLE";
	public static function getFoodList(){
		$mysql=MySQL::getConnection();
		$query="SELECT id,name FROM mess_items";
		$result=$mysql->query($query);
		return $result;
	}
	public static function keyFromDate($date){
		if(!$date)$date=time();
		$timestamp=strtotime($date);
		$timestamp=$timestamp?$timestamp:$date;
		$key=date("o\WW",$timestamp);
		if($key)return $key;
		return date("o\WW");
	}
	private function genValue($id,$data){
		$values=array();
		foreach ($data as $day=>$peroids){
			$day_enum="MONDAY";
			switch ($day){
				case "Mo":
					$day_enum="MONDAY";
					break;
				case "Tu":
					$day_enum="TUESDAY";
					break;
				case "We":
					$day_enum="WEDNESDAY";
					break;
				case "Th":
					$day_enum="THURSDAY";
					break;
				case "Fr":
					$day_enum="FRIDAY";
					break;
				case "Sa":
					$day_enum="SATURDAY";
					break;
				case "Su":
					$day_enum="SUNDAY";
					break;
			}
			foreach ($peroids as $peroid=>$meal){
				$peroid_enum="BREAKFAST";
				switch($peroid){
					case "B":
						$peroid_enum="BREAKFAST";
						break;
					case "L":
						$peroid_enum="LUNCH";
						break;
					case "D":
						$peroid_enum="DINNER";
						break;
				}
				foreach ($meal as $food_id){
					$mysql=MySQL::getConnection();
					if(!ctype_digit($food_id))return false;
					$values[]="($id,$food_id,'$day_enum','$peroid_enum')";
				}
			}
		}
		$values=implode(",", $values);
		return $values;
	}
	protected function appAddBinding($key,$data){
		$id=false;
		$mysql=MySQL::getConnection();
		$query="INSERT INTO mess_timetable_primary SET week='$key', current=1";
		if($mysql->query($query)){
			$id=$mysql->insert_id;
			$values=$this->genValue($id,$data);
			$query="INSERT INTO mess_timetable (id,food_item,day,period) VALUES $values";
			$result=$mysql->query($query);
			if(!$result)return false;
		}
		return $id;
	}
	protected function appEditBinding($key,$data){
		$id=false;
		$mysql=MySQL::getConnection();
		$query="UPDATE mess_timetable_primary SET current=0 WHERE week='$key'";
		$mysql->query($query);
		$query="INSERT INTO mess_timetable_primary SET week='$key', current=1";
		if($mysql->query($query)){
			$id=$mysql->insert_id;
			$values=$this->genValue($id,$data);
			$query="INSERT INTO mess_timetable (id,food_item,day,period) VALUES $values";
			$result=$mysql->query($query);
			if(!$result)return false;
		}
		return $id;
	}
	protected static function appGetDataBinding($value){
		$mysql=MySQL::getConnection();
		$query="SELECT food_item,day,period FROM mess_timetable WHERE id=$value";
		$result=$mysql->query($query);
		$data=[
			"MONDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"TUESDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"WEDNESDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"THURSDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"FRIDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"SATURDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
			"SUNDAY"=>[
				"BREAKFAST"=>[],
				"LUNCH"=>[],
				"DINNER"=>[]
			],
		];
		if($result){
		while($row=$result->fetch_assoc()){
			$data[$row["day"]][$row["period"]][]=$row["food_item"];
		}}
		return $data;
	}
	protected static function appGetMetaBinding($value){
		$data=NULL;
		return $data;
	}
}
?>
