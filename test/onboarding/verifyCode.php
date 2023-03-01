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
/*
if (isset($_SESSION["schoolSID"])){
    if ($_SESSION["schoolSID"] == null){
    }
    else{
    echo "{\"error\": \"이미 학생 인증이 완료되었어요.\"}";
    die;
    }
}
else{
}*/

if (!isset($data["code"])){
    echo "{\"error\": \"인증 코드가 없어요.\"}";
    die;
}

$purifiedCode = $data["code"];
$hiddenCode = base64_decode("65Ox64yA7Iuc67Cc7IOI64G8");
$hiddenCode = base64_decode("65Ox64yA7Iuc67Cc7IOI64G8");
$hiddenMessage = base64_decode("66ee6ri0IO2VnOuNsC4uLiDsnbTqsowg7L2U65Oc64qUIOyVhOuLjCDqsoMg6rCZ64Sk7JqULg==");

if ($purifiedCode == $hiddenCode){
    echo "{\"error\": \"".$hiddenMessage."\"}";
    die;
}
if (strlen($purifiedCode) == 6 && is_numeric($purifiedCode)){
    $findPrevInviteRecord = "SELECT * FROM `account_invite` WHERE `inviteCode` = '".$purifiedCode."' AND `used` = 0";
    $findPrevInviteRecord_Result = $db->query($findPrevInviteRecord);
    
    if ($findPrevInviteRecord_Result->rowCount() > 0){
        while($row = $findPrevInviteRecord_Result->fetch()){
            $TBA_schoolClass = $row["schoolClass"];
            $TBA_schoolGrade = $row["schoolGrade"];
            $TBA_schoolSID = $row["schoolSID"];
            $TBA_schoolNo = $row["schoolNo"];
            $TBA_userName = $row["userName"];

            $updateInviteCode = "UPDATE `account_invite` SET `used` = 1 WHERE `inviteCode` = '".$purifiedCode."'";
            $updateInviteCode_Result = $db->query($updateInviteCode);

            $updateUserData = "UPDATE `account_users` SET `schoolClass` = '".$TBA_schoolClass."', `schoolGrade` = '".$TBA_schoolGrade."', `schoolSID` = '".$TBA_schoolSID."', `schoolNo` = '".$TBA_schoolNo."', `userName` = '".$TBA_userName."' WHERE `userID` = '".$_SESSION["userID"]."'";
            $updateUserData_Result = $db->query($updateUserData);

            $_SESSION["schoolClass"] = $TBA_schoolClass;
            $_SESSION["schoolGrade"] = $TBA_schoolGrade;
            $_SESSION["schoolSID"] = $TBA_schoolSID;
            $_SESSION["schoolNo"] = $TBA_schoolNo;
            $_SESSION["userName"] = $TBA_userName;
            
            $findSchoolSCD = "SELECT * FROM `school_whitelisted` WHERE `schoolSID` = '".$_SESSION['schoolSID']."'";
            $findSchoolSCD_Result = $db->query($findSchoolSCD);
            while($row = $findSchoolSCD_Result->fetch()){
                $_SESSION['schoolSCD'] = $row['schoolSCD'];
            }

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