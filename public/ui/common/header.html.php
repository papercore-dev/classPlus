<?php
$load = true;
chdir(dirname(__FILE__));
include './../../security.php';
chdir(dirname(__FILE__));

if (session_status() === PHP_SESSION_NONE){
    session_start();
    ob_start();
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30 * 30);
  ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30 * 30);
}

//if hostname is classplus-test.pcor.me, enable error reporting
if ($_SERVER['HTTP_HOST'] == 'classplus-test.pcor.me'){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

date_default_timezone_set('Asia/Seoul');



include './../../database/adapter_db.php';
chdir(dirname(__FILE__));
?>
<!DOCTYPE html>

<html>
    <head>
    <title>Calendar+<?php
    if ($_SERVER['HTTP_HOST'] == 'classplus-test.pcor.me'){
      echo " [TEST]";
    }
    ?>
    </title>
  <meta charset="utf-8">
  <meta name="referrer" content="origin">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://classplus.pcor.me/resources/images/og_image.png">
  <meta property="og:url" content="https://classplus.pcor.me">
  <meta property="og:site_name" content="Calendar+<?php
    if ($_SERVER['HTTP_HOST'] == 'classplus-test.pcor.me'){
      echo " [TEST]";
    }
    ?>">
  <meta property="og:title" content="Calendar+<?php
    if ($_SERVER['HTTP_HOST'] == 'classplus-test.pcor.me'){
      echo " [TEST]";
    }
    ?>">
  <meta property="og:description" content="달력에 재미를 붙여주는 캘린더+를 이용하여 시간표와 각종 커뮤니티 서비스를 이용해보세요">
  <meta name="description" content="달력에 재미를 붙여주는 캘린더+를 이용하여 시간표와 각종 커뮤니티 서비스를 이용해보세요">
  <meta name="keywords" content="캘린더+, 클래스플러스, classplus, Calendar+, 학교커뮤니티, 클래스팅, 스쿨투게더, 학교종이, 학교 커뮤니티">
  <link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">

<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="preconnect" href="https://cdn.jsdelivr.net" />
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
<link href="https://cdn.jsdelivr.net/gh/toss/tossface/dist/tossface.css" rel="stylesheet" type="text/css" />
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<style>
  .tossface {
  font-family: Tossface;
}

@font-face {
    font-family: 'LINESeedKR-Rg';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_11-01@1.0/LINESeedKR-Rg.woff2') format('woff2');
    font-weight: 400;
    font-style: normal;
}
@font-face {
    font-family: 'LINESeedKR-Bd';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_11-01@1.0/LINESeedKR-Bd.woff2') format('woff2');
    font-weight: 700;
    font-style: normal;
}

body {
    font-family: 'LINESeedKR-Rg'!important;
}
.font-bold, .font-semibold, strong, .font-heavy, .font-black, em{
    font-family: 'LINESeedKR-Bd'!important;
}
</style>
<style>
#toast {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  text-align: center;
  padding: 16px;
  position: fixed;
  z-index: 999;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
  background-color: rgba(0,0,0,.8);
  color:#fff;
  border-radius: 999px;
  backdrop-filter: blur(2px);
}

#toast.show {
  visibility: visible;
  -webkit-animation: fadein 0.35s, fadeout 0.5s 2.5s;
  animation: fadein 0.35s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

a {
    -webkit-tap-highlight-color: transparent;
}

[x-cloak] { display: none, opacity:0; }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script type="module">
  import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo@7.1.0';
  
</script>
<script>
    if (typeof navigator.serviceWorker !== 'undefined') {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
  }
</script>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $API_googleAnalytics;?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $API_googleAnalytics;?>');
</script>
<style>
  [x-cloak]{
    display: none;
    opacity: 0;
  }
</style>
</head>
<body class="min-h-screen">
<div id="toast"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block text-yellow-500">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
</svg>
 <span id="toastTxt"></span></div>
 <script>
function toastShow(text) {
  var x = document.getElementById("toast");
  var y = document.getElementById("toastTxt");
  y.innerHTML = text;
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

<?php if (isset($_GET["error"])){
  echo "toastShow('".$_GET["error"]."');";
}
?>
</script>
<div id="modal" class="min-h-screen py-6 flex flex-col justify-center sm:py-12 fixed z-50 inset-0 overflow-y-auto h-full w-full px-4" style="background-color:rgba(0,0,0,0.5);"
x-data="{ open: false }" x-show="open" x-cloak   
        x-transition:enter-start="opacity-0 scale-90" 
        x-transition:enter="transition duration-200 transform ease"
        x-transition:leave="transition duration-200 transform ease"
        x-transition:leave-end="opacity-0 scale-90">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow relative dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-gray-900 text-xl lg:text-2xl font-semibold dark:text-white" id="modalTitle">
                        
                    </h3>
                    <button @click="open = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-gray-500 text-base leading-relaxed dark:text-gray-400" id="modalContent">
                        
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex space-x-2 items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                <a href="#" id="modalPrimaryLink">    
                <button @click="open = false" id="modalPrimaryButton" data-modal-toggle="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"></button>
</a>
                <a href="#" id="modalSecondaryLink">
                <button @click="open = false" id="modalSecondaryButton" data-modal-toggle="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600"></button>
</a>  
              </div>
            </div>
</div>
<script>
  function showModal(modalTitle, modalContent, modalPrimaryName, modalPrimaryLink, modalSecondaryName, modalSecondaryLink){
    var x = document.getElementById("modal");
    x.setAttribute("x-data", "{ open: true }");

    var y = document.getElementById("modalTitle");
    y.innerHTML = modalTitle;

    var z = document.getElementById("modalContent");
    z.innerHTML = modalContent;

    var a = document.getElementById("modalPrimaryButton");
    a.innerHTML = modalPrimaryName;

    var b = document.getElementById("modalPrimaryLink");
    b.setAttribute("href", modalPrimaryLink);

    if (modalSecondaryName !== ""){
    var c = document.getElementById("modalSecondaryButton");
    c.innerHTML = modalSecondaryName;

    var d = document.getElementById("modalSecondaryLink");
    d.setAttribute("href", modalSecondaryLink);
    } else {
    //hide secondary button
    var c = document.getElementById("modalSecondaryButton");
    c.style.display = "none";

    var d = document.getElementById("modalSecondaryLink");
    d.style.display = "none";
    }
  }
</script>