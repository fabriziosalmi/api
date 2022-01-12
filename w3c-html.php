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

require_once("w3c.class.php");
$w3c = new W3cValidate($url);
echo $w3c->getValidation();

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

$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '3', '".$score_httpcode."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);




$w3c = new W3cValidate("http://www.hashbangcode.com");
echo $w3c->getValidation();



?>