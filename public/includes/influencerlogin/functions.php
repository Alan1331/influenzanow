<?php

function query( $sql ) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function signup($data) {
    global $conn;
    
    $username = strtolower(test_input($data['inf_username']));
    $name = test_input($data['inf_name']);
    $email = test_input($data['inf_email']);
    $gender = $data['inf_gender'];
    $birthdate = $data['inf_birthdate'];
    $phone_number = test_input($data['inf_phone_number']);
    $address = mysqli_real_escape_string($conn, $data['inf_address']);
    $password = mysqli_real_escape_string($conn, $data['inf_password']);
    $password2 = mysqli_real_escape_string($conn, $data['inf_password2']);

    // cek username tersedia atau tidak
    $result = mysqli_query($conn, "SELECT inf_username FROM influencer WHERE inf_username='$username'");
    if( mysqli_fetch_assoc($result) ) {
        echo "
                <script>
                    alert('username tidak tersedia');
                </script>
            ";
        return false;
    }

    // cek konfirmasi password
    if( $password !== $password2 ) {
        echo "
                <script>
                    alert('konfirmasi password tidak sesuai');
                </script>
            ";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    $signup_sql = "INSERT INTO influencer VALUES('$username', '$name', '$email', '$password', '$gender', '$birthdate', '$address', '$phone_number')";
    mysqli_query($conn, $signup_sql);


    return mysqli_affected_rows($conn);
}

function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function addInterest($data) {
    global $conn;

    // ambil data interest
    $username = test_input($data['inf_username']);
    $interest = test_input($data['interest']);

    $sql = "INSERT INTO inf_interest VALUES(
            '$username', '$interest')";
    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function check_login($conn) {
    global $conn;
    if(isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        $result = mysqli_query($conn,$query);
        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //redirect to login 
    header("Location: login.php");
    die;

}

function random_num($length) {
    $text = "";
    if($length < 5) {
        $length = 5;
    }

    $len = rand(4,$length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0,9);
    }

    return $text;
}