<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<div class="max-w-md flex items-center justify-between">
<div class="p-2 text-gray-500 ">
 <a href="javascript:Turbo.visit(`/index.php`)">
 <h1 class="text-lg text-gray-500">
 <img src="/resources/images/logo_gray.png" class="mr-2 h-6 inline-block opacity-75"><?php echo getData('schoolName'); ?></h1>
 </a>
 </div>
<div class="flex">

<button @click="open = !open" class="rounded-full text-gray-500 mr-2 mt-2 hover:bg-gray-100">
<img class="w-8 h-8 rounded-full object-cover" src="<?php echo getData('userAvatar'); ?>" alt="avatar"
onerror="if (this.src != '/resources/images/fallback_profile.jpg') this.src = '/resources/images/fallback_profile.jpg';">
</button>

</div>
</div>