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

var_dump($url);

$sql = "INSERT INTO urls (url) VALUES ('".$url."');";

var_dump($sql);

if(mysqli_query($conn, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
 
mysqli_close($conn);

?>
