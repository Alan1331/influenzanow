<?php

function signup($data) {
    global $conn;
    
    $brand_name = test_input($data['brand_name']);
    $brand_email = test_input($data['brand_email']);
    $brand_phone_number = test_input($data['brand_phone_number']);
    $brand_sector = mysqli_real_escape_string($conn, $data['brand_sector']);
    $brand_description = test_input($data['brand_description']);
    $brand_password = mysqli_real_escape_string($conn, $data['brand_password']);
    $brand_password2 = mysqli_real_escape_string($conn, $data['brand_password2']);

    // cek brand name tersedia atau tidak
    $result = mysqli_query($conn, "SELECT brand_name FROM brand WHERE brand_name=\"$brand_name\"");
    if( mysqli_fetch_assoc($result) ) {
        echo "
                <script>
                    alert('brand name tidak tersedia');
                </script>
            ";
        return false;
    }

    // cek konfirmasi password
    if( $brand_password !== $brand_password2 ) {
        echo "
                <script>
                    alert('konfirmasi password tidak sesuai');
                </script>
            ";
        return false;
    }

    // enkripsi password
    $brand_password = password_hash($brand_password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    // \"$brand_name\", \"$brand_email\", \"$brand_password\", \"$brand_sector\", \"$brand_phone_number\", \"$brand_description\"
    $signup_sql = "INSERT INTO brand(brand_name, brand_email, brand_password, brand_sector, brand_phone_number, brand_description) VALUES(\"$brand_name\", \"$brand_email\", \"$brand_password\", \"$brand_sector\", \"$brand_phone_number\", \"$brand_description\")";
    mysqli_query($conn, $signup_sql);

    return mysqli_affected_rows($conn);
}

function updateBrandProfile($data) {
    global $conn;

    $brand_name = $data['brand_name'];
    $brand_email = test_input($data['brand_email']);
    $brand_phone_number = test_input($data['brand_phone_number']);
    $brand_sector = mysqli_real_escape_string($conn, $data['brand_sector']);
    $brand_description = test_input($data['brand_description']);

    $update_sql = "UPDATE brand SET
                        brand_email = \"$brand_email\",
                        brand_phone_number = \"$brand_phone_number\",
                        brand_sector = \"$brand_sector\",
                        brand_description = \"$brand_description\"
                    WHERE brand_name = \"$brand_name\"
                    ";
    mysqli_query($conn, $update_sql);

    return mysqli_affected_rows($conn);
}

?>