<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo("$url is a valid URL <br>");
} else {
    die("$url is not a valid URL <br>");
}

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
  }
  
$get_http_response_code = get_http_response_code($url);



if ( $get_http_response_code == array(200,201,202,203,302) ) { $score = 100; }

var_dump($get_http_response_code);
die();

if ( $get_http_response_code == 300 ) { $score = 100; }
if ( $get_http_response_code == 301 ) { $score = 100; }
if ( $get_http_response_code == 302 ) { $score = 100; }
if ( $get_http_response_code == 303 ) { $score = 100; }
if ( $get_http_response_code == 304 ) { $score = 100; }
if ( $get_http_response_code == 305 ) { $score = 100; }
if ( $get_http_response_code == 306 ) { $score = 100; }
if ( $get_http_response_code == 307 ) { $score = 100; }
if ( $get_http_response_code == 308 ) { $score = 100; }

if ( $get_http_response_code == 400 ) { $score = 100; }
if ( $get_http_response_code == 401 ) { $score = 100; }
if ( $get_http_response_code == 402 ) { $score = 100; }
if ( $get_http_response_code == 403 ) { $score = 100; }
if ( $get_http_response_code == 404 ) { $score = 100; }
if ( $get_http_response_code == 405 ) { $score = 100; }
if ( $get_http_response_code == 304 ) { $score = 100; }
if ( $get_http_response_code == 304 ) { $score = 100; }
if ( $get_http_response_code == 304 ) { $score = 100; }







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
    echo "UPDATE OK    - " . $sql . "<br>";
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }
  
 
mysqli_close($conn);

?>