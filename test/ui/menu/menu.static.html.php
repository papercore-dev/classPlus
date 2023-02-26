<?php 
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<style>
    @font-face {
    font-family: 'NEXON Lv2 Gothic';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_20-04@2.1/NEXON Lv2 Gothic.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}
*{
    font-family: 'NEXON Lv2 Gothic', sans-serif;
}
</style>
<!-- Page Main -->
<main class="flex flex-col items-center justify-center mt-32">
    <header class="container">
        <!-- Navbar -->
        <nav
            class="flex justify-between md:justify-around py-4 bg-white shadow-md w-full px-10 fixed top-0 left-0 right-0 z-10 px-8 md:px-3"
            >
            <!-- Logo Container -->
            <div class="flex items-center">
                <!-- Logo -->
                <a class="cursor-pointer" href="/">
                <h3 class="text-2xl font-medium text-gray-500 justify-center my-auto font-bold flex ml-4">
<img class="w-10 " src="/resources/images/classplus_logo_site_landing.png" alt="Class+">
<span class="py-auto my-auto h-full hidden md:block">Class+</span></h3>
                </a>
            </div>

            <!-- Links Section -->
            <div
                class="hidden md:block items-center md:space-x-8 justify-center justify-items-start md:justify-items-center md:flex md:pt-2 w-full left-0 top-16 px-5 md:px-10 py-3 md:py-0 border-t md:border-t-0">
                <a
                    class="flex text-gray-600 hover:text-blue-500 cursor-pointer transition-colors duration-300">
                    소개
                </a>

                <a
                    class="flex text-gray-600 hover:text-blue-500 cursor-pointer transition-colors duration-300">
                    요금 안내
                </a>

                <a
                    class="flex text-gray-600 hover:text-blue-500 cursor-pointer transition-colors duration-300">
                    공지사항
                </a>

            </div>

            <!-- Auth Links -->
            <div class="flex items-center space-x-5">
                <!-- Register -->
                <a
                    class="flex text-gray-600 hover:text-blue-500 cursor-pointer transition-colors duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-5 w-5 mr-2 mt-0.5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
</svg>
                </a>

                <!-- Login -->
                <a
                    class="flex text-gray-600 cursor-pointer transition-colors duration-300 font-semibold text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-5 w-5 mr-2 mt-0.5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
</svg>
                </a>
            </div>
        </nav>
    </header>
