<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));
include '../config/credentials.php';
chdir(dirname(__FILE__));

setLocale(LC_ALL, 'ko_KR.UTF8');
$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
