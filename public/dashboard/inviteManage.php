<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));
if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
}
else{
    echo "<script>alert('접근 권한이 없어요.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "초대 관리";
include '../ui/menu/menu.dash.html.php';
?>
<div class="p-5 lg:ml-64">
<div class="my-4">

<div class="my-5 flex items-center justify-between">
<h4 class="text-2xl text-slate-500"><span class="font-bold"><?php echo $_SESSION["userName"];?></span>님</h4>
<p class="text-gray-500"><?php echo $_SESSION["schoolName"];?></p>
</div>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">💌</span>초대 코드 현황</h4>
</div>

<?php
//show current invites in table
if ($_SESSION["accessLevel"] == 5) {
    $currentInviteUsage = "SELECT * FROM `account_invite`";
}
else {
    $currentInviteUsage = "SELECT * FROM `account_invite` WHERE `schoolSID` = '".$_SESSION["schoolSID"]."' AND `schoolGrade` = '".$_SESSION["schoolGrade"]."' AND `schoolClass` = '".$_SESSION["schoolClass"]."'";
}
$currentInviteUsageResult = $db->query($currentInviteUsage);
if ($currentInviteUsageResult->rowCount() > 0) {
    echo "<table class='table-auto w-full text-xs'>";
    echo "<thead>";
    echo "<tr>";
    if ($_SESSION["accessLevel"] == 5) {
    echo "<th class='px-4 py-2'>학교코드</th>";
    echo "<th class='px-4 py-2'>학년</th>";
    echo "<th class='px-4 py-2'>반</th>";
    }
    echo "<th class='px-4 py-2'>번호</th>";
    echo "<th class='px-4 py-2'>이름</th>";
    echo "<th class='px-4 py-2'>초대 코드</th>";
    echo "<th class='px-4 py-2'>초대 사용 여부</th>";
    echo "<th class='px-4 py-2'>수정</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = $currentInviteUsageResult->fetch()) {
        echo "<tr>";
        if ($_SESSION["accessLevel"] == 5) {
            echo "<td class='border px-4 py-2'>".$row["schoolSID"]."</td>";
            echo "<td class='border px-4 py-2'>".$row["schoolGrade"]."</td>";
            echo "<td class='border px-4 py-2'>".$row["schoolClass"]."</td>";
        }
        echo "<td class='border px-4 py-2'>".$row["schoolNo"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["userName"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["inviteCode"]."</td>";
        if ($row["used"] == 1) {
            echo "<td class='border px-4 py-2'>사용됨</td>";
        }
        else {
            echo "<td class='border px-4 py-2'>미사용</td>";
        }
        echo "<td class='border px-4 py-2'>
        <form action='inviteDelete.php' method='post'>
        <input type='hidden' name='inviteCode' value='".$row["inviteCode"].$row["used"]."' />
        <input type='hidden' name='schoolSID' value='".$row["schoolSID"]."' />
        <input type='hidden' name='schoolGrade' value='".$row["schoolGrade"]."' />
        <input type='hidden' name='schoolClass' value='".$row["schoolClass"]."' />
        <input type='hidden' name='schoolNo' value='".$row["schoolNo"]."' />
        <button type='submit' class='bg-red-500 text-white rounded-md px-2 py-1'>삭제</button>
        </form>
        </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
else {
    echo "<p>초대 코드가 없어요.</p>";
}
?>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">✨</span>신규 초대 코드 생성</h4>
</div>
<form action="inviteGenerate.php" method="post">
<div class="flex flex-col gap-2">
    <?php
    if ($_SESSION["accessLevel"] == 5){
echo '<label for="schoolSID">나이스 학교코드</label>
<input type="text" name="schoolSID" id="schoolSID" class="border rounded-md px-2 py-1" value="'.$_SESSION["schoolSID"].'" />';
echo '<label for="schoolGrade">학년</label>
<input type="number" name="schoolGrade" id="schoolGrade" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />';
echo '<label for="schoolClass">반</label>
<input type="number" name="schoolClass" id="schoolClass" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />';
    }
    ?>
<label for="schoolNo">번호</label>
<input type="number" name="schoolNo" id="schoolNo" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />
<label for="userName">이름</label>
<input type="text" name="userName" id="userName" class="border rounded-md px-2 py-1" />
</div>
<button type="submit" class="bg-blue-500 text-white rounded-md px-2 py-1">생성</button>
</form>


</div>
</div>
<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
