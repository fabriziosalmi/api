<?php

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

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
curl_setopt($ch, CURLINFO_NAMELOOKUP_TIME, true);
curl_setopt($ch, CURLINFO_CONNECT_TIME, true);

$output = curl_exec($ch);