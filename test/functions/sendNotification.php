<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function sendNotification($recipientUserID, $recipientSignMethod, $subject, $content, $icon="", $link="https://classplus.pcor.me", $database){
    $insertNotification = "INSERT INTO `account_logs` (`userID`, `signMethod`, `actionSubject`, `actionContent`, `actionIcon`, `actionLink`) VALUES ('".$recipientUserID."', '".$recipientSignMethod."', '".$subject."', '".$content."', '".$icon."', '".$link."')";
    $insertNotification_Result = $database->query($insertNotification);

    $findToken = "SELECT * FROM `account_fcm` WHERE `userID` = '".$recipientUserID."' AND `signMethod` = '".$recipientSignMethod."'";
    $findToken_Result = $database->query($findToken);
    if ($findToken_Result->rowCount() > 0){
        while($row = $findToken_Result->fetch()){
            $token = $row["token"];
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array (
                    'to' => $token,
                    'notification' => array (
                            "title" => $subject,
                            "body" => $content,
                            "icon" => $icon,
                            "click_action" => $link
                    )
            );
            $fields = json_encode ( $fields );
            $header = array (
                    'Authorization: key=c904041bb87c3f97b41f9f9c304fe3e7dc3dbe78',
                    'Content-Type: application/json'
            );
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
        }
    }
}
?>