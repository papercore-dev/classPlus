<?php

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
          href="javascript:Turbo.visit('/calendar.php', { action: 'replace' });"
          class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
        >
          캘린더</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/timetable.php', { action: 'replace' });"
          class="text-gra relative flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 shadow hover:bg-white hover:text-gray-700"
        >
          시간표</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/ftable.php', { action: 'replace' });"
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
      }
      else if (getData("schoolSID") == "7751187" and getData("schoolGrade").getData("schoolClass") == "21" ){
        //show timetable image
        echo "<img src='https://media.discordapp.net/attachments/936620635889729558/1083032104453013564/image.png?width=576&height=814' class='w-full'>";
        
      }
      else if ($schoolType == "중학교") {
       //get schoolSCD from school_whitelisted
       $getSchoolSCD = "SELECT schoolSCD FROM school_whitelisted WHERE schoolSID = '".getData("schoolSID")."'";
       //get data via PDO
        $getSchoolSCD = $db->query($getSchoolSCD)->fetch();
        //get schoolSCD
        $schoolSCD = $getSchoolSCD["schoolSCD"];
       $schoolGrade = getData("schoolGrade");
        $schoolClass = getData("schoolClass");

        $firstMonday = date("Ymd", strtotime("monday this week"));
        $lastFriday = date("Ymd", strtotime("friday this week"));
        $timetable = checkNEIS("hub/misTimetable?Type=json&ATPT_OFCDC_SC_CODE=".$schoolSCD."&SD_SCHUL_CODE=".getData("schoolSID")."&GRADE=".$schoolGrade."&CLASS_NM=".$schoolClass."&TI_FROM_YMD=".$firstMonday."&TI_TO_YMD=".$lastFriday);
        $timetable = $timetable["misTimetable"][1]["row"];
        
        //parse timetable
        $timetableParsed = array();
        foreach ($timetable as $key => $value) {
          $timetableParsed[$value["ITRT_CNTNT"]] = array(
            "day" => $value["ALL_TI_YMD"],
            "time" => $value["PERIO"],
            "subject" => $value["ITRT_CNTNT"]
          );
        }
        //show timetableparsed in form of table
        echo "<table class='w-full border border-gray-100 bg-gray-50 p-1'>";
        echo "<tr><th>시간</th><th>월요일</th><th>화요일</th><th>수요일</th><th>목요일</th><th>금요일</th></tr>";
        for ($i=1; $i <= 6; $i++) { 
          echo "<tr>";
          echo "<td>".$i."교시</td>";
          for ($j=1; $j <= 5; $j++) { 
            //get this weeks $j th day in YYYYMMDD format
            $thisDay = date("Ymd", strtotime("monday this week +".($j-1)." days"));

            echo "<td>";
            foreach ($timetableParsed as $key => $value) {
              if ($value["day"] == $thisDay and $value["time"] == $i) {
                echo $value["subject"];
              }
            }
            echo "</td>";
          }
          echo "</tr>";
        }
        echo "</table>";
        
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