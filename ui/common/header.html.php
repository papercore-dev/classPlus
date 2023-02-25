<?php
$load = true;
chdir(dirname(__FILE__));
include './../../security.php';

if (session_status() === PHP_SESSION_NONE){
    session_start();
    ob_start();
}

date_default_timezone_set('Asia/Seoul');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './../../database/adapter_db.php';
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
  <link rel="shortcut icon" href="/favicon.ico">

<link rel="manifest" href="manifest.json">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

*{
  font-family: 'Pretendard-Regular', sans-serif;
-webkit-font-smoothing: antialiased;
}
.font-semibold .font-bold .font-black{
font-family: 'Pretendard-Bold', sans-serif!important;
}
@font-face {
    font-family: 'Pretendard-Regular';
    src: url('https://cdn.jsdelivr.net/gh/Project-Noonnu/noonfonts_2107@1.1/Pretendard-Regular.woff') format('woff');
    font-weight: 400;
    font-style: normal;
}
@font-face {
    font-family: 'Pretendard-Bold';
    src: url('https://cdn.jsdelivr.net/gh/Project-Noonnu/noonfonts_2107@1.1/Pretendard-Bold.woff') format('woff');
    font-weight: 700;
    font-style: normal;
}
</style>

<script type="module">
  import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo@7.1.0';
</script>

<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
