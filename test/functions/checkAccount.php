<?php
chdir(dirname(__FILE__));
include '../security.php';

function checkAccount(){
    if (isset($_SESSION['userID'])){
        if ($_SESSION['userID']){
            return true;
        }
    }
    return false;
}

function requireSignin($target){
    if (!checkAccount()){
        echo "<script>window.location.href = '/oauth?redirect=".$target."';</script>";
        die;
    }
}
?>