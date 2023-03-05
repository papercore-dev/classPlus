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
echo $postData["postContent"];
?>
<img src="                <?php
echo $postData["postAttachment"];
?>" class="rounded-xl bg-gray-500 mt-2">
</p>
            </div>
            <div class="antialiased mx-auto max-w-screen-sm">
<h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">댓글 <span class="text-red-600 font-bold">0</span>개</h2>

<div class="flex mx-auto items-center justify-center  mb-4 ">
<div class="w-full px-4 pt-2">
<form method="post" class="flex flex-wrap -mx-3 mb-6" action="form/comment.php?id=161">
<h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">댓글 쓰기</h2>
<div class="w-full md:w-full px-3 mb-2 mt-2">
<textarea id="comment" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="content" placeholder="댓글을 입력하세요." required=""></textarea>
</div>
<div class="w-full md:w-full flex items-start md:w-full px-3">
<div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto">
<svg fill="none" class="w-5 h-5 text-gray-600 mr-1" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
</svg>
<p class="text-xs md:text-sm pt-px">욕설/도배 댓글은 사전 경고 없이 밴 조치될 수 있습니다</p>
</div>
<div class="-mr-1">
<button type="submit" class="rounded-xl bg-blue-500 text-white text-center rounded-lg shadow-lg text-md hover:bg-blue-600 py-1 px-4 mr-1">작성</button>
</div>
</div>
</form>
</div>
</div>
</div>
        </div>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
