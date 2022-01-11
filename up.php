<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
curl_setopt($ch, CURLINFO_NAMELOOKUP_TIME, true);
curl_setopt($ch, CURLINFO_CONNECT_TIME, true);

$output = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$namelookup_time = curl_getinfo($ch, CURLINFO_NAMELOOKUP_TIME);

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

if ( $namelookup_time < "0.002" ) { $score_namelookup = 100; }
if ( $namelookup_time > "0.004" ) { $score_namelookup = 98; }
if ( $namelookup_time > "0.008" ) { $score_namelookup = 96; }
if ( $namelookup_time > "0.010" ) { $score_namelookup = 94; }
if ( $namelookup_time > "0.020" ) { $score_namelookup = 92; }
if ( $namelookup_time > "0.030" ) { $score_namelookup = 90; }
if ( $namelookup_time > "0.040" ) { $score_namelookup = 85; }
if ( $namelookup_time > "0.050" ) { $score_namelookup = 80; }
if ( $namelookup_time > "0.100" ) { $score_namelookup = 75; }
if ( $namelookup_time > "0.200" ) { $score_namelookup = 70; }
if ( $namelookup_time > "0.300" ) { $score_namelookup = 65; }
if ( $namelookup_time > "0.400" ) { $score_namelookup = 60; }
if ( $namelookup_time > "0.500" ) { $score_namelookup = 55; }
if ( $namelookup_time > "0.600" ) { $score_namelookup = 50; }
if ( $namelookup_time > "0.700" ) { $score_namelookup = 45; }
if ( $namelookup_time > "0.800" ) { $score_namelookup = 40; }
if ( $namelookup_time > "0.900" ) { $score_namelookup = 35; }
if ( $namelookup_time > "1" ) { $score_namelookup = 30; }
if ( $namelookup_time > "2" ) { $score_namelookup = 25; }
if ( $namelookup_time > "3" ) { $score_namelookup = 20; }
if ( $namelookup_time > "4" ) { $score_namelookup = 15; }
if ( $namelookup_time > "5" ) { $score_namelookup = 10; }
if ( $namelookup_time > "7" ) { $score_namelookup = 5; }
if ( $namelookup_time > "9" ) { $score_namelookup = 0; }


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
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '2', '".$score_namelookup."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>