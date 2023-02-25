<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ui/common/header.html.php';?>
<?php
include 'ui/menu/menu.nt.html.php';
?>
<div class="swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
        <div class="h-1/3 m-4 p-4 bg-white border rounded-xl">
            <span class="tossface text-2xl">💺</span><br>
            <h2 class="font-bold text-2xl">테스트테스트테스트테스트</h2>
            <p class="text-gray-700">테스트중입니다</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl mt-2">자세히 알아보기</button>
</div>
    </div>
    <div class="swiper-slide">
        <div class="h-1/3 m-4 p-4 bg-white border rounded-xl">
            <span class="tossface text-2xl">💺</span><br>
            <h2 class="font-bold text-2xl">테스트테스트테스트테스트</h2>
            <p class="text-gray-700">테스트중입니다</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl mt-2">자세히 알아보기</button>
</div>
    </div>
    <div class="swiper-slide">
        <div class="h-1/3 m-4 p-4 bg-white border rounded-xl">
            <span class="tossface text-2xl">💺</span><br>
            <h2 class="font-bold text-2xl">테스트테스트테스트테스트</h2>
            <p class="text-gray-700">테스트중입니다</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl mt-2">자세히 알아보기</button>
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
?>
