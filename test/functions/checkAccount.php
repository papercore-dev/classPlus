<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function checkAccount(){
    if (isset($_SESSION['userID'])){
            return true;
    }
    return false;
}

function requireSignin($target, $accessLevel=2){
        if (!checkAccount()){
            echo "<script>window.location.href = '/oauth?redirect=".$target."';</script>";
            die;
        }
}

function requireStdVerification(){
    if (isset($_SESSION['schoolSID'])){
        if ($_SESSION['schoolSID'] == null){
        echo "<script>window.location.href = '/onboarding/kyc.php';</script>";
        die;
        }
    }
    else{
        echo "<script>window.location.href = '/onboarding/kyc.php';</script>";
        die;
    }
}
?>