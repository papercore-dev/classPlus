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
          class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
        >
          시간표</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/ftable.php');"
          class="text-gra relative flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 shadow hover:bg-white hover:text-gray-700"
        >
          급식표</a
        >
      </li>
    </ul>
  </div>


    <div class="my-4">
      <?php
      $schoolRegionCode = checkNEIS("hub/schoolInfo?SD_SCHUL_CODE=".getData("schoolSID")."&Type=json")["schoolInfo"][1]["row"][0]["ATPT_OFCDC_SC_CODE"];
      //current date in YYYYMMDD format
      $currentDate = date("Ymd");
      //7 days later date in YYYYMMDD format
      $sevenDaysLater = date("Ymd", strtotime("+1 month"));
      //get school meal data
      $mealData = checkNEIS("hub/mealServiceDietInfo?ATPT_OFCDC_SC_CODE=".$schoolRegionCode."&SD_SCHUL_CODE=".getData("schoolSID")."&MLSV_FROM_YMD=".$currentDate."&MLSV_TO_YMD=".$sevenDaysLater."&Type=json")["mealServiceDietInfo"][1]["row"];

      foreach($mealData as $day){
        $beautifiedDate = date("n월 j일", strtotime($day["MLSV_YMD"]));
        //YYYYMMDD에서 요일 추출
        $dayOfWeek = date("w", strtotime($day["MLSV_YMD"]));
        //요일 한글화
        switch($dayOfWeek){
          case 0:
            $dayOfWeek = "일요일";
            break;
          case 1:
            $dayOfWeek = "월요일";
            break;
          case 2:
            $dayOfWeek = "화요일";
            break;
          case 3:
            $dayOfWeek = "수요일";
            break;
          case 4:
            $dayOfWeek = "목요일";
            break;
          case 5:
            $dayOfWeek = "금요일";
            break;
          case 6:
            $dayOfWeek = "토요일";
            break;
        }

        if ($day["MMEAL_SC_NM"] == "조식"){
          $mealType = "아침";
        } else if ($day["MMEAL_SC_NM"] == "중식"){
          $mealType = "점심";
        } else if ($day["MMEAL_SC_NM"] == "석식"){
          $mealType = "저녁";
        }
        else{
          $mealType = $day["MMEAL_SC_NM"];
        }
        
        echo '<div class="my-5 flex items-center justify-between">
        <h4 class="text-2xl font-bold text-slate-500">'.$beautifiedDate.' '.$dayOfWeek.'</h4><p class="text-gray-500">'.$day["CAL_INFO"].'</p>
        </div>';
        //if DDISH_NM includes word in array, make it bold
        $tastyFood = array("스테이크", "고기", "빵", "요거트", "요구르트", "돈가스", "돈까스", "튀김", "볶음", "짜장", "짬뽕", "우동", "주스", "쥬스", "스무디", "라떼", "아이스크림", "떡볶이", "김밥", "케이크");
        $dishToday = $day["DDISH_NM"];
        foreach($tastyFood as $food){
          if(strpos($day["DDISH_NM"], $food) !== false){
            $dishToday = str_replace($food, "<b>".$food."</b>", $day["DDISH_NM"]);
          }
        }
        echo $mealType.'<br><br>'.$dishToday;
        if ($dayOfWeek == "금요일"){
          echo '<div class="mt-4 flex items-center justify-between">
          <span class="border-b w-1/5 lg:w-1/4"></span>
          <a href="#" class="text-xs text-center text-gray-500 uppercase">한 주 끝!</a>
          <span class="border-b w-1/5 lg:w-1/4"></span>
      </div>';
        }
      }
      ?>
</div>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>