<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));
include '../functions/timeToRelative.php';
chdir(dirname(__FILE__));

$getPostList_Result = $db->query($getPostList);

if ($getPostList_Result->rowCount() == 0){
    echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
    <p class="text-gray-500">게시물이 없어요</p>
    </div>';
}
else{
while($row = $getPostList_Result->fetch()){
    $getCommentCount = "SELECT * FROM `posts_comments` WHERE `postID` = '".$row['postID']."' AND `commentHidden` = '0'";
    $getCommentCount_Result = $db->query($getCommentCount);
    $commentCount = $getCommentCount_Result->rowCount();
    $getLikeCount = "SELECT * FROM `posts_like` WHERE `postID` = '".$row['postID']."'";
    $getLikeCount_Result = $db->query($getLikeCount);
    $likeCount = $getLikeCount_Result->rowCount();

    $postCreationToTime = strtotime($row['postCreation']);
    $getRelativePostCreation = relativeTime($postCreationToTime);

    echo '
    <a href="javascript:Turbo.visit(`/view.php?id='.$row['postID'].'`)">
    <div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
    <strong>'.$row["postTitle"].'</strong><span class="ml-1 text-blue-500">['.$commentCount.']</span>
    <p class="text-gray-500">'.$getRelativePostCreation.' | 조회 '.$row["visitCount"].' | 좋아요 '.$likeCount.'</p>
    </div>
</a>';
}
}
?>