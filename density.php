<?php

$time_scores = array();
$pop_dinc = 250000;
$sup_ddec = 1;
$pop = 9000000000;
$sup = 148939063;
$now = time(); // or your date as well
$your_date = strtotime("2022-01-01");
$datediff = $now - $your_date;
$days = round($datediff / (60 * 60 * 24));
$pop_increase = $pop_dinc * $days;
$sup_increase = $sup_ddec * $days;
$pop = $pop + $pop_increase;
$sup = $sup - $sup_increase;
$pop_km2 = $pop / $sup;

// yet another catastrophic
if ( $pop_km2 < 10 ) { $score_density = 10; }
if ( $pop_km2 >= 10 ) { $score_density = 20; }
if ( $pop_km2 >= 20 ) { $score_density = 30; }
if ( $pop_km2 >= 30 ) { $score_density = 40; }
if ( $pop_km2 >= 40 ) { $score_density = 50; }
if ( $pop_km2 >= 50 ) { $score_density = 40; }
if ( $pop_km2 >= 60 ) { $score_density = 30; }
if ( $pop_km2 >= 70 ) { $score_density = 20; }
if ( $pop_km2 >= 80 ) { $score_density = 10; }
if ( $pop_km2 >= 90 ) { $score_density = 5; }
if ( $pop_km2 > 100 ) { $score_density = 1; }

echo "<pre>";
$time_scores["density"] = $score_density;

// left
$max_pop = 100000000000;
$left_pop = $max_pop / $pop;
$score_left_pop = 100 - $left_pop;
$time_scores["left"] = $score_left_pop;


// random stuff
$rand1 = random_int(1,10); 
$rand2 = random_int(1,10);
$rand3 = random_int(1,10);
$rand4 = random_int(1,10);
$rand5 = random_int(1,10);
$rand6 = random_int(1,10);
$rand7 = random_int(1,10);
$rand8 = random_int(1,10);
$rand9 = random_int(1,10);
$rand10 = random_int(1,10);
$random = $rand1 + $rand2 + $rand3 + $rand4 + $rand5 + $rand6 + $rand7 + $rand8 + $rand9 + $rand10;
$time_scores["random"] = $random;

// oil
$oil_max = 1450000;
$oil_day = 100;
$oil_increase = $oil_day * $days;
$oil_available = $oil_max - $oil_increase;
$oil_left = ( $oil_available / $oil_max ) * 100 ;
$time_scores["oil"] = $oil_left;

$time_scores_mid = $time_scores["density"] + $time_scores["left"] + $time_scores["random"] + $time_scores["oil"];
$time_scores["mid"] = $time_scores_mid / 4;

print_r($time_scores);