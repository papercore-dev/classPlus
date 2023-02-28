<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

if (isset($serviceName)){
    $checkPreviousVisit = "SELECT * FROM `account_boardAnalytics` WHERE `userID` = '".$_SESSION['userID']."' AND `signMethod` = '".$_SESSION['signMethod']."' AND `serviceName` = '".$serviceName."'";
    $checkPreviousVisit_Result = $db->query($checkPreviousVisit);

    if ($checkPreviousVisit_Result->rowCount() > 0){
        while($row = $checkPreviousVisit_Result->fetch()){
            $updateServiceAnalytics = "UPDATE `account_boardAnalytics` SET `visitCount` = `visitCount` + 1 WHERE `userID` = '".$_SESSION['userID']."' AND `signMethod` = '".$_SESSION['signMethod']."' AND `boardID` = '".$serviceName."'";
            $updateServiceAnalytics_Result = $db->query($updateServiceAnalytics);
        }
    } else {
        $insertServiceAnalytics = "INSERT INTO `account_boardAnalytics` (`userID`, `signMethod`, `boardID`, `visitCount`) VALUES ('".$_SESSION['userID']."', '".$_SESSION['signMethod']."', '".$serviceName."', 1)";
        $insertServiceAnalytics_Result = $db->query($insertServiceAnalytics);
    }
}

$updateBoardAnalytics = "UPDATE `posts_board` SET `visitCount` = `visitCount` + 1 WHERE `boardID` = '".$serviceName."'";
?>