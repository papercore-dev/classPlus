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

include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));

$serviceName = "boardexplore";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
?>
<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">탐색</h4>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">


          <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">HOT 게시판</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php
            $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." ORDER BY `visitCount` DESC";
            include 'functions/listRank.php';
            chdir(dirname(__FILE__));
            ?>

        </ul>
          </div>

          <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">NEW 게시판</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php
            $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardHidden` = '0' AND `view_accessLevel` <= ".getData("accessLevel")." ORDER BY `boardID` DESC";
            include 'functions/listRank.php';
            chdir(dirname(__FILE__));
            ?>

        </ul>
          </div>
        </div>
</section>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
