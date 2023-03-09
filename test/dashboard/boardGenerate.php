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
    echo "<script>alert('접근 권한이 없습니다.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "게시판 관리";
include '../ui/menu/menu.custom.html.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
//ID 검증
if (!isset($_POST["boardName"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["publicLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["write_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["comment_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!isset($_POST["manage_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}

$boardName = purifyXSS($_POST["boardName"]);
//if publiclevel is numeric
if (!is_numeric($_POST["publicLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
//if publicLevel, write_accessLevel, comment_accessLevel, manage_accessLevel is numeric
if (!is_numeric($_POST["write_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!is_numeric($_POST["comment_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if (!is_numeric($_POST["manage_accessLevel"])){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
//if publicLevel, write_accessLevel, comment_accessLevel, manage_accessLevel is between 1-5
if ($_POST["publicLevel"] < 0 || $_POST["publicLevel"] > 3){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if ($_POST["write_accessLevel"] < 1 || $_POST["write_accessLevel"] > 5){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if ($_POST["comment_accessLevel"] < 1 || $_POST["comment_accessLevel"] > 5){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}
if ($_POST["manage_accessLevel"] < 1 || $_POST["manage_accessLevel"] > 5){
    echo "<script>window.location.href = '/dashboard?error=옳지 않은 데이터';</script>";
    die;
}

$publicLevel = $_POST["publicLevel"];
$write_accessLevel = $_POST["write_accessLevel"];
$comment_accessLevel = $_POST["comment_accessLevel"];
$manage_accessLevel = $_POST["manage_accessLevel"];

if ($_SESSION["accessLevel"] == "5"){
    if (!isset($_POST["schoolSID"])){
        $inviteSchoolSID = "";
    }
    else{
        $inviteSchoolSID = $_POST["schoolSID"];
    }

    if (!isset($_POST["schoolGrade"])){
        $inviteSchoolGrade = "";
    }
    else{
        $inviteSchoolGrade = $_POST["schoolGrade"];
    }

    if (!isset($_POST["schoolClass"])){
        $inviteSchoolClass = "";
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

$sendBoardData = array(
    "boardName" => $boardName,
    "publicLevel" => $publicLevel,
    "write_accessLevel" => $write_accessLevel,
    "comment_accessLevel" => $comment_accessLevel,
    "manage_accessLevel" => $manage_accessLevel,
    "schoolSID" => $inviteSchoolSID,
    "schoolGrade" => $inviteSchoolGrade,
    "schoolClass" => $inviteSchoolClass,
    "boardHidden" => 0,
    "visitCount" => 0
);

$sendBoard = "INSERT INTO posts_board (boardName, publicLevel, write_accessLevel, comment_accessLevel, manage_accessLevel, schoolSID, schoolGrade, schoolClass, boardHidden, visitCount) VALUES (:boardName, :publicLevel, :write_accessLevel, :comment_accessLevel, :manage_accessLevel, :schoolSID, :schoolGrade, :schoolClass, :boardHidden, :visitCount)";
$sendBoard = $db->prepare($sendBoard);
$sendBoard->execute($sendBoardData);

echo "<script>window.location.href = '/dashboard?success=게시판 생성 완료';</script>";
?>

<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
