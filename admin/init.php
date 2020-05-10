<?php
include 'includes/languages/english.php';
include 'includes/functions/functions.php';
$tpl = 'includes/templates/';
$css = 'layout/css/';
include 'connect.php';
//include $tpl.'header.php';



if(!isset($noNavbar)){
    include $tpl .'navbar.php';
}
//include $tpl.'footer.php';
?>