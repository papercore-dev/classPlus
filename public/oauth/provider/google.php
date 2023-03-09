<?php
$load = true;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

include '../../config/credentials.php';
chdir(dirname(__FILE__));
define('OAUTH2_CLIENT_ID', $oAuth_client_google); //Your client Id
define('OAUTH2_CLIENT_SECRET', $oAuth_secret_google); //Your secret client code

$authorizeURL = 'https://accounts.google.com/o/oauth2/v2/auth';
$tokenURL = 'https://www.googleapis.com/oauth2/v4/token';
$apiURLBase = 'https://www.googleapis.com/oauth2/v3/userinfo';

$redirectURL = '/oauth/provider/google.php';
$providerName = 'google';

include '../../functions/oauthProcess_d.php';
chdir(dirname(__FILE__));  