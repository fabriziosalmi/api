<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

var_dump($url);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);

$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ( $httpcode == "" ) { $score = 0; }
if ( $httpcode == NULL ) { $score = 0; }
if ( $httpcode == "200" ) { $score = 100; }
if ( $httpcode == "201" ) { $score = 90; }
if ( $httpcode == "202" ) { $score = 60; }
if ( $httpcode == "204" ) { $score = 5; }
if ( $httpcode == "301" ) { $score = 40; }
if ( $httpcode == "302" ) { $score = 60; }
if ( $httpcode == "304" ) { $score = 70; }
if ( $httpcode == "307" ) { $score = 50; }
if ( $httpcode == "308" ) { $score = 40; }
if ( $httpcode == "500" ) { $score = 1; }
if ( $httpcode == "501" ) { $score = 1; }
if ( $httpcode == "502" ) { $score = 1; }
if ( $httpcode == "503" ) { $score = 1; }
if ( $httpcode == "504" ) { $score = 1; }

echo "<pre>";
var_dump($output);
die();



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
    echo "OK";
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }
  
 
mysqli_close($conn);

?>