<?php

// require_once("conf/sentry.php");
require_once("w3c.class.php");

if (PHP_SAPI === 'cli')

{

    parse_str(implode('&', array_slice($argv, 1)), $_GET);

} 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 

  echo "<br> ".$url." is valid<br> "; 

} else { 

  die("<br> $url is invalid<br> "); 

} 

$w3c = new W3cValidate($url);
$w3c_valid = $w3c->getValidation();
echo "W3C ".$w3c_valid;

if ( $w3c_valid = "-1") { 
  print_r("score 0");
  $w3c_score = 0;
}

if ( $w3c_valid = "0") { 
  print_r("score 100");
  $w3c_score = 100;
}

// check score
require_once("functions.php");

if ( score_check($w3c_score, 0, 100) === FALSE ) {
    die( "error: exiting.." );
} 

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];

$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '3', '".$w3c_score."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);


?>