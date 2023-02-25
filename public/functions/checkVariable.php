<?php
chdir(dirname(__FILE__));
include '../security.php';

function checkVariable($varName){
    if (isset($_GET[$varName])){
        if ($_GET[$varName]){
            return true;
        }
    }
    return false;
}
?>