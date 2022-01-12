<?php
require_once("../plugins/logging.php");
// require_once("conf/security.php");

echo "<pre>";

require_once("../conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("SELECT url_id FROM monitor_link WHERE monitor_id = 2 AND status = 1;");
$stmt->execute();
$array = [];
foreach ($stmt->get_result() as $row)
{
    $array[] = $row['url_id'];
}

foreach ($array as $url_id_to_monitor) {

    $sql_url = "SELECT url FROM urls WHERE id = ".$url_id_to_monitor.";"; 
    $result1 = $conn->query($sql_url);
    $url = $conn->query($sql_url)->fetch_row()[0];
  
    // monitor
    $api = "https://charts.rivoluzioneinformatica.org/api/dns.php?url=";
    file_get_contents($api.$url);
}

$conn->close();
print_r("<br> monitor done.");

?>