<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function relativeTime($time){
    $time = time() - $time;
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => '년',
        2592000 => '달',
        604800 => '주',
        86400 => '일',
        3600 => '시간',
        60 => '분',
        1 => '초'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.' 전';
    }
}
?>