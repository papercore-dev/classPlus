<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<style>
.bottomNav{display: none!important;}
</style>
<nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
               <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                  <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
               </button>
               <a href="#" class="text-xl font-bold flex items-center lg:ml-2.5">
               <img src="/resources/images/classplus_logo_site_landing.png" class="h-6 mr-2" alt="Class+ Logo">
               <span class="self-center whitespace-nowrap">
                <?php echo $headName;?>
               </span>
               </a>
            </div>
         </div>
      </div>
   </nav>
   <div class="flex overflow-hidden bg-white pt-16">
      <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
         <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
               <div class="flex-1 px-3 bg-white divide-y space-y-1">
                  <ul class="space-y-2 pb-2">
                     <li>
                     </li>
                     <li>
                        <a href="/dashboard" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                           <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                           </svg>
                           <span class="ml-3">대시보드</span>
                        </a>
                     </li>
                     <li>
                        <a href="/dashboard/userManage.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                           <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                           </svg>
                           <span class="ml-3 flex-1 whitespace-nowrap">사용자 관리</span>
                        </a>
                     </li>
                     <li>
                        <a href="/dashboard/inviteManage.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                           <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                           </svg>
                           <span class="ml-3 flex-1 whitespace-nowrap">(구) 초대장</span>
                        </a>
                     </li>
                     <li>
                        <a href="/dashboard/boardManage.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                           <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                           </svg>
                           <span class="ml-3 flex-1 whitespace-nowrap">게시판</span>
                        </a>
                     </li>
                     <li>
                        <a href="/dashboard/callMeal.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                           <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
 <path d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
  <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z" clip-rule="evenodd" />
</svg>

                           <span class="ml-3 flex-1 whitespace-nowrap">급식 진동벨</span>
                        </a>
                     </li>
                  </ul>
                  <div class="space-y-2 pt-2">
                     <a href="/app.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
</svg>

                        <span class="ml-4">클래스+로 돌아가기</span>
                     </a>
                     <a href="/" target="_blank" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                        <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                           <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">사용 신청하기</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </aside>

   <script async defer src="https://buttons.github.io/buttons.js"></script>
   <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>

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