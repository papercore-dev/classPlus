<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));

include '../functions/purifyXSS.php';
chdir(dirname(__FILE__));
if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
}
else{
    echo "<script>alert('접근 권한이 없어요.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "사용자 관리";
include '../ui/menu/menu.custom.html.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
//ID 검증
if (!isset($_POST["schoolNo"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["schoolNo"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
} 
if (!isset($_POST["userName"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["userID"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["signMethod"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}

$inviteCode = rand(0, 999999);
$inviteCode = str_pad($inviteCode, 6, "0", STR_PAD_LEFT);

function checkInviteCode($CinviteCode, $database){
    $checkInviteCode = "SELECT * FROM `account_invite` WHERE inviteCode = '".$CinviteCode."' AND used = '0'";
    $checkInviteCode_Result = $database->query($checkInviteCode);
    if ($checkInviteCode_Result->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}


$inviteSchoolNo = $_POST["schoolNo"];
$inviteUserName = $_POST["userName"];
$inviteUserName = purifyXSS($inviteUserName);

if ($_SESSION["accessLevel"] == "5"){
    if (!isset($_POST["schoolSID"])){
        $inviteSchoolSID = $_SESSION["schoolSID"];
    }
    else{
        $inviteSchoolSID = $_POST["schoolSID"];
    }

    if (!isset($_POST["schoolGrade"])){
        $inviteSchoolGrade = $_SESSION["schoolGrade"];
    }
    else{
        $inviteSchoolGrade = $_POST["schoolGrade"];
    }

    if (!isset($_POST["schoolClass"])){
        $inviteSchoolClass = $_SESSION["schoolClass"];
    }
    else{
        $inviteSchoolClass = $_POST["schoolClass"];
    }
}
else{
    $inviteSchoolSID = $_SESSION["schoolSID"];
    $inviteSchoolGrade = $_SESSION["schoolGrade"];
    $inviteSchoolClass = $_SESSION["schoolClass"];
}

$searchUserData = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_POST["signMethod"]."' AND `userID` = '".$_POST["userID"]."'";
$searchUserData_Result = $db->query($searchUserData);
if ($searchUserData_Result->rowCount() > 0){
    //update user data to invite
    $searchUserData_Data = $searchUserData_Result->fetch();
    $updateUserData = "UPDATE `account_users` SET `schoolNo` = '".$inviteSchoolNo."', `schoolSID` = '".$inviteSchoolSID."', `schoolGrade` = '".$inviteSchoolGrade."', `schoolClass` = '".$inviteSchoolClass."', `userName` = '".$inviteUserName."' WHERE `account_users`.`userID` = '".$_POST["userID"]."' AND `account_users`.`signMethod` = '".$_POST["signMethod"]."'";
$updateUserData_Result = $db->query($updateUserData);

if ($updateUserData_Result){
    echo "<script>window.location.href = '/dashboard/userManage.php?error=사용자를 활성화시켰어요.';</script>";
    die;
}
else{
        echo "<script>window.location.href = '/dashboard/userManage.php?error=그런 사용자가 없어요.';</script>";
    die;
}
}
else{
    echo "<script>window.location.href = '/dashboard/userManage.php?error=그런 사용자가 없어요.';</script>";
    die;
}

?>

<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
