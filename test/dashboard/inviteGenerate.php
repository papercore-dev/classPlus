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
$headName = "초대 관리";
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

while (checkInviteCode($inviteCode, $db)){
    $inviteCode = rand(0, 999999);
    $inviteCode = str_pad($inviteCode, 6, "0", STR_PAD_LEFT);
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
$sendInviteData = "INSERT INTO `account_invite` (`inviteCode`, `schoolSID`, `schoolGrade`, `schoolClass`, `schoolNo`, `userName`, `used`) VALUES ('".$inviteCode."', '".$inviteSchoolSID."', '".$inviteSchoolGrade."', '".$inviteSchoolClass."', '".$inviteSchoolNo."', '".$inviteUserName."', '0')";
$sendInviteData_Result = $db->query($sendInviteData);

if ($sendInviteData_Result){
    echo "<script>window.location.href = '/dashboard/inviteManage.php?error=초대 코드가 생성되었어요.';</script>";
    die;
}
else{
    echo "<script>window.location.href = '/dashboard/inviteManage.php?error=초대 코드 생성에 실패했어요.';</script>";
    die;
}
?>

<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
