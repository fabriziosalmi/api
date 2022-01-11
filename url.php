<?
require_once("conf/database.php");

$url = $_POST['url'];

//inserting data order
$toinsert = "INSERT INTO urls (url) VALUES ('$url')";

//declare in the order variable
$result = mysql_query($toinsert);	//order executes
if($result){
	echo("<br>".$url." added.");
} else{
	echo("Error.");
}
?>