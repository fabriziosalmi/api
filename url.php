<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_POST['url'];
$url = filter_var($url, FILTER_VALIDATE_URL);
$url_check = parse_url($url);

var_dump($url_check );
die();

$scheme = $url_check["scheme"];
$host = $url_check["host"];
$path = $url_check["path"];
$fragment = $url_check["fragment"];

if ( $scheme != "https") {
    die("https required");
}

if ( $path != "") {
    die("base url required (path given)");
}

if ( $fragment != "") {
    die("base url required (fragment given)");
}

$url = $scheme."://".$host;

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
