<?php

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
    $signup_sql = "INSERT INTO influencer VALUES(\"$username\", \"$name\", \"$email\", \"$password\", \"$gender\", \"$birthdate\", \"$address\", \"$phone_number\", \"\")";
    mysqli_query($conn, $signup_sql);

    return mysqli_affected_rows($conn);
}

function addInterest($data) {
    global $conn;

    // ambil data interest
    $username = test_input($data['inf_username']);
    $interest = test_input($data['interest']);

    // cek apakah interest sudah ada atau belum
    $sql_check = "SELECT * FROM inf_interest WHERE inf_username = \"$username\" AND interest = \"$interest\"";
    $result = mysqli_query($conn, $sql_check);
    if( mysqli_num_rows($result) > 0 ) {
        echo "
                <script>
                    alert('interest yang sama sudah ditambahkan');
                </script>
            ";
        return false;
    }

    // tambahkan interest sesuai dengan username nya
    $sql_insert = "INSERT INTO inf_interest VALUES(
            \"$username\", \"$interest\")";
    mysqli_query($conn, $sql_insert);

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

function hapusInterest($username, $interest) {
    global $conn;
    mysqli_query($conn, "DELETE FROM inf_interest WHERE inf_username = \"$username\" AND interest = \"$interest\"");
    return mysqli_affected_rows($conn);
}

function hapusSns($username, $sns_type) {
    global $conn;
    mysqli_query($conn, "DELETE FROM sns WHERE inf_username = \"$username\" AND sns_type = \"$sns_type\"");
    return mysqli_affected_rows($conn);
}

function updateInfProfile($data) {
    global $conn;
    
    $username = strtolower(test_input($data['inf_username']));
    $name = test_input($data['inf_name']);
    $email = test_input($data['inf_email']);
    $gender = $data['inf_gender'];
    $birthdate = $data['inf_birthdate'];
    $phone_number = test_input($data['inf_phone_number']);
    $address = mysqli_real_escape_string($conn, $data['inf_address']);
    $password = $data['inf_password'];
    $reg_date = $data['inf_reg_date'];

    // cek username tersedia atau tidak
    // $result = mysqli_query($conn, "SELECT inf_username FROM influencer WHERE inf_username='$username'");
    // if( mysqli_fetch_assoc($result) ) {
    //     echo "
    //             <script>
    //                 alert('username tidak tersedia');
    //             </script>
    //         ";
    //     return false;
    // }

    // update data user
    // INSERT INTO influencer VALUES(\"$username\", \"$name\", \"$email\", \"$password\", \"$gender\", \"$birthdate\", \"$address\", \"$phone_number\", \"\")
    $update_sql = "UPDATE influencer SET
                        inf_username = \"$username\",
                        inf_name = \"$name\",
                        inf_email = \"$email\",
                        inf_password = \"$password\",
                        inf_gender = \"$gender\",
                        inf_birthdate = \"$birthdate\",
                        inf_address = \"$address\",
                        inf_phone_number = \"$phone_number\",
                        inf_reg_date = \"$reg_date\"
                    WHERE inf_username = \"$username\"
                    ";
    mysqli_query($conn, $update_sql);

    return mysqli_affected_rows($conn);
}