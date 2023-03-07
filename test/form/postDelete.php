<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/menu.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));
include '../functions/timeToRelative.php';
chdir(dirname(__FILE__));

include '../functions/purifyXSS.php';
chdir(dirname(__FILE__));
//check if method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
//ID 검증
if (!isset($_GET["postID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_GET["postID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

//get board id from post id
$getBoardID = "SELECT boardID FROM `posts` WHERE postID = '".$_GET["postID"]."' AND postHidden = '0'";
$getBoardID_Result = $db->query($getBoardID);
if ($getBoardID_Result->rowCount() == 0){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
else{
    while($row = $getBoardID_Result->fetch()){
        $boardID = $row["boardID"];
    }
}

$serviceName = $boardID;

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0'";
$getServiceData_Result = $db->query($getServiceData);
if ($getServiceData_Result->rowCount() == 0){
    //if manage_accessLevel is 5 or userID is same as session's userID, show the page
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
            die;
}
else{
    while($row = $getServiceData_Result->fetch()){
        include '../functions/specificFunction.php';
        if ($isBannerHidden){
            echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
            die;
        }

        if ($row["manage_accessLevel"] == 5 || $row["userID"] == $_SESSION["userID"]){
        }
        else{
            echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
            die;
        }
    }
}


//update post to be hidden
$postToDB = "UPDATE `posts` SET `postHidden` = '1' WHERE `postID` = '".$_GET["postID"]."'";
//post to database and redirect to newly created post
if ($db->query($postToDB)){
    echo "<script>window.location.href = '/list.php?id=".$serviceName."&error=글을 삭제했어요.';</script>";
    die;
}
else{
    echo "<script>window.location.href = '/list.php?id=".$serviceName."&error=글 삭제에 실패했어요.';</script>";
    die;
}
?>
</body>
</html>