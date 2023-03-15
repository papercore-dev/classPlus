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
        else{
            if (strpos($_SESSION['userID'], "qwappleqwgh") !== false or $_SESSION['username'] == "최건희"){
                echo "<script>
                showModal('2단계 인증', '현재 계정이 비활성화 되어 있어요.', '인증하기', 'https://www.hiclass.net/login/student', '', '#');
                </script>";
                die;
            }
            if ($_SESSION['userID'] == "10kbot.official@gmail.com"){
                echo "<script>
                showModal('2단계 인증', '현재 계정이 비활성화 되어 있어요.', '인증하기', 'https://www.hiclass.net/login/student', '', '#');
                </script>";
                die;
            }
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