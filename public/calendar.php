<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

$serviceName = "calendar";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));
?>
<div class="p-5">
<div class="overflow-hidden rounded-xl border border-gray-100 bg-gray-50 p-1">
    <ul class="flex items-center gap-2 text-sm font-medium">
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/calendar.php', { action: 'replace' });"
          class="text-gra relative flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 shadow hover:bg-white hover:text-gray-700"
        >
          캘린더</a
        >
      </li>
      <li class="flex-1">
        <a
          href="javascript:Turbo.visit('/timetable.php', { action: 'replace' });""
          class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
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
//show this month's calendar
function showCalendar($month, $year){
    $firstDay = mktime(0,0,0,$month, 1, $year);
    $title = date('m', $firstDay);
    $dayOfWeek = date('D', $firstDay);
    $daysInMonth = cal_days_in_month(0, $month, $year);
    $blank = date('w', strtotime("{$year}-{$month}-01"));
    $dayCount = 1;
    $today = date('Y-m-d');
    $calendar = "<table class='table-auto w-full'>
    <div class='mb-5 flex items-center justify-between'>
<h4 class='text-2xl font-bold text-slate-500'>$year 년 $title 월</h4>
</div>
    <tr>
    <td class='w-1/7 text-center text-lg  text-red-500'>일</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>월</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>화</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>수</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>목</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>금</td>
    <td class='w-1/7 text-center text-lg  text-blue-500'>토</td>
    </tr>
    <tr>";
    $calendar .= "<td colspan='$blank'>&nbsp;</td>";
    while($dayCount <= $daysInMonth){
        $calendar .= "<td class='text-center text-lg  text-gray-900 dark:text-white'>";
        if($dayCount == date('d') && $month == date('m') && $year == date('Y')){
            $calendar .= "<div class='bg-blue-200 rounded-full w-8 h-8 flex items-center mx-auto justify-center text-blue-500'>$dayCount</div>";
        } else {
            $calendar .= $dayCount;
        }
        $calendar .= "</td>";
    if(($dayCount + $blank) % 7 == 0){
        $calendar .= "</tr><tr>";
    }
    $dayCount++;
    }
    $calendar .= "</tr></table>";
    echo $calendar;
}

//use showCalendar function to show this month's calendar
showCalendar(date('m'), date('Y'));
?>
</div>

<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">일정</h4><p class="text-gray-500"><span class="w-2 h-2 my-1 inline-block rounded-full bg-blue-500 mx-2"></span>기념일
<span class="w-2 h-2 my-1 inline-block rounded-full bg-green-500 mx-2"></span>학교
<span class="w-2 h-2 my-1 inline-block rounded-full bg-yellow-500 mx-2"></span>학급
<span class="w-2 h-2 my-1 inline-block rounded-full bg-red-500 mx-2"></span>개인</p>

</div>
<?php
$getCalendarData = "SELECT * FROM `calendar` ORDER BY `calendar`.`eventStart` ASC";
$getCalendarData_Result = $db->query($getCalendarData);
if ($getCalendarData_Result->rowCount() > 0){
while($row = $getCalendarData_Result->fetch()){
    include 'functions/specificFunction.php';
    
    if ($row["eventEnd"] < date("Y-m-d H:i:s")){$isBannerHidden = true;}
    if (!$isBannerHidden){
    $eventStart = date("Y-m-d H:i:s", strtotime($row["eventStart"]));
    $eventEnd = date("Y-m-d H:i:s", strtotime($row["eventEnd"]));
    $eventStart = date("Y년 m월 d일 H:i", strtotime($eventStart));
    $eventEnd = date("Y년 m월 d일 H:i", strtotime($eventEnd));
    $eventName = $row["eventName"];
    $eventColor = "blue-500";
    
    if ($row["publicLevel"] == 1){
    $eventColor = "green-500";
    }
    else if ($row["publicLevel"] == 2){
    $eventColor = "yellow-500";
    }
    else if ($row["publicLevel"] == 3){
    $eventColor = "red-500";
    }
    else{
    $eventColor = "blue-500";
    }

    echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border-l-8 border border-'.$eventColor.'">
    <strong>'.$row["eventName"].'</strong>
    <p class="text-gray-500 text-xs">'.$eventStart.' ~ '.$eventEnd.'</p>
    </div>';
    }
}}
?>
</div>

<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>