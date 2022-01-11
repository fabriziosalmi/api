<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


function url_test( $url ) {
	$timeout = 10;
	$ch = curl_init();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
	$http_respond = curl_exec($ch);
	$http_respond = trim( strip_tags( $http_respond ) );
	$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
	if ( ( $http_code == "200" ) || ( $http_code == "201" ) || ( $http_code == "204" ) || ( $http_code == "302" ) || ( $http_code == "304" ) || ( $http_code == "103" ) || ( $http_code == "301" ) ) {
		return true;
	} else {
		// you can return $http_code here if necessary or wanted
		return false;
	}
	curl_close( $ch );
}

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo("$url is a valid URL <br>");
} else {
    die("$url is not a valid URL <br>");
}

if( !url_test( $url ) ) {
	echo "<br>".$url." ok";
    $score = 100;
} else {
	echo "<br>".$url." error";
    $score = 1;
}

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql_url_id = "SELECT id FROM urls WHERE url = ".$url." ;";
$result_url_id = $conn->query($sql_url_id);
var_dump($result_url_id );
die();

$sql = "INSERT INTO checks (url_id, monitor_id, score) VALUES ('".$url."', '1', '".$score."') WHERE url_id = ".$url_id.";";

if(mysqli_query($conn, $sql)){
    echo "<br> ok ".$http_code."<br>";
} else{
    echo "<br> error: ".$http_code." - ". mysqli_error($conn). "<br>";
}
 
mysqli_close($conn);
unset($url);

?>