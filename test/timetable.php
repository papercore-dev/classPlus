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
include 'functions/checkNEIS.php';
chdir(dirname(__FILE__));

$serviceName = "timetable";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<div class="p-5">
<div class="overflow-hidden rounded-xl border border-gray-100 bg-gray-50 p-1">
    <ul class="flex items-center gap-2 text-sm font-medium">
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/calendar.php');"
          class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
        >
          캘린더</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/timetable.php');"
          class="text-gra relative flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 shadow hover:bg-white hover:text-gray-700"
        >
          시간표</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/ftable.php');"
          class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
        >
          급식표</a
        >
      </li>
    </ul>
  </div>


    <div class="my-4">
      <?php
      $schoolType = checkNEIS("hub/schoolInfo?SD_SCHUL_CODE=".getData("schoolSID")."&Type=json")["schoolInfo"][1]["row"][0]["SCHUL_KND_SC_NM"];
      if ($schoolType == "초등학교") {
        echo "초등학교에서는 시간표를 지원하지 않아요";
      } else if ($schoolType == "중학교" or $schoolType == "고등학교") {
       $schoolRegion = checkNEIS("hub/schoolInfo?SD_SCHUL_CODE=".getData("schoolSID")."&Type=json")["schoolInfo"][1]["row"][0]["LCTN_SC_NM"];
       //schoolRegion에서 앞 2글자만 utf 8로 가져오기 (eg: 서울특별시 -> 서울)
        $schoolRegion = mb_substr($schoolRegion, 0, 2, "UTF-8");
        echo "<h1 class='text-2xl font-bold'>".$schoolRegion." ".$schoolType." 시간표</h1>";
      }
      else{
        echo "학교 정보를 불러오는데 실패했어요";
      }

      ?>
</div>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>