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

print_r("<br>url id: ".$url_id."<br>");

$sql_param = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 1 ORDER BY id DESC LIMIT 1;";
$result1 = $conn->query($sql_param);
if ($result1->num_rows > 0) { while($row = $result1->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$url_score = $score;

print_r("<br>up: ".$url_score."<br>");


$sql_param2 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 2 ORDER BY id DESC LIMIT 1;";
$result2 = $conn->query($sql_param2);
if ($result2->num_rows > 0) { while($row = $result2->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$dns_score = $score;

print_r("<br>dns: ".$dns_score."<br>");

// sum scores - to improve with sql select result
$sum = $url_score  + $dns_score;
$values=2;
$score = floatval($sum) / floatval($values);

$sql2 = "INSERT INTO scores (url_id, score) VALUES ('$url_id', '$score')";

if ($conn->query($sql2) === TRUE) {
  echo "<br> url_id: ".$url_id." - Score: ".$score." ";
} else {
  echo "<br> Error: " . $sql2 . "<br>" . $conn->error;
}

