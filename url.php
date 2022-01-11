<?
require_once("conf/database.php");

$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);

var_dump($url);
$sql = "INSERT INTO urls (url) VALUES (\'$url\');";
var_dump($sql);


$result = mysql_query($sql);
    if($result){
	    echo($url." added.");
            } else{
	    echo("Error.");
    }
?>