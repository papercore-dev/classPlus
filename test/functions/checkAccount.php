<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));
include '../database/adapter_db.php';
chdir(dirname(__FILE__));

function checkAccount(){
    if (isset($_SESSION['userID'])){
            return true;
    }
    return false;
}

function requireSignin($target){
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

function getData($target){
    if ($target == "schoolName"){
        $getWhitelistData = "SELECT * FROM `school_whitelisted` WHERE schoolSID = '".$_SESSION['schoolSID']."'";
        $getWhitelistData_Result = $db->query($getWhitelistData);
        if ($getWhitelistData_Result->rowCount() > 0){
        while($row = $getWhitelistData_Result->fetch()){
            return $row['schoolName'];
        }
    }
    else{
        return null;
    }
    }
    else{
    if (isset($_SESSION[$target])){
        return $_SESSION[$target];
    }
    else{
        return null;
    }
}
}
?>