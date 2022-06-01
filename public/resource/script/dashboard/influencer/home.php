<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$inf_username = $_SESSION['inf_username'];
$inf_name = query("SELECT inf_name FROM influencer WHERE inf_username='$inf_username'");

// var_dump($inf_name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Influencer Homepage</title>
</head>
<body>
    <h1>Selamat datang <?= $inf_name[0]['inf_name'] ?></h1>
    <br><br><br><br>
    <p><a href="../../login/influencerlogin/logout.php">logout</a></p>
</body>
</html>