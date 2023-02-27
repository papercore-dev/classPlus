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
<div class="my-4">
<?php
//show this month's calendar
function showCalendar($month, $year){
    $firstDay = mktime(0,0,0,$month, 1, $year);
    $title = date('M', $firstDay);
    $dayOfWeek = date('D', $firstDay);
    $daysInMonth = cal_days_in_month(0, $month, $year);
    $blank = date('w', strtotime("{$year}-{$month}-01"));
    $dayCount = 1;
    $today = date('Y-m-d');
    $calendar = "<table class='table-auto w-full'>
    <tr>
    <th colspan='7' class='text-center text-xl font-bold text-gray-900 dark:text-white'>$year년 $title월</th>
    </tr>
    <tr>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>일</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>월</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>화</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>수</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>목</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>금</td>
    <td class='w-1/7 text-center text-lg  text-gray-900 dark:text-white'>토</td>
    </tr>
    <tr>";
    $calendar .= "<td colspan='$blank'>&nbsp;</td>";
    while($dayCount <= $daysInMonth){
        $calendar .= "<td class='text-center text-lg  text-gray-900 dark:text-white'>";
        if($dayCount == date('d') && $month == date('m') && $year == date('Y')){
            $calendar .= "<div class='bg-blue-500 rounded-full w-8 h-8 flex items-center justify-center text-white'>$dayCount</div>";
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

showCalendar(2, 2023);
?>
</div>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>