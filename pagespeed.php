<?php
// require_once("conf/sentry.php");

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

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, url FROM urls WHERE url = \"$url\";";
$row = $conn->query($sql)->fetch_assoc();
$url_id = $row["id"];
$url = $row["url"];

set_time_limit(60);
$pagespeed_score = exec("/usr/local/bin/psi ".$url." | grep Performance | awk '{print $2}'");

$sql1 = "INSERT INTO checks (url_id, monitor_id, score) VALUES ('$url_id', '4', '".$pagespeed_score."')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully - ".$sql." ";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

?>