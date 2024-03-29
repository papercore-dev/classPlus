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
if (!isset($_POST["inviteCode"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
//check if inviteCode is 7 length and is numeric
if (strlen($_POST["inviteCode"]) != 7 or !is_numeric($_POST["inviteCode"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}

$inviteCode = substr($_POST["inviteCode"], 0, 6);
$used = substr($_POST["inviteCode"], 6, 1);

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

$deleteInviteCode = "DELETE FROM `account_invite` WHERE inviteCode = '".$inviteCode."' AND used = '".$used."' AND schoolSID = '".$inviteSchoolSID."' AND schoolGrade = '".$inviteSchoolGrade."' AND schoolClass = '".$inviteSchoolClass."'";
    $deleteInviteCode_Result = $db->query($deleteInviteCode);
    if ($deleteInviteCode_Result){
        echo "<script>window.location.href = '/dashboard/inviteManage.php?error=삭제했어요.';</script>";
        die;
    }
    else{
        echo "<script>window.location.href = '/dashboard/inviteManage.php?error=삭제에 실패했어요.';</script>";
        die;
    }
?>

<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
