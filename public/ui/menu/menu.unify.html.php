<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<div class="max-w-md flex items-center justify-between">
<div class="p-3 text-gray-500 ">
  <a href="javascript:Turbo.visit(`/index.php`)">
<h1 class="text-2xl font-bold text-black">
  <img src="/resources/images/logo_gray.png" class="h-4 opacity-75">
  초당중 1학년 10반
  
</h1>
</a>
</div>
<div class="flex">

<div class="rounded-full text-gray-500 mr-2 mt-2 hover:bg-gray-100">
<img class="w-8 h-8 rounded-full object-cover" src="
      https://cdn.discordapp.com/attachments/924239126377685015/1067231154656256050/image.png
      " alt="avatar"/>

</div>

<a href="javascript:Turbo.visit(`/notice.php`);">
<div class="rounded-full text-gray-500 p-3 mr-2 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
</svg>

</div>
</a>
</div>
</div>


<script>
  function logoutConfirm(){
    if (confirm("로그아웃 하시겠어요?") == true){    //확인
      Turbo.visit(`/logout.php`);
    }
    else{   //취소
      return false;
    }
  }
</script>
<style>

*{
  font-family: 'Pretendard-Regular', sans-serif;
-webkit-font-smoothing: antialiased;
}
.font-semibold .font-bold .font-black{
font-family: 'Pretendard-Bold', sans-serif;
}
</style>