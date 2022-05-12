<?php

$dbhost = "localhost";
$dbuser = "phpmyadmin";
$dbpass = "P@ssw0rd1";
$dbname = "influenzanow";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)) {
    die("failed to connect!");
}

?>