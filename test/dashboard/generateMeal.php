<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));
include '../functions/sendNotification.php';
chdir(dirname(__FILE__));
include '../functions/purifyXSS.php';
chdir(dirname(__FILE__));
if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
}
else{
    echo "<script>alert('접근 권한이 없습니다.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "급식 진동벨";
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

if ($_SESSION["accessLevel"] == "5"){
    if (!isset($_POST["schoolSID"])){
        $inviteSchoolSID = $_SESSION["schoolSID"];
    }
    else{
        $inviteSchoolSID = $_POST["schoolSID"];
    }
}
else{
    $inviteSchoolSID = $_SESSION["schoolSID"];
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

$getTargetStudents = "SELECT * FROM `account_users` WHERE schoolSID = '".$inviteSchoolSID."' AND schoolGrade = '".$inviteSchoolGrade."' AND schoolClass = '".$inviteSchoolClass."' AND accType = 'student'";
$getTargetStudents_Result = $db->query($getTargetStudents);

while ($getTargetStudents_Row = $getTargetStudents_Result->fetch(PDO::FETCH_ASSOC)){
    //send notification to target via sendNotification()
    sendNotification($getTargetStudents_Row["userID"], $getTargetStudents_Row["signMethod"], $inviteSchoolGrade."-".$inviteSchoolClass." 학생들의 급식 순서! 😋", "급식 차례가 되었어요. 어서 먹으러 가 볼까요? 🏃‍♂️🏃‍♀️", "https://classplus.pcor.me/resources/images/bell.png", "https://classplus.pcor.me/dashboard/meal", $db);
}

//log to mealbell table
$mealBellLog = "INSERT INTO `mealbell` (`schoolSID`, `schoolGrade`, `schoolClass`) VALUES ('".$inviteSchoolSID."', '".$inviteSchoolGrade."', '".$inviteSchoolClass."')";
$mealBellLog_Result = $db->query($mealBellLog);

echo "<script>window.location.href = '/dashboard/callMeal.php?error=발송에 성공했어요';</script>";
?>

<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
