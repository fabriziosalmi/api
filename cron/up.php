<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT url_id FROM monitor_link WHERE monitor_id = 1 AND status = 1;";
$result = mysqli_query($conn, $sql);

var_dump($result);

while ($row = mysqli_fetch_assoc($result)) {
  echo "<pre>";
  echo $row["url_id"];
  $id_urls .= $row["url_id"];
}




var_dump($id_urls);

?>