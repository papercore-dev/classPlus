<?php

include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

if (isset($_GET["redirect"])){
    $_SESSION["redirectURL"] = $_GET["redirect"];
}
?>
<div class="mx-auto">
<div class="h-full bg-white">
<div class="bg-white rounded-b-xl p-5  text-white">
<div class="flex items-center justify-between">
<div class="text-gray-100 ">
<a href="javascript:Turbo.visit(`/app.php`)"><div class="rounded-full text-gray-500 p-3 mr-2 hover:bg-gray-100">
<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
</div>
</a>
</div>
<div class="flex">
</div>
</div>
</div>
<section class="p-5">
<div class="space-y-2">

</div>


<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<div class="w-full items-center justify-center text-center">
<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_bcbd2axv.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop="" autoplay=""
class="inline-block"></lottie-player>
</div>

<div class="pt-12">
<div class="mx-auto max-w-7xl">
<div class="text-center">
<h2 class="text-lg font-semibold text-blue-500">Class+에 로그인하시고</h2>
<p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-800 sm:text-4xl">
친구들과 대화를 시작해봐요!</p>
<h2 class="mt-2 text-gray-500">아이폰이라면 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15"></path>
</svg>공유&nbsp;<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
</svg>
 홈 화면에 추가해서 빠르게 이용해보세요!</h2>
</div>
</div>
</div>
</section>
<div class="pb-32"></div>

</div>
<div class="fixed bottom-0 left-0 w-full z-10 gradient">
<div class="m-4">

<div class=" justify-center items-center gap-4">
<a href="/oauth/provider/kakao.php?action=login">
<button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl">카카오톡으로 시작하기</button>
</a>
<a href="/oauth/provider/google.php?action=login" class="w-full block mt-4 text-center text-blue-500">Google로 시작할래요 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 inline-block">
  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
</svg>
</a>
</div>

</div>
</div>

</div>
</body>
</html>
