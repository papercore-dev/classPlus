<?php
$load = true;
include 'functions/checkVariable.php';
chdir(dirname(__FILE__));

if (checkVariable($_GET["mode"], "standalone")){
    header("Location: /static/landing?mode=".$_GET["mode"]);
}
else{
    header("Location: /landing.php");
}
?>