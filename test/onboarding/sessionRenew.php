<?php

$load = true;
if (session_status() === PHP_SESSION_NONE){
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
      session_start();
      ob_start();
}

$data = json_decode(file_get_contents('php://input'), true);

include '../functions/checkVariable.php';
chdir(dirname(__FILE__));
include '../database/adapter_db.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/onboarding");


$findPrevRecord = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_SESSION['signMethod']."' AND `userID` = '".$_SESSION['userID']."'";
$findPrevRecord_Result = $db->query($findPrevRecord);  
if ($findPrevRecord_Result->rowCount() > 0){
  $updatePrevRecord = "UPDATE `account_users` SET `userNick` = '".$_SESSION['userNick']."', `userAvatar` = '".$_SESSION['userAvatar']."' WHERE `account_users`.`userID` = '".$_SESSION['userID']."' AND `account_users`.`signMethod` = '".$_SESSION['signMethod']."';";
  $updatePrevRecord_Result = $db->query($updatePrevRecord);
  while($row = $findPrevRecord_Result->fetch()){
      $_SESSION['accessLevel'] = $row['accessLevel'];
      $_SESSION['accType'] = $row['accType'];
      $_SESSION['schoolSID'] = $row['schoolSID'];
      $_SESSION['schoolGrade'] = $row['schoolGrade'];
      $_SESSION['schoolClass'] = $row['schoolClass'];
      $_SESSION['schoolNo'] = $row['schoolNo'];
      $_SESSION['userName'] = $row['userName'];
      $findSchoolSCD = "SELECT * FROM `school_whitelisted` WHERE `schoolSID` = '".$_SESSION['schoolSID']."'";
      $findSchoolSCD_Result = $db->query($findSchoolSCD);
      while($row = $findSchoolSCD_Result->fetch()){
          $_SESSION['schoolSCD'] = $row['schoolSCD'];
      }
  }
}
else{
  $insertNewRecord = "INSERT INTO `account_users` (`userID`, `userNick`, `userAvatar`, `signMethod`, `accessLevel`, `accType`) VALUES ('".$_SESSION['userID']."', '".$_SESSION['userNick']."', '".$_SESSION['userAvatar']."', '".$_SESSION['signMethod']."', 2, 'student');";
  $insertNewRecord_Result = $db->query($insertNewRecord);
}

//go back to the previous page
header("Location: /onboarding/kyc.php");
exit;
?>