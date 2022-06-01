<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$brand_name = $_SESSION['brand_username'];

// var_dump($inf_name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Homepage</title>
</head>
<body>
    <h1>Selamat datang <?= $brand_name ?></h1>
    <br><br><br><br>
    <p><a href="../../login/brandlogin/logout.php">logout</a></p>
</body>
</html>