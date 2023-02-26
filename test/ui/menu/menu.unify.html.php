<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<div class="max-w-md flex items-center justify-between">
<div class="p-3 text-gray-500 ">
  <a href="javascript:Turbo.visit(`/index.php`)">
<h1 class="text-2xl font-bold text-black">
  <img src="/resources/images/logo_gray.png" class="h-4 opacity-75">
  <?php
  echo getData('schoolName').' '.getData('schoolGrade').'학년 '.getData('schoolClass').'반';
  ?>
  
</h1>
</a>
</div>
<div class="flex">

<div @click.away="open = false" class="relative" x-data="{ open: false }">
<button @click="open = !open" class="rounded-full text-gray-500 mr-2 mt-2 hover:bg-gray-100">
<img class="w-8 h-8 rounded-full object-cover" src="<?php echo getData('userAvatar'); ?>" alt="avatar">
</button>
<div style="z-index: 9999;" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
<div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-800 text-black dark:text-white">
<a class="hover:bg-blue-500 hover:text-white rounded-lg block px-4 py-2 mt-2 bg-transparent text-sm" href="#">
  <strong><?php echo getData('userName'); ?></strong>님<br>
  <span class="text-xs"><?php echo getData('userID'); ?></span>
</a>
<a class="hover:bg-blue-500 hover:text-white rounded-lg block px-4 py-2 mt-2 bg-transparent text-sm" href="javascript:Turbo.visit(`/oauth/logout.php`);">
  로그아웃
</a>
</div>
</div>
</div>

</div>
</div>
