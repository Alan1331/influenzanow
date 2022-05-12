<?php

$dbhost = "localhost";
$dbuser = "phpmyadmin";
$dbpass = "P@ssw0rd1";
$dbname = "login_sample_db";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)) {
    die("failed to connect!");
}

?>