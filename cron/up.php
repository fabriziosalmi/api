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

$sql = "SELECT url FROM urls WHERE status = 1;";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

  $url_id = $row["id"];
  print_r($url_id);
  die();
  $shell_cmd = "/usr/bin/php /var/www/charts.rivoluzioneinformatica.org/api/up.php?url=".$url_id;
  
  if (!shell_exec($shell_cmd)) {
    die("<br>exec failed");
  } else {
    echo "<br> up cycle OK";
  }

}

?>