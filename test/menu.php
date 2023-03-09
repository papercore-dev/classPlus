<?php

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
?>
<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">전체</h4>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">내 정보</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <a href="javascript:Turbo.visit(`/profile.php`)">
            <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="<?php echo getData('userAvatar'); ?>" alt="avatar" onerror="if (this.src != '/resources/images/fallback_profile.jpg') this.src = '/resources/images/fallback_profile.jpg';">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        내 정보
                        </p>
                    </div>
                </div>
            </li>
            </a>
            <?php
            if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
            echo'
            <a href="javascript:Turbo.visit(`/dashboard`)">
            <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 text-3xl tossface">
                    ⚙️
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        우리 반 관리하기
                        </p>
                    </div>
                </div>
            </li>
            </a>';
        }
        ?>
        </ul>
          </div>
          <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">서비스</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php
            $getCommunityList = "SELECT * FROM `services` WHERE `servicePublic`= 1";
            $getCommunityList_Result = $db->query($getCommunityList);

            while($row = $getCommunityList_Result->fetch()){
                echo '
                <a href="javascript:Turbo.visit(`'.$row['serviceLink'].'`)">
                <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 text-3xl tossface">
                    '.$row['serviceEmoji'].'
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        '.$row['serviceNick'].'
                        </p>
                    </div>
                </div>
            </li>
            </a>';
            }
            ?>

        </ul>
          </div>
        </div>
</section>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
