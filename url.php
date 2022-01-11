<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);

$sql = "INSERT INTO urls (url) VALUES ('".$url."');";

$result = mysql_query($sql);



var_dump($result);
die();




    if($result){
	    echo("ok");
            } else{
	    echo("error");
    }
?>
