<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    $checkInviteCode = "SELECT * FROM `invite` WHERE inviteCode = '".$CinviteCode."' AND used = '0'";
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

$sendInviteData = "INSERT INTO `account_invite` (`inviteCode`, `schoolSID`, `schoolGrade`, `schoolClass`, `schoolNo`, `userName`, `used`) VALUES ('".$inviteCode."', '".$_SESSION["schoolSID"]."', '".$_SESSION["schoolGrade"]."', '".$_SESSION["schoolClass"]."', '".$inviteSchoolNo."', '".$inviteUserName."', '0')";
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
