<?php

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
                $backURL = "/list.php?id=".$row["boardID"];
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
<?php
//if user's accessLevel is 5 or user is the author of the post, show edit button.
if ($_SESSION["accessLevel"] == 5 || $_SESSION["userID"] == $postData["userID"]){
    echo'
<div class="inline-flex mt-2 items-center rounded-md shadow-sm">
<a href="/edit.php?id='.$_GET["id"].'">
            <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-blue-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                  </svg>
                  </span>
            </button>
            </a>
            <a href="/form/postPin.php?postID='.$_GET["id"].'">
            <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-blue-100 border border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
</svg>
       
                </span>
            </button>
            </a>
            <a href="javascript:deleteConfirmPost('.$_GET["id"].')">
            <button class="text-slate-800 hover:text-red-600 text-sm bg-white hover:bg-red-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                  </svg>
                  </span>
            </button>
            </a></div>';
}
?>
            </div>

            <div class="px-5 w-full mx-auto">
            <article class="prose my-5 overflow-x-hidden lg:prose-xl">
                <?php
$postContentPurified = $postData["postContent"];

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
        <?php
        //get row count of posts_like using PDO
        $getLikeCount = $db->prepare("SELECT COUNT(*) FROM posts_like WHERE postID = :postID");
        $getLikeCount->bindParam(":postID", $_GET["id"]);
        $getLikeCount->execute();
        $likeCount = $getLikeCount->fetchColumn();

            echo '<div class="px-5 w-full mx-auto">
            <div class="flex flex-row justify-between items-center">
            <div class="flex flex-row space-x-2 items-center">
            <a href="/form/postLike.php?postID='.$_GET["id"].'">
            <button class="text-gray-800 rounded-md hover:text-red-600 text-sm bg-white hover:bg-red-100 border border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                ';
                //if user has liked the post, show filled heart icon
                $checkLike = "SELECT * FROM `posts_like` WHERE postID = '".$_GET["id"]."' AND userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."'";
                $checkLike_Result = $db->query($checkLike);

                if ($checkLike_Result->rowCount() > 0){
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
<path d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.977a11.969 11.969 0 00-.831 4.398 12 12 0 00.52 3.507c.26.85 1.084 1.368 1.973 1.368H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 01-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227z" />
</svg>';
                }
                else{
                    echo ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                  </svg>';
                }


            echo'
                    </span>
                    <span class="text-xs">좋아요</span>
                </button>
                </a>
                    </div>
                    <div class="flex flex-row space-x-2 items-center">
                    <span class="text-xs text-slate-800 font-medium">'.$likeCount.'개</span>
                    </div>
                    </div>
                    </div>';
        ?>
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
';
if ($commentUserData["userID"] == $_SESSION["userID"] && $commentUserData["signMethod"] == $_SESSION["signMethod"]){
echo '<a href="javascript:deleteConfirmComment('.$commentData["commentID"].')"><p class="text-sm text-red-400 ml-2">삭제하기</p></a>';
}
else if ($_SESSION["accessLevel"] >= 4){
    echo '<a href="javascript:deleteConfirmComment('.$commentData["commentID"].')"><p class="text-sm text-red-400 ml-2">삭제하기</p></a>';
}
echo '
</div>
</footer>
<div class="text-gray-900 dark:text-white">
<p>'.$commentData["commentContent"].'</p>
</div>
</article>
                    ';
                }
            ?>

            </div>
    <script>
        function deleteConfirmComment(id){
            showModal("댓글 삭제", "정말로 이 댓글을 삭제할까요?", "삭제", "/form/postCommentDelete.php?commentID="+id, "취소", "#");
        }
        function deleteConfirmPost(id){
            showModal("게시글 삭제", "정말로 이 게시글을 삭제할까요?", "삭제", "/form/postDelete.php?postID="+id, "취소", "#");
        }
        </script>
            <nav class="rounded-t-xl shadow-lg commentSection max-w-md visible fixed bottom-0 w-full border bg-white">

<form action="/form/postComment.php" method="POST">
<label for="chat" class="sr-only">댓글을 작성하세요</label>
<div class="flex w-full items-center py-2 px-3 bg-gray-50 rounded-lg dark:bg-gray-700">

<input type="hidden" name="postID" value="<?php echo $_GET["id"]; ?>">
<input id="chat" name="chat" required rows="1" class="block mr-2 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="댓글을 작성하세요">
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
