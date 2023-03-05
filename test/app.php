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
    include 'functions/specificFunction.php';
    if ($row["eventStart"] > date("Y-m-d H:i:s")){$isBannerHidden = true;}
    if ($row["eventEnd"] < date("Y-m-d H:i:s")){$isBannerHidden = true;}

    if (!$isBannerHidden){
      if ($row['eventType'] == "image"){
        echo '<div class="swiper-slide">
        <a href="'.$row['eventLink'].'">
        <div class="h-48 m-4 p-4 bg-cover border rounded-xl" style=" background-image: url('.$row['bannerImage'].'); ">
    </div>
    </a>
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
          <h2 class="font-bold text-2xl">아직 등록된 배너가 없어요</h2>
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
<div class="mb-2 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">자주 사용</h4>
</div>
<div class="overflow-x-scroll flex mb-5">
  <?php
  $getQuickLinkData = "SELECT * FROM `account_serviceAnalytics` WHERE userID = '".$_SESSION['userID']."' AND signMethod = '".$_SESSION['signMethod']."' ORDER BY `account_serviceAnalytics`.`visitCount` DESC";
  $getQuickLinkData_Result = $db->query($getQuickLinkData);
  if ($getQuickLinkData_Result->rowCount() > 0){
  while($row = $getQuickLinkData_Result->fetch()){
  $getQuickLinkName = "SELECT * FROM `services` WHERE serviceName = '".$row['serviceName']."' AND `servicePublic`= 1";
  $getQuickLinkName_Result = $db->query($getQuickLinkName);
  if ($getQuickLinkName_Result->rowCount() > 0){
  while($row2 = $getQuickLinkName_Result->fetch()){
    echo '<a href="'.$row2['serviceLink'].'" class="flex-none py-3 px-6">
      <div class="flex flex-col items-center justify-center gap-3">
        <p class="text-4xl tossface">'.$row2['serviceEmoji'].'</p>
        <span class="text-slate-900 dark:text-slate-200">'.$row2['serviceNick'].'</span>
      </div>
    </a>';
    break;
  }
}
  }
}
else{
  echo '<div class="py-9 border rounded-lg bg-white text-center text-gray-500 ">서비스를 사용하면 여기에 나타나요</div>';
}
  ?>
      
    </div>
  
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">자주 보는 게시판</h4>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
            <div class="rounded-t mb-0 px-0 border-0">
              <div class="text-black dark:text-gray-50 block w-full">
            <?php
            $getQuickBoardData = "SELECT * FROM `account_boardAnalytics` WHERE userID = '".$_SESSION['userID']."' AND signMethod = '".$_SESSION['signMethod']."' ORDER BY `account_boardAnalytics`.`visitCount` DESC LIMIT 5";
            $getQuickBoardData_Result = $db->query($getQuickBoardData);
            if ($getQuickBoardData_Result->rowCount() > 0){
            while($row = $getQuickBoardData_Result->fetch()){
            $getQuickBoardName = "SELECT * FROM `board` WHERE boardName = '".$row['boardName']."' AND `boardHidden`= 0 AND `view_accesslevel` <= '".$_SESSION['accesslevel']."'";
            $getQuickBoardName_Result = $db->query($getQuickBoardName);
            if ($getQuickBoardName_Result->rowCount() > 0){
            while($row2 = $getQuickBoardName_Result->fetch()){
              echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
              <strong>'.$row2['boardNick'].'</strong>
      </div>';
              
            }
          }
        }
      }
      else{
        echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
        <p class="text-gray-500">게시판을 사용하면 여기에 나타나요</p>
</div>';
      }
            ?>
                </div>
              </div>
            </div>
            <div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">인기 급상승</h4>
</div>
<?php
$getPopularPost = "SELECT * FROM `board_post` WHERE `view_accesslevel` <= '".$_SESSION['accesslevel']."' ORDER BY `board_post`.`postLike` DESC LIMIT 5";
$getPopularPost_Result = $db->query($getPopularPost);
if ($getPopularPost_Result->rowCount() > 0){
while($row = $getPopularPost_Result->fetch()){
  $getBoardName = "SELECT * FROM `board` WHERE boardName = '".$row['boardName']."' AND `boardHidden`= 0 AND `view_accesslevel` <= '".$_SESSION['accesslevel']."'";
  $getBoardName_Result = $db->query($getBoardName);
  if ($getBoardName_Result->rowCount() > 0){
  while($row2 = $getBoardName_Result->fetch()){
    echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
    <strong>'.$row2['boardNick'].'</strong>
    <a href="/board/'.$row['boardName'].'/'.$row['postID'].'">'.$row['postTitle'].'</a>
</div>';
  }
}
}
}
else{
  echo '<div class="my-1 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg border">
  <p class="text-gray-500">게시판을 사용하면 여기에 나타나요</p>
</div>';
}
?>

          </div>
</section>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
