<?php

session_start();

if( isset($_SESSION['login']) ) {
    unset($_SESSION['login']);
}
if( isset($_SESSION['inf_id']) ) {
    unset($_SESSION['inf_id']);
}
session_destroy();

if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    setcookie('ghlf', '', time()-3600, '/');
    setcookie('ksla', '', time()-3600, '/');
    setcookie('tp', '', time()-3600, '/');
}

header("Location: login.php");
die;