<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
echo "<pre>";

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("SELECT url_id FROM monitor_link WHERE monitor_id = 1 AND status = 1;");
$stmt->execute();
$array = [];
foreach ($stmt->get_result() as $row)
{
    $array[] = $row['url_id'];
}
print_r($array);

foreach ($array as $url_id_to_monitor) {

    $sql_url = "SELECT url FROM urls WHERE id = ".$url_id_to_monitor.";"; 
    $result1 = $conn->query($sql_url);
    $row1 = $result1->fetch_assoc();
    var_dump($row);


}

   

    die();

    $shell_cmd = "/usr/bin/wget -q -O https://charts.rivoluzioneinformatica.org/api/up.php?url=".$url."";
    shell_exec($shell_cmd);



?>