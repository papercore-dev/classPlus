<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function checkNEIS($rurl){
    $url = "https://open.neis.go.kr/".$rurl."&KEY=fd21679a15db4287abf00c19b7248998";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($output, true);
    return $json;
}