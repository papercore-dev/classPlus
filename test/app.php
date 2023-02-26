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
include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));
?>
<div class="swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
    <div class="h-48 m-4 p-4 bg-cover border rounded-xl" style=" background-image: url(https://images.unsplash.com/photo-1642427749670-f20e2e76ed8c?auto=format&amp;fit=crop&amp;w=880&amp;q=80); ">
</div>
    </div>
    <div class="swiper-slide">
        <div class="h-48 m-4 p-4 bg-white border rounded-xl">
            <span class="tossface text-2xl">💺</span><br>
            <h2 class="font-bold text-2xl"><?php echo getData('schoolName');?>에서만 볼 수 있는<br>이 광고 배너!</h2>
            <p class="text-gray-700">테스트중입니다</p>
            <a class="block visible py-2 px-4 mb-4 leading-none text-white mt-8 bg-blue-500 rounded-xl cursor-pointer sm:mr-3 sm:mb-0 sm:inline-block duration-300 hover:border-blue-400 hover:shadow-lg">
              웹으로 시작하기
            </a>
</div>
    </div>
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
