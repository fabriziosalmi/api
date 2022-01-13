<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// require_once("conf/sentry.php");

if (PHP_SAPI === 'cli')

{

    parse_str(implode('&', array_slice($argv, 1)), $_GET);

} 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 

  // echo "<br> ".$url." is valid"; 

} else { 

  die("- $url is invalid - "); 

} 

// lighthouse
echo "<pre>";

// to improve
$domain = str_replace("https://", "", $url);
$json_file = dirname(__FILE__)."/reports/".$domain.".json";

// it works via php cli
$docker_cmd = "/usr/bin/docker run -it -v /var/www/charts.rivoluzioneinformatica.org/api/reports:/home/chrome/reports pernodricard/lighthouse-cli ".$url." --quiet --headless --output json --output-path /home/chrome/reports/".$domain.".json";
exec($docker_cmd);

$perm = "chown -R www-data:www-data reports/".$domain.".json";
exec($perm);
$string = file_get_contents($json_file);

// $json_string = "https://charts.rivoluzioneinformatica.org/api/reports/".$domain.".json";
// $string = file_get_contents($json_string);

var_dump($string);
die();

$json_array = json_decode($string, true);

$categories = $json_array["categories"];
$performance = $categories["performance"];
$accessibility = $categories["accessibility"];
$bestpractices = $categories["best-practices"]; 
$seo = $categories["seo"];
$pwa = $categories["pwa"];

$performance = $performance["score"];
$performance = $performance*100;
$accessibility = $accessibility["score"];
$accessibility = $accessibility*100;
$bestpractices = $bestpractices["score"];
$bestpractices = $bestpractices*100;
$seo = $seo["score"];
$seo = $seo*100;
$pwa = $pwa["score"];
$pwa = $pwa*100;

$lighthouse_score_sum = $performance + $accessibility + $bestpractices + $seo + $pwa;
$lighthouse_score_params = 5;
$lighthouse_score = $lighthouse_score_sum / $lighthouse_score_params;

var_dump($lighthouse_score);
exec("rm ".$json_file);
die("file ".$json_file. " removed. ");

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '6', '".$lighthouse_score."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK - " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>