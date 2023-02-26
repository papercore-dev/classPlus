<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
chdir(dirname(__FILE__));
requireSignin("/onboarding");

if (isset($_SESSION["schoolSID"])){
    if ($_SESSION["schoolSID"] == null){
    }
    else{
    echo "{\"error\": \"이미 학생 인증이 완료되었어요.\"}";
    die;
    }
}
else{
}

if (!isset($data["code"])){
    echo "{\"error\": \"인증 코드가 없어요.\"}";
    die;
}

$purifiedCode = $data["code"];
if (preg_match("/[^0-9a-zA-Z]/", $purifiedCode) and strlen($purifiedCode) == 6){
    $findPrevInviteRecord = "SELECT * FROM `account_invites` WHERE `inviteCode` = '".$purifiedCode."' AND `used` = 0";
    $findPrevInviteRecord_Result = $db->query($findPrevInviteRecord);
    
    if ($findPrevInviteRecord_Result->rowCount() > 0){
        while($row = $findPrevInviteRecord_Result->fetch()){
            $TBA_schoolClass = $row["schoolClass"];
            $TBA_schoolGrade = $row["schoolGrade"];
            $TBA_schoolSID = $row["schoolSID"];
            $TBA_schoolNo = $row["schoolNo"];
            $TBA_userName = $row["userName"];

            $updateInviteCode = "UPDATE `account_invites` SET `used` = 1 WHERE `inviteCode` = '".$purifiedCode."'";
            $updateInviteCode_Result = $db->query($updateInviteCode);

            $updateUserData = "UPDATE `account_users` SET (`schoolClass`, `schoolGrade`, `schoolSID`, `schoolNo`, `userName`) = ('".$TBA_schoolClass."', '".$TBA_schoolGrade."', '".$TBA_schoolSID."', '".$TBA_schoolNo."', '".$TBA_userName."') WHERE `userID` = '".$_SESSION["userID"]."' AND `signMethod` = '".$_SESSION["signMethod"]."'";
            $updateUserData_Result = $db->query($updateUserData);

            $_SESSION["schoolClass"] = $TBA_schoolClass;
            $_SESSION["schoolGrade"] = $TBA_schoolGrade;
            $_SESSION["schoolSID"] = $TBA_schoolSID;
            $_SESSION["schoolNo"] = $TBA_schoolNo;
            $_SESSION["userName"] = $TBA_userName;

            echo "{\"success\": \"인증이 완료되었어요.\"}";
        }
    }
    else{
        echo "{\"error\": \"옳지 않은 인증 코드에요.\"}";
        die;
    }
}
else{
    echo "{\"error\": \"코드를 다시 한번 확인해보세요.\"}";
    die;
}
?>