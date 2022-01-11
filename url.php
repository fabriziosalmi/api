<?
require_once("conf/database.php");

$url = $_POST['url'];

var_dump($url);

//inserting data order
$sql = "INSERT INTO urls (url) VALUES ('$url');";

//declare in the order variable
$result = mysql_query($sql);
if($result){
	echo("<br>".$url." added.");
} else{
	echo("Error.");
}
?>