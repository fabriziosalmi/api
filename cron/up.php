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

foreach ($array as $url_id_to_monitor) {

    $sql_url = "SELECT url FROM urls WHERE id = ".$url_id_to_monitor.";"; 
    $result1 = $conn->query($sql_url);
    $url = $conn->query($sql_url)->fetch_row()[0];
  
    // monitor
    $shell_cmd = '/usr/bin/php -f /var/www/charts.rivoluzioneinformatica.org/api/up.php \"url='.$url.'\"';
    var_dump($shell_cmd);
    shell_exec($shell_cmd);

}

$conn->close();
print_r("<br> monitor done.");

?>