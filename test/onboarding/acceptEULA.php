<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/onboarding");

//find user from database and check if user accepted EULA later than 2023-02-27
//if user accepted EULA later than 2023-02-27, redirect to /app.php
//if user accepted EULA earlier than 2023-02-27, show onboarding page

$findPrevRecord = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_SESSION['signMethod']."' AND `userID` = '".$_SESSION['userID']."'";
$findPrevRecord_Result = $db->query($findPrevRecord);  
if ($findPrevRecord_Result->rowCount() > 0){
    while($row = $findPrevRecord_Result->fetch_assoc() ){
        if ($row['eulaAccepted'] !== null){
            $redirectAfterOnboarding = "/app.php";
            if ($row['eulaAccepted'] > 1614396800){
                echo "<script>window.location.href = '/app.php';</script>";
                die;
                }
        }
        else{
            $redirectAfterOnboarding = "/onboarding/kyc.php";
        }
    }
}
?>
<script>
    turbo.visit("<?php echo $redirectAfterOnboarding; ?>");
</script>
</body>
</html>