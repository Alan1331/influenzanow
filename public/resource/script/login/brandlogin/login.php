<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/brandlogin/functions.php';

if( isset($_POST['brand_login']) ) {

    $brand_name = $_POST['brand_name'];
    $brand_password = $_POST['brand_password'];
    $sql = "SELECT * FROM brand WHERE brand_name = '$brand_name'";

    $result = mysqli_query($conn, $sql);

    // cek name
    if( mysqli_num_rows($result) === 1 ) {
        
        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($brand_password, $row['brand_password']) ) {
            echo "password valid";
            // set session
            $_SESSION['login'] = true;
            $_SESSION['brand_username'] = $brand_name;

            // cek remember me
            // if( isset($_POST['remember']) ) {
            //     // buat cookie
                
            //     setcookie('ghlf', $row['id'], time()+60);
            //     setcookie('ksla', hash('sha256', $row['username']), time()+60);
            // }

            header("Location: ../../dashboard/brand/home.php");
            exit;
        } else {
            echo "password invalid";
        }

    }

    // echo $sql;

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
            <label for="brand_name">Brand Name: </label>
            <input id="brand_name" type="text" name="brand_name" placeholder="Input your brand name"><br><br>
            <label for="brand_password">Password: </label>
            <input id="brand_password" type="password" name="brand_password" placeholder="Input your password"><br><br>

            <input id="button" type="submit" name="brand_login" value="login"><br><br>

            <a href="signup.php">Click to Sign up</a>
        </form>

    </div>
    
</body>
</html>