<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0' AND view_accessLevel <= '".$_SESSION['accessLevel']."'";
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

include 'functions/analyzeBoards.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.bd.html.php';
chdir(dirname(__FILE__));
?>
<?php
//check if POST's search is set
if (isset($_POST['search'])){
    $search = $_POST['search'];
    //only accept A-Z, a-z, Korean, 0-9, and space
    if (!preg_match("/^[가-힣a-zA-Z0-9 ]*$/", $search)){
        $search = "";
    }
}
else{
    $search = "";
}
?>
<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">
    <?php
    if ($search == ""){
    }
    else{
        echo $search." 검색 결과";
    }
    ?>
</h4>
</div>

<form action="/list.php?id=<?php echo $_GET["id"]?>" method="post">   
        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
        <div class="relative">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="search"     <?php
    if ($search == ""){
        echo "value=''";
    }
    else{
        echo "value='".$search."'";
    }
    ?> id="search" name="search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="검색" required>
        </div>
</form>

<?php
    if ($search == ""){
        echo'
<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">

   <div class="text-black dark:text-gray-50 block w-full">';
   if ($_GET["id"] !== "13"){
    //13번 게시판에 중앙공지가 저장됨
   $getPostList = "SELECT * FROM `posts` WHERE `boardID` = '".$_GET["id"]."' AND `postHidden` = '0' AND `postNotice` = '1' ORDER BY `postCreation` DESC";
   include 'functions/listPost.php';
   chdir(dirname(__FILE__));
}
   $getPostList = "SELECT * FROM `posts` WHERE `boardID` = '13' AND `postHidden` = '0' AND `postNotice` = '0' ORDER BY `postCreation` DESC";
   include 'functions/listPost.php';
   chdir(dirname(__FILE__));
            $getPostList = "SELECT * FROM `posts` WHERE `boardID` = '".$_GET["id"]."' AND `postHidden` = '0' AND `postNotice` = '0' ORDER BY `postCreation` DESC";
            include 'functions/listPost.php';
            chdir(dirname(__FILE__));
    echo'
          </div>
</section>';
    }
    else{
        echo'
        <div class="mt-4 relative flex flex-col min-w-0 break-words w-full">
        
           <div class="text-black dark:text-gray-50 block w-full">';
        //search title and content
        $getPostList = "SELECT * FROM `posts` WHERE `boardID` = '".$_GET["id"]."' AND `postHidden` = '0' AND `postNotice` = '0' AND (`postTitle` LIKE '%".$search."%' OR `postContent` LIKE '%".$search."%') ORDER BY `visitCount` DESC";
        include 'functions/listPost.php';
        chdir(dirname(__FILE__));
        echo'
        </div>
</section>';
    }
?>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
