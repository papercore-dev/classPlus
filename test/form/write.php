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
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
//ID 검증
if (!isset($_POST["boardURL"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_POST["boardURL"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

$serviceName = $_POST["boardURL"];

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0' AND write_accessLevel <= '".$_SESSION['accessLevel']."'";
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

if (!isset($_POST["title"])){
    echo "<script>window.location.href = '/form/write.php?boardURL=".$serviceName."&error=제목을 입력해주세요.';</script>";
    die;
}

if (!isset($_POST["post"])){
    echo "<script>window.location.href = '/form/write.php?boardURL=".$serviceName."&error=내용을 입력해주세요.';</script>";
    die;
}

$purifiedTitle = purifyXSS($_POST["title"]);
$purifiedTitle = str_replace("\r", "", $purifiedTitle);
$purifiedTitle = str_replace("\n", "", $purifiedTitle);
//make title to be within 100 characters
if (strlen($purifiedTitle) > 100){
    $purifiedTitle = substr($purifiedTitle, 0, 100);
}
$purifiedPost = purifyXSS($_POST["post"]);

//check if imageURL is valid imgbb URL using regex (https://i.ibb.co/(A-Z, a-z, 0-9 7 letters)/post-upload*)
if (isset($_POST["imageURL"])){
    if (!empty($_POST["imageURL"]) and !preg_match("/https:\/\/i\.ibb\.co\/[A-Za-z0-9]{7}\/post-upload.*/", $_POST["imageURL"])){
        echo "<script>window.location.href = '/form/write.php?id=".$serviceName."&error=이미지 URL이 올바르지 않아요.';</script>";
        die;
    }
    else{
        $purifiedImageURL = $_POST["imageURL"];
    }
}
else{
    $purifiedImageURL = "";
}

if (empty($purifiedTitle)){
    echo "<script>window.location.href = '/form/write.php?id=".$serviceName."&error=내용을 입력해주세요.';</script>";
    die;
}
if (empty($purifiedPost)){
    echo "<script>window.location.href = '/form/write.php?id=".$serviceName."&error=내용을 입력해주세요.';</script>";
    die;
}
//post to database
$postToDB = "INSERT INTO `posts` (`postID`, `signMethod`, `userID`, `postTitle`, `postContent`, `postAttachment`, `postCreation`, `visitCount`, `postHidden`, `postNotice`, `boardID`) VALUES (NULL, '".$_SESSION["signMethod"]."', '".$_SESSION["userID"]."', '".$purifiedTitle."', '".$purifiedPost."', '".$purifiedImageURL."', current_timestamp(), '0', '0', '0', '".$_POST["boardURL"]."');";
//post to database and redirect to newly created post
if ($db->query($postToDB)){
    $getNewPostID = "SELECT * FROM `posts` WHERE boardID = '".$_POST["boardURL"]."' AND userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."' ORDER BY postID DESC LIMIT 1";
    $getNewPostID_Result = $db->query($getNewPostID);
    if ($getNewPostID_Result->rowCount() == 0){
        echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
        die;
    }
    else{
        while($row = $getNewPostID_Result->fetch()){
            echo "<script>window.location.href = '/view.php?id=".$row["postID"]."&error=게시글이 성공적으로 작성됐어요.';</script>";
            die;
        }
    }
}
else{
    echo "<script>window.location.href = '/form/write.php?id=".$serviceName."&error=게시글 작성에 실패했어요.';</script>";
    die;
}
?>
</body>
</html>