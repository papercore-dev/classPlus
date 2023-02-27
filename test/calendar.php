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
?>
<?php
//show this month's calendar
function showCalendar($month, $year){
    $firstDay = mktime(0,0,0,$month, 1, $year);
    $title = date('F', $firstDay);
    $dayOfWeek = date('D', $firstDay);
    $daysInMonth = cal_days_in_month(0, $month, $year);
    $blank = date('w', strtotime("{$year}-{$month}-01"));
    $dayCount = 1;
    $today = date('Y-m-d');
    $calendar = "<table class='table-auto w-full'>
    <tr>
    <th colspan='7' class='text-center text-xl font-bold text-gray-900 dark:text-white'>$title $year</th>
    </tr>
    <tr>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Sun</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Mon</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Tue</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Wed</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Thu</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Fri</td>
    <td class='w-1/7 text-center text-lg font-bold text-gray-900 dark:text-white'>Sat</td>
    </tr>
    <tr>";
    $calendar .= "<td colspan='$blank'>&nbsp;</td>";
    while($dayCount <= $daysInMonth){
        $calendar .= "<td class='text-center text-lg font-bold text-gray-900 dark:text-white'>";
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
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>