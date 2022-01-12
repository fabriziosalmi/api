<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (PHP_SAPI === 'cli')
{
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
} 

$url = $_GET['url'];

//url sanitizer 
$url = filter_var($url, FILTER_SANITIZE_URL);

//url validator 
if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 
  echo("<br> $url is valid"); 
} else { 
  echo("<br> $url is invalid"); 
} 

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = \"$url\";";
$result = $conn->query($sql);
$url_id = $result->fetch_assoc()["id"];


$sql_param = "SELECT score FROM checks WHERE url_id = ".$url_id." AND param_id = 1 ORDER BY id DESC LIMIT 1;";
$result1 = $conn->query($sql_param);

var_dump($result1);

die();
// sum scores
$sum = $score_up + $score_dns;

// improve with sql select result
$values=2;

$url_score = floatval($sum) / floatval($values);


$sql2 = "INSERT INTO scores (url_id, score) VALUES ('$url_id', '$url_score')";

if ($conn->query($sql2) === TRUE) {
  echo "<br> New record - ".$sql2." ";
} else {
  echo "<br> Error: " . $sql2 . "<br>" . $conn->error;
}

