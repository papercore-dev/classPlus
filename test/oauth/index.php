<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../ui/common/header.html.php';

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
<h2 class="text-lg font-semibold text-blue-500">Class+에 로그인하고</h2>
<p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-800 sm:text-4xl">
친구들과 대화를 시작해봐요</p>
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
</div>
</div>
</div>

</div>
</body>
</html>