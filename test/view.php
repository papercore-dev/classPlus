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
include 'functions/purifyXSS.php';
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
<script src="
https://cdn.jsdelivr.net/npm/@tailwindcss/typography@0.5.9/src/index.min.js
"></script>

<link href="
https://cdn.jsdelivr.net/npm/@tailwindcss/typography@0.5.9/dist/typography.min.css
" rel="stylesheet">
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
<div class="inline-flex mt-2 items-center rounded-md shadow-sm">
            <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-blue-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                  </svg>
                  </span>
            </button>
            <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-blue-100 border border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>                      
                </span>
            </button>
            <button class="text-slate-800 hover:text-red-600 text-sm bg-white hover:bg-red-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                  </svg>
                  </span>
            </button></div>

            </div>
            
            <div class="px-5 w-full mx-auto">
            <article class="prose my-5 overflow-x-hidden lg:prose-xl">
                <?php
$postContentPurified = purifyXSS($postData["postContent"]);

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
</article>
            </div>


        </div>
        <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">


  <div class="max-w-2xl mx-auto px-4">
   

    <?php
    //if ( == 0){

            $getCommentQuery = "SELECT * FROM posts_comments WHERE postID = ".$_GET["id"]." AND commentHidden = 0 ORDER BY commentCreation DESC";
            $getCommentQuery_Result = $db->query($getCommentQuery);

            echo '   <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">
                댓글 <span class="text-gray-600 dark:text-gray-400">'.$getCommentQuery_Result->rowCount().'</span>개
            </h2>
        </div>';

        
                while ($commentData = $getCommentQuery_Result->fetch()){
                    $getCommentUserQuery = "SELECT * FROM account_users WHERE userID = '".$commentData["userID"]."' AND signMethod = '".$commentData["signMethod"]."'";
                    $getCommentUserQuery_Result = $db->query($getCommentUserQuery);
                    $commentUserData = $getCommentUserQuery_Result->fetch();

                    
                    echo'
                    <article class="p-2 text-base bg-white border-b border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
<footer class="flex justify-between items-center mb-2">
<div class="flex items-center">
<p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"><img class="mr-2 w-6 h-6 rounded-full"
src="'.$commentUserData["userAvatar"].'" alt="avatar"><span>'.$commentUserData["userNick"];

if ($commentUserData["schoolSID"] == $_SESSION["schoolSID"]){
    echo " (".$commentUserData["userName"].")";
}
echo '&nbsp;·&nbsp;<span class="text-blue-500">';
$getWriterSchool = "SELECT * FROM `school_whitelisted` WHERE `schoolSID` = '".$commentUserData["schoolSID"]."'";
    $getWriterSchool_Result = $db->query($getWriterSchool);
    if ($getWriterSchool_Result->rowCount() == 0){
        echo "학교 정보 없음";
    }
    else{
        while($row = $getWriterSchool_Result->fetch()){
            echo $row["schoolName"];
        }
}

echo '</span></p>
<p class="text-sm text-gray-600 dark:text-gray-400">'.relativeTime(strtotime($commentData["commentCreation"])).'</p>
</div>
</footer>
<div class="text-gray-900 dark:text-white">
<p>'.purifyXSS($commentData["commentContent"]).'</p>
</div>
</article>
                    ';
                }
            ?>

        <nav class="rounded-t-xl shadow-lg commentSection max-w-md visible fixed bottom-0 w-full border bg-white">

<form>
<label for="chat" class="sr-only">Your message</label>
<div class="flex w-full items-center py-2 px-3 bg-gray-50 rounded-lg dark:bg-gray-700">
    
    
    <input id="chat" rows="1" class="block mr-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="댓글을 작성하세요">
        <button type="submit" class="inline-flex justify-center p-2 text-blue-500 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
    </button>
</div>
</form>



</nav>

<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
