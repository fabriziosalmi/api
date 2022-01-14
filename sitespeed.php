<?php
ini_set('max_execution_time', 60);

if (PHP_SAPI === 'cli') { parse_str(implode('&', array_slice($argv, 1)), $_GET); } 


$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { echo "<br> ".$url." is valid"; } else { die("<br> $url is invalid"); } 

// litespeed
$litespeed_docker_cmd = "docker run --rm -v \"$(pwd)\":/sitespeed.io sitespeedio/sitespeed.io -n1 --summary ".$url." | tail -n1 | sed -r 's/\x1B\[(;?[0-9]{1,3})+[mGK]//g'";
$docker_out = exec($litespeed_docker_cmd);
$docker_out = explode("Coach Overall Score:", $docker_out);
$docker_out = $docker_out[1];
$docker_out = explode(" /", $docker_out);
$docker_out = $docker_out[0];
$litespeed_score = $docker_out;

// check score
require_once("functions.php");

if ( score_check($litespeed_score, 0, 100) === FALSE ) {
    die( "error: exiting.." );
} 

// save score
require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '7', '".$litespeed_score ."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>