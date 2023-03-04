<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

$serviceName = "profile";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<section class="p-5">
<div class="flex flex-col items-center space-y-3">
<div class="flex items-center mt-6 justify-center">
<img class="object-cover object-center w-16 h-16 rounded-full" src="<?php echo getData('userAvatar'); ?>" alt="avatar" onerror="if (this.src != '/resources/images/fallback_profile.jpg') this.src = '/resources/images/fallback_profile.jpg';">
</div>
<span class="text-2xl font-semi-bold leading-normal"><?php echo getData('userNick'); ?> (<?php echo getData('userName'); ?>)</span>
<p class="leading-normal text-center"><?php echo getData('schoolGrade'); ?>학년 <?php echo getData('schoolClass'); ?>반 <?php echo getData('schoolNo'); ?>번 · <?php echo getData('userID'); ?></p>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">

<div class="flow-root">
<ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
</ul>
</div>
<div class="flex justify-between items-center mb-2 mt-4">
<h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><span class="tossface">⚙️</span>&nbsp;계정 설정</h3>
</div>
<div class="flow-root">
<ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
<a href="javascript:Turbo.visit(`/onboarding/editCode.php`)">
<li class="rounded-lg hover:bg-gray-200 my-1 py-2">
<div class="flex items-center space-x-4">
<div class="flex-shrink-0 text-3xl tossface">🏫</div>
<div class="flex-1 min-w-0">
<p class="text-sm font-medium text-gray-900 truncate dark:text-white">정보 수정하기</p>
</div>
</div>
</li>
</a>
<button onclick="deleteToken()">
<li class="rounded-lg hover:bg-gray-200 my-1 py-2">
<div class="flex items-center space-x-4">
<div class="flex-shrink-0 text-3xl tossface">🔔</div>
<div class="flex-1 min-w-0">
<p class="text-sm font-medium text-gray-900 truncate dark:text-white">알림 token erase</p>
</div>
</div>
</li>
</button>
<div id="permission_div" style="display: none;">
            <h4>Needs Permission</h4>
            <p id="token"></p>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                    onclick="requestPermission()">Request Permission</button>
          </div>
          <div id="messages"></div>
<button id="subscribe">
<li class="rounded-lg hover:bg-gray-200 my-1 py-2">
<div class="flex items-center space-x-4">
<div class="flex-shrink-0 text-3xl tossface">🔔</div>
<div class="flex-1 min-w-0">
<p class="text-sm font-medium text-gray-900 truncate dark:text-white">알림 받기</p>
</div>
</div>
</li>
</button>
<a href="javascript:Turbo.visit(`/oauth/logout.php`)">
<li class="rounded-lg hover:bg-gray-200 my-1 py-2">
<div class="flex items-center space-x-4">
<div class="flex-shrink-0 text-3xl tossface">🚪</div>
<div class="flex-1 min-w-0">
<p class="text-sm font-medium text-gray-900 truncate dark:text-white">로그아웃</p>
</div>
</div>
</li>
</a>
</ul>
</div>

</div>
</section>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>