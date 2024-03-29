<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

if (session_status() === PHP_SESSION_NONE){
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
      session_start();
      ob_start();
}

$load = true;
include 'checkVariable.php';
chdir(dirname(__FILE__));
include 'sendNotification.php';
chdir(dirname(__FILE__));
include '../database/adapter_db.php';
chdir(dirname(__FILE__));


if(get('action') == 'login') {

    $params = array(
      'client_id' => OAUTH2_CLIENT_ID,
      'redirect_uri' => 'https://'.$_SERVER["HTTP_HOST"].$redirectURL,
      'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
      'response_type' => 'code'
    );
  
    header('Location: ' . $authorizeURL . '?' . http_build_query($params));
    die();
}

if(get('code')) {

    $token = apiRequest($tokenURL, array(
      "grant_type" => "authorization_code",
      'client_id' => OAUTH2_CLIENT_ID,
      'client_secret' => OAUTH2_CLIENT_SECRET,
      'redirect_uri' => 'https://'.$_SERVER["HTTP_HOST"].$redirectURL,
      'code' => get('code')
    ));
    $logout_token = $token->access_token;
    $_SESSION['access_token'] = $token->access_token;
  
  
    header('Location: ' . $_SERVER['PHP_SELF']);
  }


  if(session('access_token')) {

    $user = apiRequest($apiURLBase);
   //userNick (user full name), userAvatar (full url form), userID (Email address) from google's API
    $_SESSION['userNick'] = $user->name;
    $_SESSION['userAvatar'] = $user->picture;
    $_SESSION['userID'] = $user->email;
  $_SESSION['signMethod'] = $providerName;

  $findBanRecord = "SELECT * FROM `account_ban` WHERE `userID` = '".$_SESSION['userID']."' AND `signMethod` = '".$_SESSION['signMethod']."'";
  $findBanRecord_Result = $db->query($findBanRecord);
  if ($findBanRecord_Result->rowCount() > 0){
    while($row = $findBanRecord_Result->fetch()){
        if ($row['banRelease'] < date("Y-m-d")){
            $deleteBanRecord = "DELETE FROM `account_ban` WHERE `account_ban`.`userID` = '".$_SESSION['userID']."' AND `account_ban`.`signMethod` = '".$_SESSION['signMethod']."'";
            $deleteBanRecord_Result = $db->query($deleteBanRecord);
            break;
        }

      echo "<script>alert('Class+ 이용이 제한되었어요.\\n제재 기한: ".$row['banRelease']."\\n제재 사유: ".$row['banReason']."');location.href = '/';</script>";
      session_destroy();
      die;
    }
  }

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

  sendNotification($_SESSION["userID"], $_SESSION["signMethod"], "🔑 계정 로그인 확인", "로그인이 확인되었어요. 본인의 활동이 맞는지 확인해주세요.", "", "", $db);
    //if redirect url is specified, redirect to there
    if(isset($_SESSION["redirectURL"])){
      $redirect = $_SESSION["redirectURL"];
  
      echo "<script>location.href='".$redirect."';</script>";
      
      unset($_SESSION["redirectURL"]);
      exit;
    }
    else{
      echo "<script>location.href='/app.php';</script>";
    exit;
    }
}

if(get('action') == 'logout') {
    session_destroy();
    echo "<script>location.href='/';</script>";
    die();
  }  
 else {
    echo '<script>location.href="/oauth";</script>';
    exit;
}



function apiRequest($url, $post=FALSE, $headers=array()) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  
    $response = curl_exec($ch);
  
  
    if($post)
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  
    $headers[] = 'Accept: application/json';
  
    if(session('access_token'))
      $headers[] = 'Authorization: Bearer ' . session('access_token');
  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
    $response = curl_exec($ch);
    return json_decode($response);
  }
  
  function get($key, $default=NULL) {
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
  }
  
  function session($key, $default=NULL) {
    return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
  }

?>