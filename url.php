<?php

// get url
$url = $_POST['url'];

//url sanitizer 
$url = filter_var($url, FILTER_SANITIZE_URL);

//url validator 
if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 
    echo "<br> ".$url." is valid"; 
} else { 
  die("<br> $url is invalid URL"); 
} 

$parsed_url = parse_url($url);
$scheme = $parsed_url["scheme"];

// Remove any non HTTPS submitted data
if($scheme == "https"){
    echo "<br> ".$url." is a valid HTTPS URL";
} else {
    die("<br> $url is not a valid HTTPS URL");
}

// Force base url monitoring, not any url
$url_info = parse_url($url);
$url_host = $url_info['host'];
// to improve by far 
$url = "https://".$url_host;

// Clean path and fragment (to improve)
if (isset($parsed_url["path"])) {
    $parsed_url["path"] = "";
    unset($parsed_url["path"]);
}

if (isset($parsed_url["fragment"])) {
    $parsed_url["fragment"] = "";
    unset($parsed_url["fragment"]);
}

$origin = $_SERVER["HTTP_ORIGIN"];
$referrer = $_SERVER["HTTP_REFERER"];

if ( $origin == "https://charts.rivoluzioneinformatica.org") { 
    echo "<br>".$origin." is valid ORIGIN"; 
} else { 
    die("<br> error: origin ".$origin." url ".$url);
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

echo '<p><a href="add.html">add url</a></p>';
?>
