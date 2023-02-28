<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

$getPostList_Result = $db->query($getPostList);

while($row = $getPostList_Result->fetch()){
include 'specificFunction.php';
if(!$isBannerHidden){
    echo '
    <a href="javascript:Turbo.visit(`/view.php?id='.$row['postID'].'`)">
    <div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
    <strong>'.$row["postTitle"].'</strong>
    <p class="text-gray-500"></p>
    </div>
</a>';
}
}
?>