<?php

if (PHP_SAPI === 'cli')

{

    parse_str(implode('&', array_slice($argv, 1)), $_GET);

} 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 

  echo "<br> ".$url." is valid"; 

} else { 

  die("<br> $url is invalid"); 

} 

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
curl_setopt($ch, CURLINFO_NAMELOOKUP_TIME, true);
curl_setopt($ch, CURLINFO_CONNECT_TIME, true);

$output = curl_exec($ch);

$namelookup_time = curl_getinfo($ch, CURLINFO_NAMELOOKUP_TIME);

curl_close($ch);

if ( $namelookup_time < "0.001" ) { $score_namelookup = 100; }
if ( $namelookup_time > "0.002" ) { $score_namelookup = 99; }
if ( $namelookup_time > "0.003" ) { $score_namelookup = 98; }
if ( $namelookup_time > "0.004" ) { $score_namelookup = 97; }
if ( $namelookup_time > "0.005" ) { $score_namelookup = 96; }
if ( $namelookup_time > "0.006" ) { $score_namelookup = 95; }
if ( $namelookup_time > "0.007" ) { $score_namelookup = 94; }
if ( $namelookup_time > "0.008" ) { $score_namelookup = 93; }
if ( $namelookup_time > "0.009" ) { $score_namelookup = 92; }
if ( $namelookup_time > "0.010" ) { $score_namelookup = 91; }
if ( $namelookup_time > "0.011" ) { $score_namelookup = 90; }
if ( $namelookup_time > "0.012" ) { $score_namelookup = 89; }
if ( $namelookup_time > "0.013" ) { $score_namelookup = 89; }
if ( $namelookup_time > "0.014" ) { $score_namelookup = 87; }
if ( $namelookup_time > "0.015" ) { $score_namelookup = 86; }
if ( $namelookup_time > "0.016" ) { $score_namelookup = 85; }
if ( $namelookup_time > "0.017" ) { $score_namelookup = 84; }
if ( $namelookup_time > "0.018" ) { $score_namelookup = 83; }
if ( $namelookup_time > "0.019" ) { $score_namelookup = 82; }
if ( $namelookup_time > "0.020" ) { $score_namelookup = 81; }
if ( $namelookup_time > "0.021" ) { $score_namelookup = 80; }
if ( $namelookup_time > "0.022" ) { $score_namelookup = 79; }
if ( $namelookup_time > "0.023" ) { $score_namelookup = 78; }
if ( $namelookup_time > "0.024" ) { $score_namelookup = 77; }
if ( $namelookup_time > "0.025" ) { $score_namelookup = 76; }
if ( $namelookup_time > "0.026" ) { $score_namelookup = 75; }
if ( $namelookup_time > "0.027" ) { $score_namelookup = 74; }
if ( $namelookup_time > "0.028" ) { $score_namelookup = 73; }
if ( $namelookup_time > "0.029" ) { $score_namelookup = 72; }
if ( $namelookup_time > "0.030" ) { $score_namelookup = 71; }
if ( $namelookup_time > "0.031" ) { $score_namelookup = 70; }
if ( $namelookup_time > "0.032" ) { $score_namelookup = 69; }
if ( $namelookup_time > "0.033" ) { $score_namelookup = 68; }
if ( $namelookup_time > "0.034" ) { $score_namelookup = 67; }
if ( $namelookup_time > "0.035" ) { $score_namelookup = 66; }
if ( $namelookup_time > "0.036" ) { $score_namelookup = 65; }
if ( $namelookup_time > "0.037" ) { $score_namelookup = 64; }
if ( $namelookup_time > "0.038" ) { $score_namelookup = 63; }
if ( $namelookup_time > "0.039" ) { $score_namelookup = 62; }
if ( $namelookup_time > "0.040" ) { $score_namelookup = 61; }
if ( $namelookup_time > "0.041" ) { $score_namelookup = 60; }
if ( $namelookup_time > "0.042" ) { $score_namelookup = 59; }
if ( $namelookup_time > "0.043" ) { $score_namelookup = 58; }
if ( $namelookup_time > "0.044" ) { $score_namelookup = 57; }
if ( $namelookup_time > "0.045" ) { $score_namelookup = 56; }
if ( $namelookup_time > "0.046" ) { $score_namelookup = 55; }
if ( $namelookup_time > "0.047" ) { $score_namelookup = 54; }
if ( $namelookup_time > "0.048" ) { $score_namelookup = 53; }
if ( $namelookup_time > "0.049" ) { $score_namelookup = 52; }
if ( $namelookup_time > "0.050" ) { $score_namelookup = 51; }
if ( $namelookup_time > "0.051" ) { $score_namelookup = 50; }
if ( $namelookup_time > "0.06" ) { $score_namelookup = 49; }
if ( $namelookup_time > "0.07" ) { $score_namelookup = 48; }
if ( $namelookup_time > "0.08" ) { $score_namelookup = 47; }
if ( $namelookup_time > "0.09" ) { $score_namelookup = 46; }
if ( $namelookup_time > "0.1" ) { $score_namelookup = 45; }
if ( $namelookup_time > "0.11" ) { $score_namelookup = 44; }
if ( $namelookup_time > "0.12" ) { $score_namelookup = 43; }
if ( $namelookup_time > "0.13" ) { $score_namelookup = 42; }
if ( $namelookup_time > "0.14" ) { $score_namelookup = 41; }
if ( $namelookup_time > "0.15" ) { $score_namelookup = 40; }
if ( $namelookup_time > "0.16" ) { $score_namelookup = 39; }
if ( $namelookup_time > "0.17" ) { $score_namelookup = 38; }
if ( $namelookup_time > "0.18" ) { $score_namelookup = 37; }
if ( $namelookup_time > "0.19" ) { $score_namelookup = 36; }
if ( $namelookup_time > "0.20" ) { $score_namelookup = 35; }
if ( $namelookup_time > "0.21" ) { $score_namelookup = 34; }
if ( $namelookup_time > "0.22" ) { $score_namelookup = 33; }
if ( $namelookup_time > "0.23" ) { $score_namelookup = 32; }
if ( $namelookup_time > "0.24" ) { $score_namelookup = 31; }
if ( $namelookup_time > "0.25" ) { $score_namelookup = 30; }
if ( $namelookup_time > "0.3" ) { $score_namelookup = 30; }
if ( $namelookup_time > "0.35" ) { $score_namelookup = 29; }
if ( $namelookup_time > "0.4" ) { $score_namelookup = 28; }
if ( $namelookup_time > "0.45" ) { $score_namelookup = 27; }
if ( $namelookup_time > "0.5" ) { $score_namelookup = 26; }
if ( $namelookup_time > "0.55" ) { $score_namelookup = 25; }
if ( $namelookup_time > "0.6" ) { $score_namelookup = 24; }
if ( $namelookup_time > "0.65" ) { $score_namelookup = 23; }
if ( $namelookup_time > "0.7" ) { $score_namelookup = 22; }
if ( $namelookup_time > "0.75" ) { $score_namelookup = 21; }
if ( $namelookup_time > "0.8" ) { $score_namelookup = 20; }
if ( $namelookup_time > "0.85" ) { $score_namelookup = 19; }
if ( $namelookup_time > "0.9" ) { $score_namelookup = 18; }
if ( $namelookup_time > "0.95" ) { $score_namelookup = 17; }
if ( $namelookup_time > "1" ) { $score_namelookup = 16; }
if ( $namelookup_time > "1.5" ) { $score_namelookup = 15; }
if ( $namelookup_time > "2" ) { $score_namelookup = 14; }
if ( $namelookup_time > "2.5" ) { $score_namelookup = 13; }
if ( $namelookup_time > "3" ) { $score_namelookup = 12; }
if ( $namelookup_time > "3.5" ) { $score_namelookup = 11; }
if ( $namelookup_time > "4" ) { $score_namelookup = 10; }
if ( $namelookup_time > "4.5" ) { $score_namelookup = 9; }
if ( $namelookup_time > "5" ) { $score_namelookup = 8; }
if ( $namelookup_time > "5.5" ) { $score_namelookup = 7; }
if ( $namelookup_time > "6" ) { $score_namelookup = 6; }
if ( $namelookup_time > "6.5" ) { $score_namelookup = 5; }
if ( $namelookup_time > "7" ) { $score_namelookup = 4; }
if ( $namelookup_time > "7.5" ) { $score_namelookup = 3; }
if ( $namelookup_time > "8" ) { $score_namelookup = 2; }
if ( $namelookup_time > "8.5" ) { $score_namelookup = 1; }
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
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '2', '".$score_namelookup."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>