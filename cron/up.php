<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
echo "<pre>";

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT url_id FROM monitor_link WHERE monitor_id = 1 AND status = 1;";

$data = array(); 
while ($row = mysqli_fetch_array($result)) {
    array_push($data, $row["url_id"]);
}

var_dump($row["url_id"]);
var_dump($data);

?>