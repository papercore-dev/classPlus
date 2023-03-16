<?php

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
인증 대기 중
</h2>
<p class="visible mx-0 mt-3 mb-0 text-sm leading-relaxed text-left text-gray-400">
<span class="text-blue-500 font-bold">회장에게 승인받을 때 까지</span>&nbsp;기다려 주세요.
</p>
</div>

<div class="rounded-lg text-center bg-gray-200">
<h2 class="pt-4 text-xl">
<?php
echo $_SESSION['signMethod'];
echo '<br>';
echo $_SESSION["userID"];
?>
</h2>
<p class="visible mx-0 mt-1 pb-4 text-sm leading-relaxed text-center text-gray-400">
이 코드를 회장에게 보여주세요
</p>
</div>

</div>
</section>
<div class="pb-32"></div>

</div>
<div class="fixed bottom-0 left-0 w-full z-10 gradient">
<div class="m-4">

<div class=" justify-center items-center gap-4">
<a href="sessionRenew.php">
<button class="w-full bg-blue-600 hover:bg-blue-600 text-white border hover:shadow font-bold  px-4 rounded-xl py-3 my-1">
    새로고침
</button>
</a>
<a href="/oauth/logout.php" class="w-full block mt-4 text-center text-blue-500">로그아웃 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 inline-block">
<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
</svg>
</a>
</div>

</div>
</div>
<!--fixed bottom button to sign out or refresh-->
<script>
    toastShow("인증을 기다리고 있어요.");
</script>


</div>
</body>
</html>