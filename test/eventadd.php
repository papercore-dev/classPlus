<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/menu.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));
include 'functions/timeToRelative.php';
chdir(dirname(__FILE__));

//ID 검증
if (!isset($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

$serviceName = $_GET["id"];

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0' AND write_accessLevel <= '".$_SESSION['accessLevel']."'";
$getServiceData_Result = $db->query($getServiceData);
if ($getServiceData_Result->rowCount() == 0){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
else{
    while($row = $getServiceData_Result->fetch()){
        include 'functions/specificFunction.php';
        if ($isBannerHidden){
            echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
            die;
        }
    }
}

//게시판 이름 구하기
$getServiceName = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."'";
$getServiceName_Result = $db->query($getServiceName);
$boardName = "";
while($row = $getServiceName_Result->fetch()){
    $boardName = $row["boardName"];
}

$headName = $boardName." 게시판에 글 쓰기";
include 'ui/menu/menu.custom.html.php';
chdir(dirname(__FILE__));
?>

  <div class="mx-auto w-full">
    <form action="/form/write.php" method="POST">
      <div class="">
        <input
          type="text"
          name="title"
          id="title"
          placeholder="일정 제목"
          class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
    <!--field to enter start date and end date and visibility-->
        <div class="flex flex-row justify-between">
            <div class="w-1/2">
            <input
                type="date"
                name="startDate"
                id="startDate"
                placeholder="시작 날짜"
                class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
            </div>
            <div class="w-1/2">
            <input
                type="date"
                name="endDate"
                id="endDate"
                placeholder="종료 날짜"
                class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
            </div>
        </div>
        
      <div>
        <button
          class="hover:shadow-lg rounded-lg bg-blue-500 py-3 px-8 text-base font-semibold text-white outline-none"
        >
          만들기
        </button>
      </div>
    </form>
  </div>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
