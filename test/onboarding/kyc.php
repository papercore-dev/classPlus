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

<!-- show user id -->
<div class="mb-12">
<h2 class="mb-4 text-3xl font-bold text-left lg:text-5xl">
<?php echo $_SESSION['userID']; ?>
</h2>
<p class="visible mx-0 mt-3 mb-0 text-sm leading-relaxed text-left text-gray-400">
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
<script>
    toastShow("인증을 기다리고 있어요.");
</script>
</div>
</div>
</div>

</div>
</body>
</html>