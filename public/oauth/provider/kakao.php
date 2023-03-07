<?php
$load = true;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

include '../../config/credentials.php';
chdir(dirname(__FILE__));
define('OAUTH2_CLIENT_ID', $oAuth_client_kakao);
define('OAUTH2_CLIENT_SECRET', $oAuth_secret_kakao);

$authorizeURL = 'https://kauth.kakao.com/oauth/authorize';
$tokenURL = 'https://kauth.kakao.com/oauth/token';
$apiURLBase = 'https://kapi.kakao.com/v2/user/me';
$redirectURL = '/oauth/provider/kakao.php';
$providerName = 'kakao';

include '../../functions/oauthProcess.php';
chdir(dirname(__FILE__));  