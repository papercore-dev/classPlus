<?php

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
    }
}


//if user already liked the post, unlike it
$checkLike = "SELECT * FROM `posts_like` WHERE postID = '".$_GET["postID"]."' AND userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."'";
$checkLike_Result = $db->query($checkLike);

//if checkLike_Result's row count is over 0, delete the row
if ($checkLike_Result->rowCount() > 0){
    $deleteLike = "DELETE FROM `posts_like` WHERE postID = '".$_GET["postID"]."' AND userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."'";
    $deleteLike_Result = $db->query($deleteLike);
    if ($deleteLike_Result){
        echo "<script>window.location.href = '/view.php?id=".$_GET["postID"]."&error=좋아요를 취소했어요.';</script>";
        die;
    }
    else{
        echo "<script>window.location.href = '/view.php?id=".$_GET["postID"]."&error=좋아요를 취소하는데 실패했어요.';</script>";
        die;
    }
}
else{
    $addLike = "INSERT INTO `posts_like` (postID, userID, signMethod) VALUES ('".$_GET["postID"]."', '".$_SESSION["userID"]."', '".$_SESSION["signMethod"]."')";
    $addLike_Result = $db->query($addLike);

    if ($addLike_Result){
        echo "<script>window.location.href = '/view.php?id=".$_GET["postID"]."&error=좋아요했어요.';</script>";
        die;
    }
    else{
        echo "<script>window.location.href = '/view.php?id=".$_GET["postID"]."&error=좋아요를 누르는데 실패했어요.';</script>";
        die;
    }
}

?>
</body>
</html>