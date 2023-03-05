<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));
include '../functions/timeToRelative.php';
chdir(dirname(__FILE__));

$getPostList_Result = $db->query($getPostList);

if ($getPostList_Result->rowCount() == 0){
}
else{
while($row = $getPostList_Result->fetch()){
    echo '
    <a href="javascript:Turbo.visit(`/view.php?id='.$row['postID'].'`)">
    <div class="my-1 bg-red-50 dark:bg-gray-600 hover:bg-red-100 dark:hover:bg-gray-700 p-2 rounded-lg border">
<span class="bg-red-200 text-red-500 px-2 rounded mr-2">공지</span>
<strong>'.$row["postTitle"].'</strong>
</div>
</a>';
}
}
?>