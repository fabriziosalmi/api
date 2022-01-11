<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

var_dump($url);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, false);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);

$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$codes_a = array("200","201");
$codes_b = array("301","302","304","307","308");
$codes_c = array("500","501","502","503","504");
$codes_d = array("", NULL);

if (in_array($httpcode , $codes_a)) { $score = 100; }
if (in_array($httpcode , $codes_b)) { $score = 50; }
if (in_array($httpcode , $codes_c)) { $score = 1; }
if (in_array($httpcode , $codes_d)) { $score = 0; }

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];

$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '1', '".$score."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "UPDATE OK    - "$url. " - " . $sql . "<br>";
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }
  
 
mysqli_close($conn);

?>