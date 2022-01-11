<?
require_once("conf/database.php");

$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);

$sql = "INSERT INTO urls (url) VALUES (\'$url\');";

$result = mysql_query($sql);
    if($result){
	    echo($url." added.");
            } else{
	    echo("Error.");
    }
?>