#!/usr/bin/env php
<?php
/**
 * @file
 * APCU Cache Nagios Plugin.
 *
 */
 
$host = $argv[1];
 
# variables
$output = "OK";
$port=80;
$warning=30;
$critical=10;
$debug = 0;
# code return : 0=OK, 1=WARN, 2=CRIT, 3=UNKNOWN
$retcode=3;
 
 
# get the answer from the php APC page
$url = "http://" . $host . ":" . $port . "/nagios-apc/apc_stats.php";

$results = file_get_contents($url) or die("server is not responding");
$results = unserialize($results);
 
# compute ratio
if ($results["nhits"] > 0) {
    $hit_ratio=($results["nhits"]/($results["nhits"]+$results["nmisses"]))*100;
} else {
    $hit_ratio=0;
}
 
if ($hit_ratio >= $warning){
    $output = "OK|";
    $retcode=0;
} else if ($critical >= $warning) {
    $output = "WARNING|";
    $retcode=1;
} else {
    $output = "CRITICAL|";
    $retcode=2;
}

print $results["nhits"] . " / " . $results["nmisses"] . " = $hit_ratio";
$output = $output . "hit_ratio=" . $hit_ratio . "\n";
print($output);
?>
