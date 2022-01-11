<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

var_dump($url);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, false);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ( $httpcode == "" ) { $score = 0; }
if ( $httpcode == array("200","201","202","203","302","304","305","306","307") ) { $score = 100; }
if ( $httpcode == array(308,400,401,402,403,405,406,407,408,409,410,415) ) { $score = 4; }
if ( $httpcode == array(500,501,502,503,504,505,506,507,508,510,511) ) { $score = 2; }

var_dump($httpcode);
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