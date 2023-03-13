<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include '../functions/checkUserData.php';
chdir(dirname(__FILE__));
include '../functions/timeToRelative.php';
chdir(dirname(__FILE__));

if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
}
else{
    echo "<script>alert('접근 권한이 없어요.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}
$headName = "급식 진동벨";
include '../ui/menu/menu.dash.html.php';
?>
<div class="p-5 lg:ml-64">
<div class="my-4">

<div class="my-5 flex items-center justify-between">
<h4 class="text-2xl text-slate-500"><span class="font-bold"><?php echo $_SESSION["userName"];?></span>님</h4>
<p class="text-gray-500"><?php echo $_SESSION["schoolName"];?></p>
</div>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">🔔</span>오늘 호명 현황</h4>
</div>

<?php
//show current invites in table
if ($_SESSION["accessLevel"] == 5) {
    $currentInviteUsage = "SELECT * FROM `mealbell`";
}
else {
    //get meal bell log from user's schoolSID and limit result to today
    $currentInviteUsage = "SELECT * FROM `mealbell` WHERE `schoolSID` = '".$_SESSION["schoolSID"]."' AND `calledTime` >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
}
$currentInviteUsageResult = $db->query($currentInviteUsage);
if ($currentInviteUsageResult->rowCount() > 0) {
    echo "<table class='table-auto w-full text-xs'>";
    echo "<thead>";
    echo "<tr>";
    if ($_SESSION["accessLevel"] == 5) {
    echo "<th class='px-4 py-2'>학교코드</th>";
    }
    
    echo "<th class='px-4 py-2'>학년</th>";
    echo "<th class='px-4 py-2'>반</th>";
    echo "<th class='px-4 py-2'>시간</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = $currentInviteUsageResult->fetch()) {
        echo "<tr>";
        if ($_SESSION["accessLevel"] == 5) {
            echo "<td class='border px-4 py-2'>".$row["schoolSID"]."</td>";
            
        }
        echo "<td class='border px-4 py-2'>".$row["schoolGrade"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["schoolClass"]."</td>";
        $calledToTime = strtotime($row['calledTime']);
    $getRelativeCalled = relativeTime($calledToTime);
         echo "<td class='border px-4 py-2'>".$getRelativeCalled."</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
else {
    echo "<p>호명 기록이 없어요.</p>";
}
?>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">✨</span>호명하기</h4>
</div>
<form action="bellGenerate.php" method="post">
<div class="flex flex-col gap-2">
    <?php
    if ($_SESSION["accessLevel"] == 5){
echo '<label for="schoolSID">나이스 학교코드</label>
<input type="text" name="schoolSID" id="schoolSID" class="border rounded-md px-2 py-1" value="'.$_SESSION["schoolSID"].'" />';
    }
    ?>
<label for="schoolGrade">학년</label>
<input type="number" name="schoolGrade" id="schoolGrade" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />
<label for="schoolClass">반</label>
<input type="number" name="schoolClass" id="schoolClass" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />
</div>
<button type="submit" class="bg-blue-500 text-white rounded-md px-2 py-1">호명하기</button>
</form>


</div>
</div>
<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
