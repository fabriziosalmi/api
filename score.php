<?php
// require_once("conf/sentry.php");

if (PHP_SAPI === 'cli')
{
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
} 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 
  echo "<br> ".$url." is valid"; 
} else { 
  die("<br> $url is invalid"); 
} 

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = \"$url\";";
$result = $conn->query($sql);
$url_id = $result->fetch_assoc()["id"];

print_r("<br>url id: ".$url_id."<br>");

$sql_param1 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 1 ORDER BY id DESC LIMIT 1;";
$result1 = $conn->query($sql_param1);
if ($result1->num_rows > 0) { while($row = $result1->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$url_score = $score;

print_r("<br>status code: ".$url_score."<br>");

$sql_param2 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 2 ORDER BY id DESC LIMIT 1;";
$result2 = $conn->query($sql_param2);
if ($result2->num_rows > 0) { while($row = $result2->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$dns_score = $score;

print_r("<br>dns: ".$dns_score."<br>");

$sql_param3 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 3 ORDER BY id DESC LIMIT 1;";
$result3 = $conn->query($sql_param3);
if ($result3->num_rows > 0) { while($row = $result3->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$w3c_score = $score;

print_r("<br>w3c: ".$dns_score."<br>");

$sql_param4 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 4 ORDER BY id DESC LIMIT 1;";
$result4 = $conn->query($sql_param4);
if ($result4->num_rows > 0) { while($row = $result4->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$pagespeed_score = $score;

print_r("<br>pagespeed: ".$pagespeed_score."<br>");

$sql_param5 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 5 ORDER BY id DESC LIMIT 1;";
$result5 = $conn->query($sql_param4);
if ($result5->num_rows > 0) { while($row = $result5->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$headers_score = $score;

print_r("<br>headers: ".$headers_score."<br>");

$sql_param6 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 6 ORDER BY id DESC LIMIT 1;";
$result6 = $conn->query($sql_param4);
if ($result6->num_rows > 0) { while($row = $result6->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$lighthouse_score = $score;

print_r("<br>lighthouse: ".$lighthouse_score."<br>");

$sql_param7 = "SELECT score FROM checks WHERE url_id = ".$url_id." AND monitor_id = 7 ORDER BY id DESC LIMIT 1;";
$result7 = $conn->query($sql_param7);
if ($result7->num_rows > 0) { while($row = $result7->fetch_assoc()) { $score = $row["score"]; } } else { $score = $row["score"]; }
$sitespeed_score = $score;

print_r("<br>sitespeed: ".$sitespeed_score."<br>");

// sum scores - to improve with sql select result
$sum = $url_score + $dns_score + $w3c_score + $pagespeed_score + $headers_score + $lighthouse_score + $sitespeed_score;
$values=7;
$score = floatval($sum) / floatval($values);

$sql2 = "INSERT INTO scores (url_id, score) VALUES ('$url_id', '$score')";

if ($conn->query($sql2) === TRUE) {
  echo "<br> url_id: ".$url_id;
  echo "<br> Score: ".$score;
} else {
  echo "<br> Error: " . $sql2 . " - " . $conn->error;
}

mysqli_close($conn);

?>