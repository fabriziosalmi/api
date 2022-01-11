<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$url = $_POST['url'];
$url = filter_var($url, FILTER_VALIDATE_URL);
$sql = "INSERT INTO urls (url,status) VALUES ('".$url."', 0);";

if(mysqli_query($conn, $sql)){
    echo "ok";
} else{
    echo "error: " . mysqli_error($conn);
}
 
mysqli_close($conn);

?>
