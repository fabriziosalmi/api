<?php
require_once("conf/logging.php");
require_once("util.php");

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ( $httpcode == "" ) { $score = 0; }
if ( $httpcode == NULL ) { $score_httpcode = 0; }
if ( $httpcode == "200" ) { $score_httpcode = 100; }
if ( $httpcode == "201" ) { $score_httpcode = 90; }
if ( $httpcode == "202" ) { $score_httpcode = 60; }
if ( $httpcode == "204" ) { $score_httpcode = 5; }
if ( $httpcode == "301" ) { $score_httpcode = 40; }
if ( $httpcode == "302" ) { $score_httpcode = 60; }
if ( $httpcode == "304" ) { $score_httpcode = 70; }
if ( $httpcode == "307" ) { $score_httpcode = 50; }
if ( $httpcode == "308" ) { $score_httpcode = 40; }
if ( $httpcode == "500" ) { $score_httpcode = 1; }
if ( $httpcode == "501" ) { $score_httpcode = 1; }
if ( $httpcode == "502" ) { $score_httpcode = 1; }
if ( $httpcode == "503" ) { $score_httpcode = 1; }
if ( $httpcode == "504" ) { $score_httpcode = 1; }

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];

$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '1', '".$score_httpcode."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>