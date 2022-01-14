<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
echo "<pre>";


// require_once("conf/sentry.php");

if (PHP_SAPI === 'cli')

{

    parse_str(implode('&', array_slice($argv, 1)), $_GET);

} 

$url = $_GET['url'];
$url = filter_var($url, FILTER_SANITIZE_URL);

if (!filter_var($url, FILTER_VALIDATE_URL) === false) { 

  // echo "<p>valid url</p>"; 

} else { 

  die("<br> $url is invalid"); 

} 

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);

$curl_response = curl_exec($ch);

function get_headers_from_curl_response($headerContent)
{

    $headers = array();

    // Split the string on every "double" new line.
    $arrRequests = explode("\r\n\r\n", $headerContent);

    // Loop of response headers. The "count() -1" is to 
    //avoid an empty row for the extra line break before the body of the response.
    for ($index = 0; $index < count($arrRequests) -1; $index++) {

        foreach (explode("\r\n", $arrRequests[$index]) as $i => $line)
        {
            if ($i === 0)
                $headers[$index]['http_code'] = $line;
            else
            {
                list ($key, $value) = explode(': ', $line);
                $headers[$index][$key] = $value;
            }
        }
    }

    return $headers;
}

$headers_array = get_headers_from_curl_response($curl_response);
$headers_array = $headers_array[0];

// headers score "calc" :D
$curl_score = 0;

// Content-Security-Policy
if ( isset($headers_array["Content-Security-Policy"]) ) { $csp = 1; }
if ( isset($headers_array["content-security-policy"]) ) { $csp = 1; }
if ( isset($headers_array["CONTENT-SECURITY-POLICY"]) ) { $csp = 1; }
// Strict-Transport-Security
if ( isset($headers_array["Strict-Transport-Security"]) ) { $hsts = 1; }
if ( isset($headers_array["strict-transport-security"]) ) { $hsts = 1; }
if ( isset($headers_array["STRICT-TRANSPORT-SECURITY"]) ) { $hsts = 1; }
// X-Content-Type-Options
if ( isset($headers_array["X-Content-Type-Options"]) ) { $xcto = 1; }
if ( isset($headers_array["x-content-type-options"]) ) { $xcto = 1; }
if ( isset($headers_array["X-CONTENT-TYPE-OPTIONS"]) ) { $xcto = 1; }
// Expires
if ( isset($headers_array["Expires"]) ) { $expire = 1; }
if ( isset($headers_array["expires"]) ) { $expire = 1; }
if ( isset($headers_array["EXPIRES"]) ) { $expire = 1; }
// X-Frame-Options
if ( isset($headers_array["X-Frame-Options"]) ) { $xfo = 1; }
if ( isset($headers_array["x-frame-options"]) ) { $xfo = 1; }
if ( isset($headers_array["X-Frame-Options"]) ) { $xfo = 1; }
// Cache-Control
if ( isset($headers_array["Cache-Control"]) ) { $cache = 1; }
if ( isset($headers_array["cache-control"]) ) { $cache = 1; }
if ( isset($headers_array["CACHE-CONTROL"]) ) { $cache = 1; }
// Access-Control-Allow-Origin
if ( isset($headers_array["Access-Control-Allow-Origin"]) ) { $acao = 1; }
if ( isset($headers_array["access-control-allow-origin"]) ) { $acao = 1; }
if ( isset($headers_array["ACCESS-CONTROL-ALLOW-ORIGIN"]) ) { $acao = 1; }
// Set-Cookie
if ( isset($headers_array["Set-Cookie"]) ) { $setc = 1; }
if ( isset($headers_array["set-cookie"]) ) { $setc = 1; }
if ( isset($headers_array["SET-COOKIE"]) ) { $setc = 1; }
// X-XSS-Protection
if ( isset($headers_array["X-XSS-Protection"]) ) { $xxss = 1; }
if ( isset($headers_array["x-xss-protection"]) ) { $xxss = 1; }
if ( isset($headers_array["X-XSS-PROTECTION"]) ) { $xxss = 1; }
// Content-Type
if ( isset($headers_array["Content-Type"]) ) { $cc = 1; }
if ( isset($headers_array["content-type"]) ) { $cc = 1; }
if ( isset($headers_array["CONTENT-TYPE"]) ) { $cc = 1; }

curl_close($ch);

// final score :D
$curl_sum = $csp + $hsts + $xcto + $expire + $xfo + $cache + $acao + $setc + $xxss + $cc;
$curl_score = $curl_sum * 10;

// check score
require_once("functions.php");

if ( score_check($curl_score, 0, 100) === FALSE ) {
    die( "error: exiting.." );
} 

require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM urls WHERE url = '".$url."' ;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$url_id = $row["id"];
  
$sql = "INSERT INTO checks (url_id, monitor_id, score, status) VALUES ('".$url_id."', '5', '".$curl_score."', '1');";

if ($conn->query($sql) === TRUE) {
    echo "<br>OK - " .$sql;
  } else {
    echo "<br>ERROR - " . $sql . " - " . $conn->error. "<br>";
  }

mysqli_close($conn);

?>