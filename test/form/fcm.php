<?php

$load = true;
if (session_status() === PHP_SESSION_NONE){
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
      session_start();
      ob_start();
}

$data = json_decode(file_get_contents('php://input'), true);

include '../functions/checkVariable.php';
chdir(dirname(__FILE__));
include '../database/adapter_db.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
include '../functions/purifyXSS.php';
chdir(dirname(__FILE__));
requireSignin("/onboarding");

if (!isset($_POST["token"])){
    echo "{\"error\": \"토큰이 없어요.\"}";
    die;
}

$purifiedToken = $_POST["token"];
$purifiedToken = purifyXSS($purifiedToken);
//check if purifiedToken is valid firebase FCM token using regex
$regex = "/^[a-zA-Z0-9_-]{140}$/";
if (!preg_match($regex, $purifiedToken)){
    echo "{\"error\": \"토큰이 유효하지 않아요.\"}";
    die;
}

$findPrevTokenRecord = "SELECT * FROM `account_fcm` WHERE `userID` = '".$_SESSION["userID"]."' AND `signMethod` = '".$_SESSION["signMethod"]."'";
$findPrevTokenRecord_Result = $db->query($findPrevTokenRecord);

if ($findPrevTokenRecord_Result->rowCount() > 0){
    while($row = $findPrevTokenRecord_Result->fetch()){
    $updateTokenRecord = "UPDATE FROM `account_fcm` SET `token` = '".$purifiedToken."' WHERE `userID` = '".$_SESSION["userID"]."' AND `signMethod` = '".$_SESSION["signMethod"]."'";
    $updateTokenRecord_Result = $db->query($updateTokenRecord);
    }
}
else{
    $insertTokenRecord = "INSERT INTO `account_fcm` (`userID`, `signMethod`, `token`) VALUES ('".$_SESSION["userID"]."', '".$_SESSION["signMethod"]."', '".$purifiedToken."')";
    $insertTokenRecord_Result = $db->query($insertTokenRecord);
}
echo "{\"success\": \"토큰이 등록되었어요.\"}";
?>