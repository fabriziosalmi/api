<?php

ini_set('max_execution_time', 60);

if (PHP_SAPI === 'cli') { parse_str(implode('&', array_slice($argv, 1)), $_GET); } 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { echo "<br> ".$url." is valid"; } else { die("<br> $url is invalid"); } 

/**
 * Determines if $number is between $min and $max
 *
 * @param  integer  $number     The number to test
 * @param  integer  $min        The minimum value in the range
 * @param  integer  $max        The maximum value in the range
 * @param  boolean  $inclusive  Whether the range should be inclusive or not
 * @return boolean              Whether the number was in the range
 */
function in_range($number, $min, $max, $inclusive = FALSE)
{
    if (is_int($number) && is_int($min) && is_int($max))
    {
        return $inclusive
            ? ($number >= $min && $number <= $max)
            : ($number > $min && $number < $max) ;
    }

    return FALSE;
}

// lighthouse
$domain = str_replace("https://", "", $url);
$docker_cmd = "docker run -it -v /var/www/charts.rivoluzioneinformatica.org/api/reports:/home/chrome/reports pernodricard/lighthouse-cli ".$url." --quiet --headless --output json --output-path /home/chrome/reports/".$domain.".json";
exec($docker_cmd);
$json_string = "https://charts.rivoluzioneinformatica.org/api/reports/".$domain.".json";
$string = file_get_contents($json_string);
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

$lighthouse_sum = $performance + $accessibility + $bestpractices + $seo + $pwa;
$lighthouse_scores = 5;
$lighthouse_score = $lighthouse_sum / $lighthouse_scores;

// check score
require_once("functions.php");

if ( score_check($lighthouse_score, 0, 100) === FALSE ) {
    die( "error: exiting.." );
} 

// save score
require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '6', '".$lighthouse_score ."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK " .$sql;
  } else {
    echo "UPDATE ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>