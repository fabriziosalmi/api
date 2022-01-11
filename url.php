<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_POST['url'];

// Remove all illegal characters from a url
$url = filter_var($url, FILTER_SANITIZE_URL);

if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo("$url is a valid URL");
} else {
    die("$url is not a valid URL");
}

$parsed_url = parse_url($url);

var_dump($parsed_url);

// Remove any non HTTPS submitted data
if($parsed_url["scheme"] == "https"){
    echo("$url is a valid HTTPS URL");
} else {
    die("$url is not a valid HTTPS URL");
}


var_dump($url);
die();

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO urls (url,status) VALUES ('".$url."', 0);";

if(mysqli_query($conn, $sql)){
    echo "ok";
} else{
    echo "error: " . mysqli_error($conn);
}
 
mysqli_close($conn);

?>
