<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once("conf/database.php");

$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);

print_r($url);

$sql = "INSERT INTO urls (url) VALUES (\'$url\');";
var_dump($sql);


$result = mysql_query($sql);

    if($result){
	    echo("ok");
            } else{
	    echo("error");
    }
?>