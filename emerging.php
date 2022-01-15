<?php

// incomplete


$api_url = "https://rules.emergingthreats.net/fwrules/emerging-IPF-ALL.rules";
$file_name = basename($api_url);    

 if (file_put_contents($file_name, file_get_contents($api_url))) { echo "File downloaded successfully"; } else
 {
     echo "File downloading failed.";
 }

die();

$file="reports/tmp_emerging";
$linecount = 0;
$handle = fopen($file, "r");
while(!feof($handle)){
  $line = fgets($handle);
  $linecount++;
}

fclose($handle);
print_r($linecount);

die();

