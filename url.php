<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$url = $_POST['url'];

// Remove all illegal characters from a url
$url = filter_var($url, FILTER_SANITIZE_URL);

if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo("$url is a valid URL <br>");
} else {
    die("$url is not a valid URL <br>");
}

$parsed_url = parse_url($url);
$scheme = $parsed_url["scheme"];

// Remove any non HTTPS submitted data
if($scheme == "https"){
    echo("$url is a valid HTTPS URL");
} else {
    die("$url is not a valid HTTPS URL");
}

// Clean path and fragment (to improve)
if (isset($parsed_url["path"])) {
    $parsed_url["path"] = "";
    unset($parsed_url["path"]);
}

if (isset($parsed_url["fragment"])) {
    $parsed_url["fragment"] = "";
    unset($parsed_url["fragment"]);
}

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO urls (url,status) VALUES ('".$url."', 0);";

if(mysqli_query($conn, $sql)){
    echo "<br> ok <br>";
} else{
    echo "<br> error: " . mysqli_error($conn). "<br>";
}
 
mysqli_close($conn);

unset($url);

echo '<p><a href="">add url</a></p>';
?>
