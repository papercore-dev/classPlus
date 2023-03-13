<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));
?>
<?php
if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
}
else{
    echo "<script>alert('접근 권한이 없어요.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "대시보드";
include '../ui/menu/menu.dash.html.php';
?>
<div class="p-5 lg:ml-64">
<div class="my-4">

<div class="my-5 flex items-center justify-between">
<h4 class="text-2xl text-slate-500"><span class="font-bold"><?php echo $_SESSION["userName"];?></span>님</h4>
<p class="text-gray-500"><?php echo $_SESSION["schoolName"];?></p>
</div>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">📂</span>교사/학생위원용 메뉴</h4>
</div>
<div class="overflow-x-scroll flex mb-5">

<a href="inviteManage.php" class="flex-none py-3 px-6">
<div class="flex flex-col items-center justify-center gap-3">
<p class="text-4xl tossface">💌</p>
<span class="text-slate-900 dark:text-slate-200">초대 관리</span>
</div>
</a>

<a href="boardManage.php" class="flex-none py-3 px-6">
<div class="flex flex-col items-center justify-center gap-3">
<p class="text-4xl tossface">📝</p>
<span class="text-slate-900 dark:text-slate-200">게시판 관리</span>
</div>
</a>

</div>


</div>
</div>
<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';
?>
