<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/onboarding");


$findPrevRecord = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_SESSION['signMethod']."' AND `userID` = '".$_SESSION['userID']."'";
$findPrevRecord_Result = $db->query($findPrevRecord);  
if ($findPrevRecord_Result->rowCount() > 0){
    while($row = $findPrevRecord_Result->fetch()){
        if ($row['eulaAccepted'] == null){
            echo "<script>window.location.href = '/onboarding';</script>";
            die;
        }
    }
}

if (isset($_SESSION["schoolSID"])){
    if ($_SESSION["schoolSID"] == null or $_SESSION["schoolSID"] == ""){
    }
    else{
    echo "<script>window.location.href = '/app.php';</script>";
    die;
    }
}
?>

<div class="mx-auto">
<div class="h-full bg-white">
<div class="bg-white rounded-b-xl p-5  text-white">
<div class="flex items-center justify-between">
<div class="text-gray-100 ">
</div>
<div class="flex">
</div>
</div>
</div>
<section class="p-5">
<div class="space-y-2">

</div>


<div class="mb-12">
    <div class="mb-12">
<h2 class="mb-4 text-3xl font-bold text-left lg:text-5xl">
학생 인증
</h2>
<p class="visible mx-0 mt-3 mb-0 text-sm leading-relaxed text-left text-gray-400">
전달 받은 인증번호 6자리를 입력해주세요.<br>
학생 인증을 완료하면 인증번호는 만료돼요.
</p>
</div>
            <div class="inviteContainer flex flex-row items-center justify-between mx-auto w-full max-w-xs">
              <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
                            <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
                                          <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
                                          <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
                                          <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
                                          <div class="w-12 h-16">
                <input class="bg-gray-200 font-mono text-2xl w-full h-full flex flex-col items-center justify-center text-center px-2 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text"
                name="" type="number" id="" required maxlength="1">
              </div>
            </div>
</div>
</section>
<div class="pb-32"></div>

</div>
<div class="fixed bottom-0 left-0 w-full z-10 gradient">
<div class="m-4">

<div class=" justify-center items-center gap-4">
<button class="w-full bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-xl">계속하기</button>

<script>
    toastShow("학생 인증이 필요해요.");

    var btn = document.querySelector("button");

    var cb1 = document.querySelectorAll("input")[0];
    var cb2 = document.querySelectorAll("input")[1];
    var cb3 = document.querySelectorAll("input")[2];
    var cb4 = document.querySelectorAll("input")[3];
    var cb5 = document.querySelectorAll("input")[4];
    var cb6 = document.querySelectorAll("input")[5];

    function check() {
        if (cb1.value.length == 1 && cb2.value.length == 1 && cb3.value.length == 1 && cb4.value.length == 1 && cb5.value.length == 1 && cb6.value.length == 1) {
            btn.classList.remove("bg-gray-400");
            btn.classList.remove("hover:bg-gray-400");
            btn.classList.add("bg-blue-500");
            btn.classList.add("hover:bg-blue-700");
            btn.setAttribute( "onClick", "continueOnboard();");
        } else {
            btn.classList.remove("bg-blue-500");
            btn.classList.remove("hover:bg-blue-700");
            btn.classList.add("bg-gray-400");
            btn.classList.add("hover:bg-gray-400");
            btn.setAttribute("onClick", "console.log('Not checked');");
        }
    }

    function handOffFocus(cb){
        if(cb.value.length == 1){
            cb.nextElementSibling.focus();
        }
    }

    //on key down, check if all inputs are filled
    cb1.addEventListener("keydown", check);
    cb2.addEventListener("keydown", check);
    cb3.addEventListener("keydown", check);
    cb4.addEventListener("keydown", check);
    cb5.addEventListener("keydown", check);
    cb6.addEventListener("keydown", check);

    //on key up, check if all inputs are filled
    cb1.addEventListener("keyup", check);
    cb2.addEventListener("keyup", check);
    cb3.addEventListener("keyup", check);
    cb4.addEventListener("keyup", check);
    cb5.addEventListener("keyup", check);
    cb6.addEventListener("keyup", check);

    //on key down, run handOffFocus
    cb1.addEventListener("keydown", function(){handOffFocus(cb1)});
    cb2.addEventListener("keydown", function(){handOffFocus(cb2)});
    cb3.addEventListener("keydown", function(){handOffFocus(cb3)});
    cb4.addEventListener("keydown", function(){handOffFocus(cb4)});
    cb5.addEventListener("keydown", function(){handOffFocus(cb5)});
    cb6.addEventListener("keydown", function(){handOffFocus(cb6)});

    function continueOnboard() {
        //ask user to confirm applying for class
        var r = confirm("정말로 학생 인증을 할까요? 학생 인증을 하면 학생 인증을 취소할 수 없어요.");
        if (r == true) {
            //if user confirms, send data to server
            var code = cb1.value + cb2.value + cb3.value + cb4.value + cb5.value + cb6.value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "verifyCode.php", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify({
                "code": code
            }));
            xhr.onload = function() {
                if (xhr.status == 200) {
                    //show alert when response is in form of {"error": "오류"}, when {"success": "성공"}, redirect to /app.php
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        toastShow(response.error);
                    } else if (response.success) {
                        toastShow(response.success);
                        Turbo.visit("/app.php");
                    }
                } else {
                    alert("오류가 발생했어요. 다시 시도해주세요.");
                }
            }
        }
    }
</script>
</div>
</div>
</div>

</div>
</body>
</html>