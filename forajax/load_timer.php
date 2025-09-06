<?php
session_start();

// Ako end_time nije postavljen
if(!isset($_SESSION["end_time"])){
    echo "00:00:00";
    exit();
}

$now = time();
$end = strtotime($_SESSION["end_time"]);
$seconds_left = $end - $now;

if($seconds_left <= 0){
    echo "00:00:00";
} else {
    $h = floor($seconds_left / 3600);
    $m = floor(($seconds_left % 3600) / 60);
    $s = $seconds_left % 60;
    echo str_pad($h,2,"0",STR_PAD_LEFT).":".str_pad($m,2,"0",STR_PAD_LEFT).":".str_pad($s,2,"0",STR_PAD_LEFT);
}
?>
