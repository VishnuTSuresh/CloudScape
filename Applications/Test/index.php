<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

?>

<?php
$mysql=new mysqli("172.23.0.1", "dptv", "sql_sre!", "dptv");
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$res=$mysql->query("select id, referenceNumber, date, category, heading, designation from notices WHERE category LIKE '%Department (Academic) Notice Board%' OR category LIKE '%Department (Administrative) Notice Board%' OR category LIKE '%Student Council Notice Board%' OR category LIKE '%Bhawan Notice Board%' OR category LIKE '%MESS Notice Board%' OR category LIKE '%Sports Council Notice Board%' OR category LIKE '%Cultural Notice Board%' OR category LIKE '%Hobbies Club Notice Board%' OR category LIKE '%Student Club Notice Board%' OR category LIKE '%Himalayan Exploration Club Notice Board%' OR category LIKE '%Cinema Club Notice Board%' ORDER BY date DESC LIMIT 0,20");
while($row=$res->fetch_assoc()){
	echo $row["heading"]."<br />";
}
?>
