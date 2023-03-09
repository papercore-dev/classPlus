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
    echo "<script>alert('접근 권한이 없습니다.');</script>";
    echo "<script>location.href='/app.php';</script>";
    exit;
}

$headName = "게시판 관리";
include '../ui/menu/menu.dash.html.php';
?>
<div class="p-5 lg:ml-64">
<div class="my-4">

<div class="my-5 flex items-center justify-between">
<h4 class="text-2xl text-slate-500"><span class="font-bold"><?php echo $_SESSION["userName"];?></span>님</h4>
<p class="text-gray-500"><?php echo $_SESSION["schoolName"];?></p>
</div>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">📝</span>게시판 현황</h4>
</div>

<?php
//show current invites in table
if ($_SESSION["accessLevel"] == 5) {
    $currentInviteUsage = "SELECT * FROM `posts_board`";
}
else {
    $currentInviteUsage = "SELECT * FROM `posts_board` WHERE `schoolSID` = '".$_SESSION["schoolSID"]."' AND `schoolGrade` = '".$_SESSION["schoolGrade"]."' AND `schoolClass` = '".$_SESSION["schoolClass"]."'";
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
    echo "<th class='px-4 py-2'>이름</th>";
    echo "<th class='px-4 py-2'>공개</th>";
    echo "<th class='px-4 py-2'>글쓰기Lv</th>";
    echo "<th class='px-4 py-2'>댓글Lv</th>";
    echo "<th class='px-4 py-2'>읽기Lv</th>";
    echo "<th class='px-4 py-2'>조회수</th>";
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
        echo "<td class='border px-4 py-2'>".$row["boardName"]."</td>";
        if ($row["publicLevel"] == 0) {
            echo "<td class='border px-4 py-2'>전체</td>";
        }
        else if ($row["publicLevel"] == 1) {
            echo "<td class='border px-4 py-2'>학교</td>";
        }
        else if ($row["publicLevel"] == 2) {
            echo "<td class='border px-4 py-2'>학년</td>";
        }
        else if ($row["publicLevel"] == 3) {
            echo "<td class='border px-4 py-2'>반</td>";
        }
        else{
            echo "<td class='border px-4 py-2'>비공개</td>";
        }
        echo "<td class='border px-4 py-2'>".$row["write_accessLevel"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["comment_accessLevel"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["view_accessLevel"]."</td>";
        echo "<td class='border px-4 py-2'>".$row["visitCount"]."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
else {
    echo "<p>만든 게시판이 없어요.</p>";
}
?>

<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500"><span class="tossface">✨</span>신규 게시판</h4>
</div>
<form action="boardGenerate.php" method="post">
<div class="flex flex-col gap-2">
    <?php
    if ($_SESSION["accessLevel"] == 5){
echo '<label for="schoolSID">나이스 학교코드</label>
<input type="text" name="schoolSID" id="schoolSID" class="border rounded-md px-2 py-1" />';
echo '<label for="schoolGrade">학년</label>
<input type="number" name="schoolGrade" id="schoolGrade" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />';
echo '<label for="schoolClass">반</label>
<input type="number" name="schoolClass" id="schoolClass" class="border rounded-md px-2 py-1" value="1" min="1" max="100" />';
    }
    ?>
<label for="boardName">게시판 이름</label>
<input type="text" name="boardName" id="boardName" class="border rounded-md px-2 py-1" />
<label for="publicLevel">공개 범위</label>
<select name="publicLevel" id="publicLevel" class="border rounded-md px-2 py-1">
<option value="0">전체</option>
<option value="1">학교</option>
<option value="2">학년</option>
<option value="3">반</option>
</select>
<label for="write_accessLevel">글쓰기 권한</label>
<input type="number" name="write_accessLevel" id="write_accessLevel" class="border rounded-md px-2 py-1" value="1" min="1" max="5" />
<label for="comment_accessLevel">댓글 권한</label>
<input type="number" name="comment_accessLevel" id="comment_accessLevel" class="border rounded-md px-2 py-1" value="1" min="1" max="5" />
<label for="manage_accessLevel">글읽기 권한</label>
<input type="number" name="manage_accessLevel" id="manage_accessLevel" class="border rounded-md px-2 py-1" value="1" min="1" max="5" />
<p>* 권한 안내<br>
1: 비로그인 <br>
2: 학생인증 마침<br>
3: 학급회장<br>
4: 학교 관리자<br>
5: 전교 관리자
</p>
</div>
<button type="submit" class="bg-blue-500 text-white rounded-md px-2 py-1">생성</button>
</form>


</div>
</div>
<?php
chdir(dirname(__FILE__));
include '../ui/common/footer.html.php';

?>
