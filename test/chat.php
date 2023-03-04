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

$serviceName = "chat";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<?php
//if there is no result on matrix_conn, create new synapse user with python script
$findMatrixCreationLog = "SELECT * FROM matrix_conn WHERE userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."'";
$findMatrixCreationLog_Result = $db->query($findMatrixCreationLog);
if ($findMatrixCreationLog_Result->rowCount() > 0){
    while($row = $getCalendarData_Result->fetch()){
        $matrixID = $row["matrixID"];
        $matrixPass = $row["matrixPass"];
    }
}
else{
    //set current timestamp to matrixID
    $matrixID = time();
    //generate random 16 digit password
    $matrixPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
    //insert matrixID and matrixPass to matrix_conn
    $insertMatrixCreationLog = "INSERT INTO matrix_conn (userID, signMethod, matrixID, matrixPass) VALUES ('".$_SESSION["userID"]."', '".$_SESSION["signMethod"]."', '".$matrixID."', '".$matrixPass."')";
    $insertMatrixCreationLog_Result = $db->query($insertMatrixCreationLog);
    //create new synapse user with python script
    exec("python3 ../scripts/registerMatrix.py -u ".$matrixID." -p ".$matrixPass." -k \"".$API_matrix."\" https://chat-backend.pcor.me", $output);
    //show result
    echo "<pre>";
    print_r($output);
    echo "</pre>";
}
?>
<!-- show login credentials and link to matrix -->
<section class="p-5">


<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">로그인 정보</h4>
</div>
<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
<div class="rounded-t mb-0 px-0 border-0">
<div class="text-black dark:text-gray-50 block w-full">
<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border flex">
<strong>사용자명&nbsp;</strong>
<p class="text-gray-500"><?php echo $matrixID;?></p>
</div>
<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border flex">
<strong>비밀번호&nbsp;</strong>
<p class="text-gray-500"><?php echo $matrixPass;?></p>
</div>
</div>
</div>
</div>
</section>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>