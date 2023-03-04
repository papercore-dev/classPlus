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
    while($row = $findMatrixCreationLog_Result->fetch()){
        $matrixID = $row["matrixID"];
        $matrixPass = $row["matrixPass"];
    }
}
else{
    //set current timestamp to matrixID
    $matrixID = 'cp'.time();
    //generate random 16 digit password
    $matrixPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
    exec("python3 ../scripts/registerMatrix.py -u ".$matrixID." -p ".$matrixPass." -k ".'"wntxWM0i4OE4dAFrV968SA2nab8ZX2uIaTHoX55NgqkzQ119DygtQjYqTrQdpFhH"'." https://chat-backend.pcor.me", $output);
    
    //insert matrixID and matrixPass to matrix_conn
    //if output doesn't contain "success", don't insert
    if (strpos($output[0], "success") !== false){
        $insertMatrixCreationLog = "INSERT INTO matrix_conn (userID, signMethod, matrixID, matrixPass) VALUES ('".$_SESSION["userID"]."', '".$_SESSION["signMethod"]."', '".$matrixID."', '".$matrixPass."')";
        $insertMatrixCreationLog_Result = $db->query($insertMatrixCreationLog);
    }
    //create new synapse user with python script
    
}
?>
<!-- show login credentials and link to matrix -->
<section class="p-5">

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<div class="w-full items-center justify-center text-center">
<lottie-player src="https://assets5.lottiefiles.com/private_files/lf30_fhynbgue.json" background="transparent" speed="1" style="width: 150px; height: 150px;" loop="" autoplay="" class="inline-block"></lottie-player>
</div>
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">아래의 정보로<br>채팅에서 로그인하세요</h4>
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
<a href="https://chat.pcor.me" class="block visible py-4 px-4 mb-4 text-lg leading-none text-white mt-8 bg-blue-500 rounded-xl cursor-pointer sm:mr-3 sm:mb-0 sm:inline-block duration-300 hover:border-blue-400 hover:shadow-lg w-full text-center font-bold">채팅 열기&nbsp;</a>
</div>
</div>
</div>
</section>

<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>