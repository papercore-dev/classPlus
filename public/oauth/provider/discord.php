<?php
$load = true;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

include '../../config/credentials.php';
chdir(dirname(__FILE__));
define('OAUTH2_CLIENT_ID', $oAuth_client_discord); //Your client Id
define('OAUTH2_CLIENT_SECRET', $oAuth_secret_discord); //Your secret client code

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

$redirectURL = '/oauth/provider/discord.php';
$providerName = 'discord';

include '../../functions/oauthProcess_d.php';
chdir(dirname(__FILE__));  