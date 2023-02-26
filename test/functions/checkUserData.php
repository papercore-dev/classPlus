<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function getData($target){
    if ($target == "schoolName"){
        $getWhitelistData = "SELECT * FROM `school_whitelisted` WHERE schoolSID = '".$_SESSION['schoolSID']."'";
        $getWhitelistData_Result = $db->query($getWhitelistData);
        if ($getWhitelistData_Result->rowCount() > 0){
        while($row = $getWhitelistData_Result->fetch()){
            return $row['schoolName'];
        }
    }
    else{
        return null;
    }
    }
    else{
    if (isset($_SESSION[$target])){
        return $_SESSION[$target];
    }
    else{
        return null;
    }
}
}
?>