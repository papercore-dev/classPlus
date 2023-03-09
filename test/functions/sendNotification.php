<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

function sendNotification($recipientUserID, $recipientSignMethod, $subject, $content, $icon="https://classplus.pcor.me/resources/images/bell.png", $link="https://classplus.pcor.me", $database){
    $insertNotification = "INSERT INTO `account_logs` (`userID`, `signMethod`, `actionSubject`, `actionContent`, `actionIcon`, `actionLink`) VALUES ('".$recipientUserID."', '".$recipientSignMethod."', '".$subject."', '".$content."', '".$icon."', '".$link."')";
    $insertNotification_Result = $database->query($insertNotification);

    $findToken = "SELECT * FROM `account_fcm` WHERE `userID` = '".$recipientUserID."' AND `signMethod` = '".$recipientSignMethod."'";
    $findToken_Result = $database->query($findToken);
    if ($findToken_Result->rowCount() > 0){
        while($row = $findToken_Result->fetch()){
            $token = $row["token"];
            //use Firebase Cloud Messaging API V1 to send notification
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
            $headers = array (
                'Authorization: key=AAAAHuyRlw0:APA91bEK8Jtv5iNRRaDHGNRmCQd079A9njwleNXf8io5Cn0KbN55q2SteoDEgu-Iqiru5kHnrqujLXhy6SraM5ELX0j5LOEqriIozetIL1LEsGyJPhBLdwX0GpZIKJgLP6-Y4WC8rfvl',
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $url );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
        }
    }
}
?>