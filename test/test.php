<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

$serviceName = "chat";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'sendNotification.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<?php
sendNotification($_SESSION["userID"], $_SESSION["signMethod"], "🔑 계정 로그인 확인", "로그인이 확인되었어요. 본인의 활동이 맞는지 확인해주세요.", "", "", $db);
?>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>