<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/influencerlogin/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) ) {
    $id = $_COOKIE['ghlf'];
    $key = $_COOKIE['ksla'];

    // ambil username berdasarkan cookie nya
    $result = mysqli_query($conn, "SELECT inf_name FROM brand WHERE inf_username = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if( $key === hash('sha256', $row['inf_name']) ) {
        $_SESSION['login'] = true;
        $_SESSION['inf_username'] = $row['inf_username'];
    }
}

if( isset($_POST['inf_login']) ) {

    $inf_username = $_POST['inf_username'];
    $inf_password = $_POST['inf_password'];

    $result = mysqli_query($conn, "SELECT * FROM influencer WHERE inf_username = '$inf_username'");

    // cek username
    if( mysqli_num_rows($result) === 1 ) {
        
        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($inf_password, $row['inf_password']) ) {
            // set session
            $_SESSION['login'] = true;
            $_SESSION['inf_username'] = $inf_username;

            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie
                
                setcookie('ghlf', $row['inf_username'], time()+60);
                setcookie('ksla', hash('sha256', $row['inf_name']), time()+60);
            }

            header("Location: ../../dashboard/influencer/home.php");
            exit;
        }

    }

    $error = true;

}
?>

<!DOCTYPE html>
<head>
    <title>Login</title>
</head>
<body>
    
    <style type="text/css">

    #text{
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin #aaa;
        width: 100%;
    }
    
    #button{
        padding: 10px;
        width: 100px;
        color: white;
        background-color: lightblue;
        border: none;
    }

    #box{
        background-color: grey;
        margin: auto;
        width: 300px;
        padding: 20px;
    }

    </style>

    <div id="box">

        <form method="post" action="">
            <div style="font-size: 20px;margin: 10px;color: white;">Login</div>
            <label for="inf_username">Username: </label>
            <input id="inf_username" type="text" name="inf_username" placeholder="Input your username"><br><br>
            <label for="inf_password">Password: </label>
            <input id="inf_password" type="password" name="inf_password" placeholder="Input your password"><br><br>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>

            <input id="button" type="submit" name="inf_login" value="login"><br><br>

            <a href="signup.php">Click to Sign up</a>
        </form>

    </div>
    
</body>
</html>