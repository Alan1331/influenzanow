<?php
require '../../../../includes/influencerlogin/functions.php';
require '../../../../includes/connection.php';

if( isset($_POST['inf_signup']) ) {
    
    if( signup($_POST) > 0 ) {
        echo "
                <script>
                    alert('user baru berhasil ditambahkan');
                </script>
            ";
    } else {
        echo mysqli_error($conn);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page Influencer</title>
    <link rel="stylesheet" href = "../../../style/css/regInfluencer.css">
</head>
<center>
<body>
    <div class="container">
        <div class="SignUp">
            <form action="addInitInfo.php" method="post">
                <h1>Sign Up</h1>
                <h3>For Influencer</h3>
                <hr>
                <p>InfluenZa Now</p>
                <label for="inf_name">Full Name</label>
                <input type="text" placeholder="Input Your Name" name="inf_name" id="inf_name">
                <label for="inf_username">Username</label>
                <input type="text" placeholder="Input Your Username" name="inf_username" id="inf_username">
                <label for="inf_email">Email</label>
                <input type="text" placeholder="example@gmail.com" name="inf_email" id="inf_email">
                <label for="inf_gender">Gender</label>
                <!-- <input type="text" placeholder="Male/Female/Others"> -->
                <input type="radio" name="inf_gender" value="M" id="inf_gender">Male
                <input type="radio" name="inf_gender" value="F" id="inf_gender">Female
                <input type="radio" name="inf_gender" value="O" id="inf_gender">Others
                <label for="inf_birthdate">Birthday</label>
                <input type="date" name="inf_birthdate" id="inf_birthdate">
                <label for="inf_phone_number">Phone Number</label>
                <input type="text" placeholder="Your Phone Number" name="inf_phone_number" id="inf_phone_number">
                <label for="inf_address">Address</label>
                <input type="textarea" placeholder="Your Home Address" name="inf_address" id="inf_address" rows="5" cols="30">
                <label for="inf_password">Password</label>
                <input type="password" placeholder="Your Password" name="inf_password" id="inf_password">
                <label for="inf_password2">Confirm Password</label>
                <input type="password" placeholder="Retype Your Password" name="inf_password2" id="inf_password2">
                <button type="submit" name="inf_signup">Sign Up</button>
            </form>
        </div>
    </div>
</center>
</body>
</html>