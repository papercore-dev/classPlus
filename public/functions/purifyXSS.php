<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function purifyXSS($varName){
    $postContentPurified = $varName;

    $postContentPurified = str_replace("<", "&lt;", $postContentPurified);
    $postContentPurified = str_replace(">", "&gt;", $postContentPurified);
    $postContentPurified = str_replace("'", "&#39;", $postContentPurified);
    $postContentPurified = str_replace('"', "&quot;", $postContentPurified);
    $postContentPurified = str_replace("`", "&#96;", $postContentPurified);
    $postContentPurified = str_replace("\\", "&#92;", $postContentPurified);
    
    $postContentPurified = nl2br($postContentPurified);
    return $postContentPurified;
}
?>