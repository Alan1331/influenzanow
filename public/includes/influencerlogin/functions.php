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
    $pict = $data['inf_pict'];

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
    // \"$username\", \"$name\", \"$email\", \"$password\", \"$gender\", \"$birthdate\", \"$address\", \"$phone_number\", NOW(), \"$pict\"
    $signup_sql = "INSERT INTO influencer(inf_username, inf_name, inf_email, inf_password, inf_gender, inf_birthdate, inf_address, inf_phone_number, inf_reg_date, inf_pict) VALUES(\"$username\", \"$name\", \"$email\", \"$password\", \"$gender\", \"$birthdate\", \"$address\", \"$phone_number\", NOW(), \"$pict\")";
    mysqli_query($conn, $signup_sql);

    return mysqli_affected_rows($conn);
}

function addInterest($data) {
    global $conn;

    // ambil data interest
    $id = test_input($data['inf_id']);
    $interest = test_input($data['interest']);

    // cek apakah interest sudah ada atau belum
    $sql_check = "SELECT * FROM inf_interest WHERE inf_id = \"$id\" AND interest = \"$interest\"";
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
            \"$id\", \"$interest\")";
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

function hapusInterest($id, $interest) {
    global $conn;
    mysqli_query($conn, "DELETE FROM inf_interest WHERE inf_id = \"$id\" AND interest = \"$interest\"");
    return mysqli_affected_rows($conn);
}

function hapusSns($id, $sns_type) {
    global $conn;
    mysqli_query($conn, "DELETE FROM sns WHERE inf_id = \"$id\" AND sns_type = \"$sns_type\"");
    return mysqli_affected_rows($conn);
}

function updateInfProfile($data) {
    global $conn;
    
    $id = $data['inf_id'];
    $username = strtolower(test_input($data['inf_username']));
    $name = test_input($data['inf_name']);
    $email = test_input($data['inf_email']);
    $gender = $data['inf_gender'];
    $birthdate = $data['inf_birthdate'];
    $phone_number = test_input($data['inf_phone_number']);
    $address = mysqli_real_escape_string($conn, $data['inf_address']);
    $password = $data['inf_password'];
    $reg_date = $data['inf_reg_date'];
    $pict = $data['inf_pict'];
    $diubah = true;

    // cek username diubah atau tidak
    $result1 = query("SELECT * FROM influencer WHERE inf_id = $id AND inf_username = \"$username\"");
    if( isset($result1[0]) ) {
        $diubah = false;
    }

    // jika username diubah
    if( $diubah ) {
        // cek username tersedia atau tidak
        $result2 = mysqli_query($conn, "SELECT inf_username FROM influencer WHERE inf_username = \"$username\"");
        if( mysqli_fetch_assoc($result2) ) {
            echo "
                    <script>
                        alert('username tidak tersedia');
                    </script>
                ";
            return false;
        }
        // update data user
        $update_sql = "UPDATE influencer SET
                            inf_username = \"$username\",
                            inf_name = \"$name\",
                            inf_email = \"$email\",
                            inf_password = \"$password\",
                            inf_gender = \"$gender\",
                            inf_birthdate = \"$birthdate\",
                            inf_address = \"$address\",
                            inf_phone_number = \"$phone_number\",
                            inf_reg_date = \"$reg_date\",
                            inf_pict = \"$pict\"
                        WHERE inf_id = \"$id\"
                        ";
    }
    // jika username tidak diubah
    else {
        // update data user
        $update_sql = "UPDATE influencer SET
                            inf_name = \"$name\",
                            inf_email = \"$email\",
                            inf_password = \"$password\",
                            inf_gender = \"$gender\",
                            inf_birthdate = \"$birthdate\",
                            inf_address = \"$address\",
                            inf_phone_number = \"$phone_number\",
                            inf_reg_date = \"$reg_date\",
                            inf_pict = \"$pict\"
                        WHERE inf_id = $id
                        ";

    }
    mysqli_query($conn, $update_sql);

    return mysqli_affected_rows($conn);
}