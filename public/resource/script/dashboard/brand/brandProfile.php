<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href = "../../../style/css/brandprofile.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <form action="" method="post">
                <h1>Profile Settings</h1>
                <hr>
                <br>
                <!--<a href="home.php"><--Back to home</a> -->
                <button class="btn btn-primary"><a href="home.php">Back to home</a></button>
                <br>
                <center>
                    <img class="img" src="#">
                </center>
                <br>
                <center>
                    <!--<a href="changeprofile.php">Change Picture ></a>-->
                    <button class="btn btn-primary"><a href="changeprofile.php">Change Picture </a></button>
                </center>
                <br>
                <input type="hidden" name="brand_password">
                <input type="hidden" name="brand_reg_date">
                <input type="hidden" name="brand_logo">
                <div class="input-left">
                    <input type="hidden" name="brand_username">
                    <label for="brand_name">Brand Name</label>
                    <input type="text" id="brand_name" name="brand_name">
                    <label for="brand_email">Email</label>
                    <input type="text" id="brand_email" name="inf_email">
                    <label for="brand_phone_number">Phone Number</label>
                    <input type="text" id="brand_phone_number" name="brand_phone_number">
                    <center><button type="submit" name="update_profile">Save Profile Updates</button></center>
                </div>
                <div class="input-right">
                    <div class="radio">
                    <label for="brand_description">Brand Description</label>
                    <input type="text" id="brand_description" name="brand_description">

                    <label for="brand_sector">Brand Sector</label>
                    <input type="text" id="brand_sector" name="brand_sector">
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>