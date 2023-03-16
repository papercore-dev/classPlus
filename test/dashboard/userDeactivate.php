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
if (!isset($_POST["userID"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["signMethod"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}

//if user's accessLevel is under 5, find from their schoolSID and schoolGrade, schoolClass
if (getData('accessLevel') < 5){
    $searchUserData = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_POST["signMethod"]."' AND `userID` = '".$_POST["userID"]."' AND `schoolSID` = '".getData('schoolSID')."' AND `schoolGrade` = '".getData('schoolGrade')."' AND `schoolClass` = '".getData('schoolClass')."'";
}
else{
    $searchUserData = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_POST["signMethod"]."' AND `userID` = '".$_POST["userID"]."'";
}
$searchUserData_Result = $db->query($searchUserData);
if ($searchUserData_Result->rowCount() > 0){
    //update user data to invite
    $searchUserData_Data = $searchUserData_Result->fetch();
    //delete any schoolSID, schoolNo, schoolName, schoolGrade, schoolClass
    $updateUserData = "UPDATE `account_users` SET `schoolSID` = NULL, `schoolNo` = NULL, `schoolName` = NULL, `schoolGrade` = NULL, `schoolClass` = NULL WHERE `signMethod` = '".$_POST["signMethod"]."' AND `userID` = '".$_POST["userID"]."'";
$updateUserData_Result = $db->query($updateUserData);

if ($updateUserData_Result){
    echo "<script>window.location.href = '/dashboard/userManage.php?error=사용자를 비활성화시켰어요.';</script>";
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
