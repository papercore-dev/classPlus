<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/menu.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

include 'ui/menu/menu.nt.html.php';
chdir(dirname(__FILE__));
?>
<script>
  (function(){var w=window;if(w.ChannelIO){return w.console.error("ChannelIO script included twice.")}var ch=function(){ch.c(arguments)};ch.q=[];ch.c=function(args){ch.q.push(args)};w.ChannelIO=ch;function l(){if(w.ChannelIOInitialized){return}w.ChannelIOInitialized=true;var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="https://cdn.channel.io/plugin/ch-plugin-web.js";var x=document.getElementsByTagName("script")[0];if(x.parentNode){x.parentNode.insertBefore(s,x)}}if(document.readyState==="complete"){l()}else{w.addEventListener("DOMContentLoaded",l);w.addEventListener("load",l)}})();

  ChannelIO('boot', {
    "pluginKey": "0ab7b3e0-d4a0-4c9f-8888-058bc4ea9eef",
    "memberId": "<?php echo getData("signMethod")?>-<?php echo getData("userID")?>", // fill user's member id
    "profile": { // fill user's profile
      "name": "<?php echo getData("userName")?>", // fill user's name
      "schoolSID": "<?php echo getData("schoolSID")?>",
        "schoolName": "<?php echo getData("schoolName")?>",
        "schoolGrade": "<?php echo getData("schoolGrade")?>",
        "schoolClass": "<?php echo getData("schoolClass")?>",
        "schoolNo": "<?php echo getData("schoolNo")?>",
        "signMethod": "<?php echo getData("signMethod")?>",
        "userID": "<?php echo getData("userID")?>",
        "accessLevel": "<?php echo getData("accessLevel")?>",
    }
  });
</script>
<section class="p-5">
<div class="mb-5 flex items-center justify-between">
<h4 class="text-2xl font-bold text-slate-500">전체</h4>
</div>

<div class="mt-4 relative flex flex-col min-w-0 break-words w-full">

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">내 정보</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <a href="javascript:Turbo.visit(`/profile.php`)">
            <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="<?php echo getData('userAvatar'); ?>" alt="avatar" onerror="if (this.src != '/resources/images/fallback_profile.jpg') this.src = '/resources/images/fallback_profile.jpg';">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        내 정보
                        </p>
                    </div>
                </div>
            </li>
            </a>
            <?php
            if ($_SESSION["accType"] == "teacher" or getData('accessLevel') >= 4) {
            echo'
            <a href="javascript:Turbo.visit(`/dashboard`)">
            <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 text-3xl tossface">
                    ⚙️
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        우리 반 관리하기
                        </p>
                    </div>
                </div>
            </li>
            </a>';
        }
        ?>
        </ul>
          </div>
          <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">서비스</h3>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php
            $getCommunityList = "SELECT * FROM `services` WHERE `servicePublic`= 1";
            $getCommunityList_Result = $db->query($getCommunityList);

            while($row = $getCommunityList_Result->fetch()){
                echo '
                <a href="javascript:Turbo.visit(`'.$row['serviceLink'].'`)">
                <li class="rounded-lg hover:bg-gray-200 my-1 py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 text-3xl tossface">
                    '.$row['serviceEmoji'].'
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        '.$row['serviceNick'].'
                        </p>
                    </div>
                </div>
            </li>
            </a>';
            }
            ?>

        </ul>
          </div>
        </div>
</section>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
