<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/menu.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));
include 'functions/timeToRelative.php';
chdir(dirname(__FILE__));

//ID 검증
if (!isset($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=글이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=글이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

$getPostData = "SELECT * FROM `posts` WHERE postID = '".$_GET["id"]."' AND postHidden = '0'";
$getPostData_Result = $db->query($getPostData);
if ($getPostData_Result->rowCount() == 0){
    echo "<script>window.location.href = '/explore.php?error=글이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
else{
    while($row1 = $getPostData_Result->fetch()){
    $postData = $row1;
    $getBoardID = "SELECT * FROM `posts_board` WHERE `boardID` = ".$row1["boardID"]." AND boardHidden = '0' AND view_accessLevel <= '".$_SESSION['accessLevel']."'";
    $getBoardID_Result = $db->query($getBoardID);
    if ($getBoardID_Result->rowCount() == 0){
        echo "<script>window.location.href = '/explore.php?error=글이 존재하지 않거나 삭제됐어요.';</script>";
        die;
    }
    else{
        while($row = $getBoardID_Result->fetch()){
            include 'functions/specificFunction.php';
            if ($isBannerHidden){
                echo "<script>window.location.href = '/explore.php?error=글이 존재하지 않거나 삭제됐어요.';</script>";
                die;
            }
            else{
                $headName = $row["boardName"];
                include 'ui/menu/menu.custom.html.php';
                chdir(dirname(__FILE__));
            }
        }
    }
}
}

//글 조회수 증가
$increaseViewCount = "UPDATE `posts` SET `visitCount` = `visitCount` + 1 WHERE `postID` = '".$_GET["id"]."'";
$increaseViewCount_Result = $db->query($increaseViewCount);


?>
<div class="w-full mx-auto">
            
            <div class="mt-8 w-full text-gray-800 text-2xl px-5 font-bold leading-none">
                <?php
                echo $postData["postTitle"];
                ?>
            </div>
            
            <div class="w-full text-gray-600 font-thin px-5 pt-3">
<div class="flex items-center">
<img class="object-cover object-center w-10 h-10 rounded-full" src="
<?php
    $getAuthorData = "SELECT * FROM `account_users` WHERE `userID` = '".$postData["userID"]."' AND `signMethod` = '".$postData["signMethod"]."'";
    $getAuthorData_Result = $db->query($getAuthorData);
    if ($getAuthorData_Result->rowCount() == 0){
        echo "/resources/images/fallback_profile.jpg";
    }
    else{
        while($row = $getAuthorData_Result->fetch()){
            $postUserData = $row;
            echo $row["userAvatar"];
        }
    }
?>">
<div class="mx-4">

<h1 class="text-gray-700 dark:text-gray-200"><?php echo $postUserData["userNick"];
if ($postUserData["schoolSID"] == $_SESSION["schoolSID"]){
    echo " (".$postUserData["userName"].")";
}?> · <span class="text-blue-500">
    <?php
    $getWriterSchool = "SELECT * FROM `school_whitelisted` WHERE `schoolSID` = '".$postUserData["schoolSID"]."'";
    $getWriterSchool_Result = $db->query($getWriterSchool);
    if ($getWriterSchool_Result->rowCount() == 0){
        echo "학교 정보 없음";
    }
    else{
        while($row = $getWriterSchool_Result->fetch()){
            echo $row["schoolName"];
        }
    }
    ?>
</span></h1>
<h1 class="text-gray-700 text-xs dark:text-gray-200"><?php
//$postData["postCreation"] is in datetime. We need to convert it to YYYY년 MM월 DD일 HH시 MM분 SS초 format using php's date function.
echo date("Y년 m월 d일 H:i:s", strtotime($postData["postCreation"]));
?>
</h1>
</div>
</div>
            </div>
            
            <div class="px-5 w-full mx-auto">
                <p class="my-5">
                <?php
$postContentPurified = $postData["postContent"];

$postContentPurified = str_replace("<", "&lt;", $postContentPurified);
$postContentPurified = str_replace(">", "&gt;", $postContentPurified);
$postContentPurified = str_replace("'", "&#39;", $postContentPurified);
$postContentPurified = str_replace('"', "&quot;", $postContentPurified);
$postContentPurified = str_replace("`", "&#96;", $postContentPurified);
$postContentPurified = str_replace("\\", "&#92;", $postContentPurified);

$postContentPurified = nl2br($postContentPurified);

$ytEmbedPrefix = '<iframe width="560" height="315" src="https://www.youtube.com/embed/';
$ytEmbedSuffix = '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" class="w-full h-auto rounded-lg" allowfullscreen=""></iframe>';
//extract youtube video ID from URL until there is no more youtube URL
while (strpos($postContentPurified, "https://www.youtube.com/watch?v=") !== false){
    $youtubeURL = substr($postContentPurified, strpos($postContentPurified, "https://www.youtube.com/watch?v="), 43);
    $youtubeID = substr($youtubeURL, 32, 11);
    $postContentPurified = str_replace($youtubeURL, $ytEmbedPrefix.$youtubeID.$ytEmbedSuffix, $postContentPurified);
}
while (strpos($postContentPurified, "https://youtu.be/") !== false){
    $youtubeURL = substr($postContentPurified, strpos($postContentPurified, "https://youtu.be/"), 43);
    $youtubeID = substr($youtubeURL, 17, 11);
    $postContentPurified = str_replace($youtubeURL, $ytEmbedPrefix.$youtubeID.$ytEmbedSuffix, $postContentPurified);
}
while (strpos($postContentPurified, "https://m.youtube.com/watch?v=") !== false){
    $youtubeURL = substr($postContentPurified, strpos($postContentPurified, "https://m.youtube.com/watch?v="), 43);
    $youtubeID = substr($youtubeURL, 32, 11);
    $postContentPurified = str_replace($youtubeURL, $ytEmbedPrefix.$youtubeID.$ytEmbedSuffix, $postContentPurified);
}
echo $postContentPurified;
?>
<img src="<?php
echo $postData["postAttachment"];
?>" class="rounded-xl bg-gray-500 mt-2">
</p>
            </div>


        </div>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
