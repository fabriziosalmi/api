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

if ( $get_http_response_code = "" ) { 
    $score = 0;
    die("url is unreachable"); }

if ( $get_http_response_code == array(200,201,202,203,302,304,305,306,307) ) { $score = 100; }

if ( $get_http_response_code == array(308,400,401,402,403,405,406,407,408,409,410,415) ) { $score = 4; }

if ( $get_http_response_code == array(500,501,502,503,504,505,506,507,508,510,511) ) { $score = 2; }

if ( $get_http_response_code != array(200,201,202,203,302,304,305,306,307,308,400,401,402,403,405,406,407,408,409,410,415,500,501,502,503,504,505,506,507,508,510,511) ) { $score = 1; }


var_dump($get_http_response_code);
var_dump($score);
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

$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '1', '".$score."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "UPDATE OK    - " . $sql . "<br>";
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }
  
 
mysqli_close($conn);

?>