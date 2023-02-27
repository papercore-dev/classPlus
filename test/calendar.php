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

$serviceName = "calendar";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<div class="p-5">
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

<div class='mb-5 flex items-center justify-between'>
<h4 class='text-2xl font-bold text-slate-500'>일정</h4>
</div>
<?php
$getCalendarData = "SELECT * FROM `calendar` ORDER BY `calendar`.`eventStart` DESC";
$getCalendarData_Result = $db->query($getCalendarData);
if ($getCalendarData_Result->rowCount() > 0){
while($row = $getCalendarData_Result->fetch()){
    $isBannerHidden = false;
    if ($row["publicLevel"] == 0){}
    else if ($row["publicLevel"] == 1){if($row["schoolSID"] === getData("schoolSID")){}else{$isBannerHidden = true;}}
    else if ($row["publicLevel"] == 2){if($row["schoolSID"] === getData("schoolSID") and $row["schoolGrade"] === getData("schoolGrade")){if($row["schoolClass"] === getData("schoolClass")){}else{$isBannerHidden = true;}}else{$isBannerHidden = true;}}

    if ($row["eventEnd"] < date("Y-m-d H:i:s")){$isBannerHidden = true;}
    if (!$isBannerHidden){
    $eventStart = date("Y-m-d H:i:s", strtotime($row["eventStart"]));
    $eventEnd = date("Y-m-d H:i:s", strtotime($row["eventEnd"]));
    $eventStart = date("Y년 m월 d일 H시 i분", strtotime($eventStart));
    $eventEnd = date("Y년 m월 d일 H시 i분", strtotime($eventEnd));
    $eventName = $row["eventName"];

    echo "<div class='bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-4'>
    <div class='flex items-center justify-between'>
    <div class='flex items-center'>
    <div class='text-xl font-bold text-gray-900 dark:text-white'>$eventName</div>
    </div>
    </div>
    <div class='mt-4'>
    <div class='text-gray-600 dark:text-gray-400'>$eventStart ~ $eventEnd</div>
    </div>
    </div>";
    }
}}
?>
</div>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>