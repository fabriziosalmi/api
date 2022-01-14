<?php

$api_url = "https://rules.emergingthreats.net/fwrules/emerging-IPF-ALL.rules";

 // Use basename() function to return the base name of file
 $file_name = basename($api_url);
      
 // Use file_get_contents() function to get the file
 // from url and use file_put_contents() function to
 // save the file by using base name
 if (file_put_contents($file_name, file_get_contents($api_url)))
 {
     echo "File downloaded successfully";
 }
 else
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
echo $linecount;

print_r($linecount);

