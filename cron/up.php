<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT url_id FROM monitor_link WHERE monitor_id = 1 AND status = 1;";
$result = mysqli_query($conn, $sql);

$options = '';

while($row = mysql_fetch_array($result)) {
    $name=$row['id_url'];
    $id_urls .= $name;
}





echo "<pre>";
var_dump($id_urls);


?>