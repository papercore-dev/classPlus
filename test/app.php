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

$getWhitelistData = "SELECT * FROM `school_whitelisted` WHERE schoolSID = '".$_SESSION['schoolSID']."'";
$getWhitelistData_Result = $db->query($getWhitelistData);
if ($getWhitelistData_Result->rowCount() > 0){
while($row = $getWhitelistData_Result->fetch()){
    $_SESSION['schoolName'] = $row['schoolName'];
}
}
else{
  $_SESSION['schoolName'] = null;
}

//check if user accepted EULA
$getEULAData = "SELECT * FROM `account_users` WHERE userID = '".$_SESSION['userID']."' AND signMethod = '".$_SESSION['signMethod']."'";
$getEULAData_Result = $db->query($getEULAData);
if ($getEULAData_Result->rowCount() > 0){
while($row = $getEULAData_Result->fetch()){
    //if eulaAccepted is null or before 2023-02-28, redirect to eula page
    if ($row['eulaAccepted'] == null or $row['eulaAccepted'] < "2023-02-28"){
        header("Location: /onboarding");
    }
}
}

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));
?>
<div class="swiper">
  <div class="swiper-wrapper">
    <?php
    $getBannerData = "SELECT * FROM `banner` ORDER BY `banner`.`eventStart` DESC";
    $getBannerData_Result = $db->query($getBannerData);
    if ($getBannerData_Result->rowCount() > 0){
    while($row = $getBannerData_Result->fetch()){
    $isBannerHidden = false;
    if ($row["publicLevel"] == 0){}
    else if ($row["publicLevel"] == 1){if($row["schoolSID"] === getData("schoolSID")){}else{$isBannerHidden = true;}}
    else if ($row["publicLevel"] == 2){if($row["schoolSID"] === getData("schoolSID") and $row["schoolGrade"] === getData("schoolGrade")){if($row["schoolClass"] === getData("schoolClass")){}else{$isBannerHidden = true;}}else{$isBannerHidden = true;}}

    if ($row["eventStart"] > date("Y-m-d H:i:s")){$isBannerHidden = true;}
    if ($row["eventEnd"] < date("Y-m-d H:i:s")){$isBannerHidden = true;}

    if (!$isBannerHidden){
      if ($row['eventType'] == "image"){
        echo '<div class="swiper-slide">
        <div class="h-48 m-4 p-4 bg-cover border rounded-xl" style=" background-image: url('.$row['bannerImage'].'); ">
    </div>
        </div>';
      }
      else{
        echo '<div class="swiper-slide">
        <div class="h-48 m-4 p-4 bg-white border rounded-xl">
            <span class="tossface text-2xl">'.$row['eventEmoji'].'</span><br>
            <h2 class="font-bold text-2xl">'.$row['eventName'].'</h2>
            <p class="text-gray-700"></p>
            <a href="'.$row['eventLink'].'" class="block visible py-2 px-4 mb-4 leading-none text-white mt-8 bg-blue-500 rounded-xl cursor-pointer sm:mr-3 sm:mb-0 sm:inline-block duration-300 hover:border-blue-400 hover:shadow-lg">
            '.$row['eventButton'].'
                </a>
        </div>
        </div>';
      }
    
    }
  }
    }
    else{
      echo '<div class="swiper-slide">
      <div class="h-48 m-4 p-4 bg-white border rounded-xl">
          <span class="tossface text-2xl"></span><br>
          <h2 class="font-bold text-2xl">아직 등록된 배너가 없습니다!</h2>
          <p class="text-gray-700"></p>
          <a href="/landing.php" class="block visible py-2 px-4 mb-4 leading-none text-white mt-8 bg-blue-500 rounded-xl cursor-pointer sm:mr-3 sm:mb-0 sm:inline-block duration-300 hover:border-blue-400 hover:shadow-lg">
            클래스+ 알아보기
          </a>
      </div>
      </div>';
    }
    ?>

  </div>
</div>
<script>
    const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
});
</script>

<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">자주 보는 게시판</h4>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
            <div class="rounded-t mb-0 px-0 border-0">
              <div class="text-black dark:text-gray-50 block w-full">
                <div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
                    <strong>정치/시사</strong>
                    <p class="text-gray-500">윤석열에 대해 알아보아요</p>
            </div>
            <div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
                    <strong>초당중 게시판</strong>
                    <p class="text-gray-500">초당중딩 전용 게시판</p>
            </div>
              </div>
            </div>
          </div>
</section>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
