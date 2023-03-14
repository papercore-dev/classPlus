<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

$serviceName = "mealbell";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<section class="p-5" id="pageContent">

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<div class="w-full items-center justify-center text-center">
<lottie-player src="https://assets10.lottiefiles.com/packages/lf20_ckff3wia.json" background="transparent" speed="1" style="width: 150px; height: 150px;" autoplay="" class="inline-block"></lottie-player>
</div>
<div class="mb-5">
<h4 class="text-2xl font-bold text-slate-500">급식 기다리지 말고<br>알림을 받아봐요</h4>
<p class="text-sm text-gray-500">어디서나 인터넷만 된다면 급식 차례가 될 때 알림을 받아볼 수 있어요.<br>
(아이폰은 16.4 버전 이상부터 사용할 수 있어요)</p>
</div>
<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
<div class="rounded-t mb-0 px-0 border-0">
<div class="text-black dark:text-gray-50 block w-full">

</div>
</div>
</div>
</section>

<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>