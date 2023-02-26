<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function checkVariable($varName, $varCheck){
    if (isset($varName)){
        if ($varName == $varCheck){
            return true;
        }
    }
    return false;
}
?>