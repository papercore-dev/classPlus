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
    $insertMatrixCreationLog = "INSERT INTO matrix_conn (userID, signMethod, matrixID, matrixPass) VALUES ('".$_SESSION["userID"]."', '".$_SESSION["signMethod"]."', '".$matrixID."', '".$matrixPass."')";
    $insertMatrixCreationLog_Result = $db->query($insertMatrixCreationLog);
    //create new synapse user with python script
    
}
?>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

<!-- show login credentials and link to matrix -->
<section class="p-5" id="pageContent">

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<div class="w-full items-center justify-center text-center">
<lottie-player src="https://assets5.lottiefiles.com/private_files/lf30_fhynbgue.json" background="transparent" speed="1" style="width: 150px; height: 150px;" autoplay="" class="inline-block"></lottie-player>
</div>
<div class="mb-5">
<h4 class="text-2xl font-bold text-slate-500">아래의 정보로<br>채팅에서 로그인하세요</h4>
<p class="text-sm text-gray-500">채팅은 <span class="text-blue-500">종단간 암호화</span> 되어 있기 때문에, 다중 로그인이나 암호 키를 활성화하지 않았다면 복구할 수 없어요.<br>
채팅 내의 대화에 대해서 저희 클래스+는 책임지지 않지만, 법적 수사 과정에서 사용자 정보 요청 시 학생 정보를 <span class="text-blue-500">제출 가능</span>해요.</p>
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
<a href="javascript:openChat()" class="block visible py-4 px-4 mb-4 text-lg leading-none text-white mt-8 bg-blue-500 rounded-xl cursor-pointer sm:mr-3 sm:mb-0 sm:inline-block duration-300 hover:border-blue-400 hover:shadow-lg w-full text-center font-bold">채팅 열기</a>
<a href="#" class="w-full block mt-4 text-center text-blue-500">채팅이 잘 안 되나요? <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 inline-block">
  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
</svg>
</a>
</div>
</div>
</div>
</section>
<script>
    function openChat(){
        Turbo.visit('https://chat.pcor.me');
        document.getElementById("pageContent").classList.add("animate__fadeOutRight");
        document.getElementById("pageContent").classList.add("animate__animated");
    }
</script>
<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>