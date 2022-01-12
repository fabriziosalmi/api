<?php
require_once("../plugins/logging.php");
// require_once("conf/security.php");

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$sql_count_urls = "SELECT COUNT(id) FROM urls;";
$result_0 = $conn->query($sql_count_urls);
$urls_count = $result_0->fetch_assoc()["COUNT(id)"];

print_r("<br> urls: ".$urls_count);

$sql_param_1 = "SELECT AVG(score) FROM scores WHERE url_id IN(SELECT DISTINCT url_id FROM urls) ORDER BY id DESC LIMIT ".$urls_count.";";
$result_1 = $conn->query($sql_param_1);
$result_1 = $result_1->fetch_assoc();
$RI_score = floatval($result_1["AVG(score)"]);

$sql1 = "INSERT INTO rindex (score) VALUES ('".$RI_score."')";

if ($conn->query($sql1) === TRUE) {
  echo "<br> OK RIndex: ".$sql1." ";
} else {
  echo "<br> Error: " . $sql1 . "<br>" . $conn->error;
}
