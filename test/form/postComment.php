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
include '../functions/sendNotification.php';
chdir(dirname(__FILE__));
//check if method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
//ID 검증
if (!isset($_POST["postID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_POST["postID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

//get board id from post id
$getBoardID = "SELECT boardID FROM `posts` WHERE postID = '".$_POST["postID"]."' AND postHidden = '0'";
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

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0' AND comment_accessLevel <= '".$_SESSION['accessLevel']."'";
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


if (!isset($_POST["chat"])){
    echo "<script>window.location.href = '/view.php?id=".$_POST["id"]."&error=내용을 입력해주세요.';</script>";
    die;
}

$purifiedPost = purifyXSS($_POST["chat"]);
//if chat is empty
if (empty($purifiedPost)){
    echo "<script>window.location.href = '/view.php?id=".$_POST["id"]."&error=내용을 입력해주세요.';</script>";
    die;
}
//post to database
$postToDB = "INSERT INTO `posts_comments` (`postID`, `userID`, `commentContent`, `signMethod`) VALUES ('".$_POST["postID"]."', '".$_SESSION["userID"]."', '".$purifiedPost."', '".$_SESSION["signMethod"]."')";
//post to database and redirect to newly created post
if ($db->query($postToDB)){
    $getNewPostID = "SELECT * FROM `posts_comments` WHERE postID = '".$_POST["postID"]."' AND userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."' ORDER BY commentCreation DESC LIMIT 1";
    $getNewPostID_Result = $db->query($getNewPostID);
    if ($getNewPostID_Result->rowCount() == 0){
        echo "<script>window.location.href = '/view.php?id=".$row["postID"]."&error=댓글 작성에 실패했어요.';</script>";
            die;
    }
    else{
        while($row = $getNewPostID_Result->fetch()){
            echo "<script>window.location.href = '/view.php?id=".$row["postID"]."&error=댓글이 성공적으로 작성됐어요.';</script>";
            //send notification to OP
            $getOP = "SELECT * FROM `posts` WHERE postID = '".$row["postID"]."'";
            $getOP_Result = $db->query($getOP);
            if ($getOP_Result->rowCount() == 0){
                echo "<script>window.location.href = '/view.php?id=".$row["postID"]."&error=댓글 작성에 실패했어요.';</script>";
                die;
            }
            else{
                while($row2 = $getOP_Result->fetch()){
                    if ($row2["userID"] != $_SESSION["userID"]){
                            while($row3 = $getOPData_Result->fetch()){
                                $getOPSignMethod = $row3["signMethod"];
                                $getOPUserID = $row3["userID"];
                                $getOPTitle = "SELECT * FROM `posts` WHERE postID = '".$row["postID"]."'";
                                $getOPTitle_Result = $db->query($getOPTitle);
                                if ($getOPTitle_Result->rowCount() == 0){
                                    echo "<script>window.location.href = '/view.php?id=".$row["postID"]."&error=댓글 작성에 실패했어요.';</script>";
                                    die;
                                }
                                else{
                                    while($row4 = $getOPTitle_Result->fetch()){
                                        $getOPTitle = $row4["postTitle"];
                                    }
                                }

                                sendNotification($getOPUserID, $getOPSignMethod, "💬 '".$getOPTitle."' 에 올라온 새 댓글", $purifiedPost, "", "", $db);
                            }
            die;
        }
    }
}
        }
    }
}

?>
</body>
</html>