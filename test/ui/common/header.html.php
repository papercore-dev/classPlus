<?php
$load = true;
chdir(dirname(__FILE__));
include './../../security.php';
chdir(dirname(__FILE__));

if (session_status() === PHP_SESSION_NONE){
  ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
  ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
    session_start();
    ob_start();
}

date_default_timezone_set('Asia/Seoul');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './../../database/adapter_db.php';
chdir(dirname(__FILE__));
?>
<!DOCTYPE html>

<html>
    <head>
    <title>Class+</title>
  <meta charset="utf-8">
  <meta name="referrer" content="origin">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://classplus.pcor.me/resources/images/og_image.png">
  <meta property="og:url" content="https://classplus.pcor.me">
  <meta property="og:site_name" content="Class+">
  <meta property="og:title" content="Class+">
  <meta property="og:description" content="학급생활에 재미를 붙여주는 클래스+를 이용하여 시간표와 각종 커뮤니티 서비스를 이용해보세요">
  <meta name="description" content="학급생활에 재미를 붙여주는 클래스+를 이용하여 시간표와 각종 커뮤니티 서비스를 이용해보세요">
  <meta name="keywords" content="클래스+, 클래스플러스, classplus, class+, 학교커뮤니티, 클래스팅, 스쿨투게더, 학교종이, 학교 커뮤니티">
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
</style>

<script type="module">
  import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo@7.1.0';
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