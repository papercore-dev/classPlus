<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<style>
.bottomNav{display: none!important;}
</style>
<div class="mx-auto max-w-md">
<div class="h-full bg-gray-50">
<div class="bg-gray-100 rounded-b-xl py-2  text-white">

<div class="max-w-md flex items-center justify-between"><a class="rounded-full text-gray-900 p-1 ml-2 hover:bg-gray-200"
href="javascript:Turbo.visit(`app.php`)">
<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
</a>

<div class="w-full p-2 text-black ">
 <a href="#">
 <h1 class="text-lg font-bold">
 <?php
            $getCommunityList = "SELECT * FROM `posts_board` WHERE `boardID` = '".$serviceName."'";
            $getCommunityList_Result = $db->query($getCommunityList);

            while($row = $getCommunityList_Result->fetch()){
                echo $row['boardName'];
            }
?>
 </h1>
 </a>
 </div>

</div>
</div>
        </div>