<?php

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
<a href='javascript:showModal("확인", "정말로 로그아웃 할 건가요?", "로그아웃", "javascript:Turbo.visit(`/oauth/logout.php`);", "", "#");'>
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
<div class="flex justify-between items-center mb-2 mt-4">
<h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><span class="tossface">☺️</span>&nbsp;여러분 덕분입니다</h3>
</div>
<ul>
        <li><strong>Class+ v1.0.1-dev</strong></li>
        <li>이 서비스는 여러분들의 의견을 통해 만들어졌어요.</li>
        <li><strong>대표</strong> : 등대 (유한선)</li>
        <li><strong>개발자</strong> : 만원 </li>
        <li><strong>테스터</strong> : 토끼, 우유, 멌지다, 703 (한인승), 321PLEK</li>
        <li><strong>그리고...</strong> : <?php echo getData('userName'); ?> (<?php echo getData('userID'); ?>)</li>
</ul>
</div>
</section>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>