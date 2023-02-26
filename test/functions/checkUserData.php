<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function getData($target){
    if (isset($_SESSION[$target])){
        return $_SESSION[$target];
    }
    else{
        return null;
    }
}
?>