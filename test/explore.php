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
include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));

$serviceName = "boardexplore";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
?>
<?php
//check if POST's search is set
if (isset($_POST['search'])){
    $search = $_POST['search'];
    //only accept A-Z, a-z, Korean, 0-9, and space
    if (!preg_match("/^[가-힣a-zA-Z0-9 ]*$/", $search)){
        $search = "";
    }
}
else{
    $search = "";
}
?>
<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">
    <?php
    if ($search == ""){
        echo "탐색";
    }
    else{
        echo $search." 검색 결과";
    }
    ?>
</h4>
</div>

<form action="/explore.php" method="post">   
        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
        <div class="relative">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="search"     <?php
    if ($search == ""){
        echo "value=''";
    }
    else{
        echo "value='".$search."'";
    }
    ?> id="search" name="search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="검색" required>
        </div>
</form>

<?php
    if ($search == ""){
        echo'
<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">

<div class="flex justify-between items-center mb-2 mt-4">
<h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><span class="tossface">🏫</span>&nbsp;우리 학교 게시판</h3>
</div>
<div class="flow-root">
<ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">';
    $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." AND `schoolSID` = '".getData("schoolSID")."' ORDER BY `visitCount` DESC";
    $maxDisplayRank = 9999;
    include 'functions/listRank.php';
    chdir(dirname(__FILE__));
echo'
</ul>
  </div>

          <div class="flex justify-between items-center mb-2 mt-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><span class="tossface">🔥</span>&nbsp;인기 급상승 게시판</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">';
            $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." ORDER BY `visitCount` DESC";
            $maxDisplayRank = 10;
            include 'functions/listRank.php';
            chdir(dirname(__FILE__));
    echo'
        </ul>
          </div>

          <div class="flex justify-between items-center mb-2 mt-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><span class="tossface">✨</span>&nbsp;새로 나온 게시판</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">';
            $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." ORDER BY `boardID` DESC";
            $maxDisplayRank = 10;
            include 'functions/listRank.php';
            chdir(dirname(__FILE__));
            echo'

        </ul>
          </div>
        </div>
</section>';
    }
    else{
        echo'
        <div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
        <div class="flex justify-between items-center mb-2 mt-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">게시판</h3>
   </div>
           <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">';
                    $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." AND `boardName` LIKE '%".$search."%' ORDER BY `visitCount` DESC";
                    $maxDisplayRank = 9999;
                    include 'functions/listRank.php';
                    chdir(dirname(__FILE__));
                    echo'
                    </ul>
                      </div>
                    </div>';
                    echo'
                    <div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
                    <div class="flex justify-between items-center mb-2 mt-4">
                    <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">글</h3>
               </div>
                       <div class="text-black dark:text-gray-50 block w-full">';
                    //search title and content
                    $getPostList = "SELECT * FROM `posts` WHERE `postHidden` = '0' AND (`postTitle` LIKE '%".$search."%' OR `postContent` LIKE '%".$search."%') ORDER BY `visitCount` DESC";
                    include 'functions/listPost.php';
                    chdir(dirname(__FILE__));
                    echo'
                    </div>
            </section>';
    }
?>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
