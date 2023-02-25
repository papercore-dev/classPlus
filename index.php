<?php
$load = true;
include 'functions/checkVariable.php';

if (checkVariable($_GET["mode"])){
    header("Location: /static/landing?mode=".$_GET["mode"]);
}
else{
    header("Location: /landing.php");
}
?>