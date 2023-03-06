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
      //} else if ($schoolType == "중학교" or $schoolType == "고등학교") {
      } else if ($schoolType == "대학교") {
       $schoolRegion = checkNEIS("hub/schoolInfo?SD_SCHUL_CODE=".getData("schoolSID")."&Type=json")["schoolInfo"][1]["row"][0]["LCTN_SC_NM"];
       //schoolRegion에서 앞 2글자만 utf 8로 가져오기 (eg: 서울특별시 -> 서울)
        $schoolRegion = mb_substr($schoolRegion, 0, 2, "UTF-8");
        //get timetable from API running on port 8271 (http://localhost:8271/timetable/{schoolRegion}/{schoolName}/{grade}/{class})
        //url encode school name
        $schoolName = urlencode(getData("schoolName"));
        $schoolGrade = urlencode(getData("schoolGrade"));
        $schoolClass = urlencode(getData("schoolClass"));
        $schoolRegion = urlencode($schoolRegion);

        $timetable = file_get_contents("http://localhost:8271/timetable/".$schoolRegion."/".$schoolName."/".$schoolGrade."/".$schoolClass);
        $studytime = file_get_contents("http://localhost:8271/classtime/".$schoolRegion."/".$schoolName."/".$schoolGrade."/".$schoolClass);
        //if timetable or studytime connection is failed, show error message
        if ($timetable == false or $studytime == false) {
          echo "시간표를 불러오는데 실패했어요";
          exit;
        }
        //if timetable or studytime returns "Server Error" or connection is failed, show error message
        if ($timetable == "Server Error" or $studytime == "Server Error") {
          echo "시간표를 불러오는데 실패했어요";
          exit;
        }
        $timetable = json_decode($timetable, true);
        $studytime = json_decode($studytime, true);
        //create table to show timetable (get row from number of array in $timetable and get column from largest number of array in $timetable[n])
        echo "<table class='w-full table-auto border border-gray-100 bg-gray-50 p-1'>";
        echo "<tr>";
        echo "<th class='border border-blue-100 bg-gray-50 p-1'>교시</th>";
        for ($i=0; $i < count($timetable); $i++) {
          //show week of day
          $weekofday = array("월", "화", "수", "목", "금", "토", "일");
          echo "<th class='border border-blue-100 bg-gray-50 p-1'>".$weekofday[$i]."</th>";
        }
        echo "</tr>";
        for ($i=0; $i < count($timetable[0]); $i++) {
          $beautifiedTime = $studytime[$i];
          //replace ( to <br>( to beautify time
          $beautifiedTime = str_replace("(", "교시<br><span class='text-xs'>(", $beautifiedTime);
          $beautifiedTime = str_replace(")", ")</span>", $beautifiedTime);
          echo "<tr>";
          echo "<td class='border border-blue-100 bg-gray-50 p-1 text-center'>".$beautifiedTime."</td>";
          for ($j=0; $j < count($timetable); $j++) {
            echo "<td class='border border-gray-100 bg-gray-50 p-1 text-center'>".$timetable[$j][$i]["subject"]."<br>".$timetable[$j][$i]["teacher"]."</td>";
          }
          echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        

      }
      else{
        echo "나이스 api 오류로 현재 지원하지 않습니다.";
      }

      ?>
</div>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>