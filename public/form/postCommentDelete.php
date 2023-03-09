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
if (!isset($_GET["commentID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_GET["commentID"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

//get comment author
$getCommentAuthor = "SELECT * FROM `posts_comments` WHERE commentID = '".$_GET["commentID"]."' AND commentHidden = '0'";
$getCommentAuthor_Result = $db->query($getCommentAuthor);
if ($getCommentAuthor_Result->rowCount() == 0){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
else{
    while($row = $getCommentAuthor_Result->fetch()){
        $commentAuthor = $row["userID"];
    }
}

//if author is user or user is admin
if ($_SESSION["userID"] == $commentAuthor || $_SESSION["accessLevel"] >= 4){
//update post to be hidden
$postToDB = "UPDATE `posts_comments` SET `commentHidden` = '1' WHERE `commentID` = '".$_GET["commentID"]."'";
//post to database and redirect to newly created post
if ($db->query($postToDB)){
    echo "<script>window.location.href = '/list.php?error=댓글을 삭제했어요.';</script>";
    die;
}
else{
    echo "<script>window.location.href = '/list.php?error=글 삭제에 실패했어요.';</script>";
    die;
}
}
else{
    echo "<script>window.location.href = '/list.php?error=글 삭제에 실패했어요.';</script>";
    die;
}
?>
</body>
</html>