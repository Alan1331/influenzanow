<?php

session_start();

if( isset($_SESSION['login']) ) {
    unset($_SESSION['login']);
}
if( isset($_SESSION['inf_username']) ) {
    unset($_SESSION['inf_username']);
}
session_destroy();

if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    setcookie('ghlf', '', time()-3600, '/');
    setcookie('ksla', '', time()-3600, '/');
    setcookie('tp', '', time()-3600, '/');
}

header("Location: login.php");
die;