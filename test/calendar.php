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
<div class="my-4 p-5">
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
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>