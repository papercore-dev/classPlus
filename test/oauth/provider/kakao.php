<?php
$load = true;

include '../../config/credentials.php';

define('OAUTH2_CLIENT_ID', $oAuth_client_kakao);
define('OAUTH2_CLIENT_SECRET', $oAuth_secret_kakao);

$authorizeURL = 'https://kauth.kakao.com/oauth/authorize';
$tokenURL = 'https://kauth.kakao.com/oauth/token';
$apiURLBase = 'https://kapi.kakao.com/v2/user/me';
$redirectURL = '/oauth/provider/kakao.php';
$providerName = 'kakao';

include '../../functions/oauthProcess.php';  