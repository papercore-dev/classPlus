<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

$getCommunityList_Result = $db->query($getCommunityList);

$getCommunityRank = 0;

while($row = $getCommunityList_Result->fetch()){
include 'specificFunction.php';
if(!$isBannerHidden){
$getCommunityRank++;
if ($getCommunityRank == $maxDisplayRank + 1) {
    break;
}
    echo '
    <a href="javascript:Turbo.visit(`/list.php?id='.$row['boardID'].'`)">
    <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 text-3xl tossface">
        '.$getCommunityRank.'
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
            '.$row['boardName'].' 게시판
            </p>
        </div>
    </div>
</li>
</a>';
}
}
?>