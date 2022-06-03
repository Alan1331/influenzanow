<?php

function addSNS($data) {
    global $conn;

    $inf_username = strtolower(test_input($data['inf_username']));
    $sns_type = strtolower(test_input($data['sns_type']));
    $sns_username = test_input($data['sns_username']);
    $sns_followers = test_input($data['sns_followers']);
    $sns_link = $data['sns_link'];
    if( isset($data['sns_er']) ) {
        $sns_er = $data['sns_er'];
    }

    // validasi link
    if( !filter_var($sns_link, FILTER_VALIDATE_URL) ) {
        echo "
                <script>
                    alert('link sns tidak valid');
                </script>
            ";
        return false;
    }

    // validasi er
    if( isset($data['sns_er']) ) {
        if( is_numeric($sns_er) === false ) {
            echo "
                    <script>
                        alert('er yang dimasukkan tidak valid');
                    </script>
                ";
            return false;
        }
    }


    // cek tipe sns tersedia atau tidak
    $sns_type_sql = "SELECT sns_type FROM sns WHERE inf_username = \"$inf_username\" AND sns_type = \"$sns_type\"";
    $sns_type_query = query($sns_type_sql);
    if( mysqli_fetch_assoc($sns_type_query) ) {
        echo "
                <script>
                    alert('anda pernah menambahkan tipe sns ini');
                </script>
            ";
        return false;
    }
    
    // tambahkan sns baru ke database
    $add_sns_sql = "INSERT INTO sns VALUES(\"$inf_username\", \"$sns_type\", \"$sns_username\", \"$sns_followers\", \"$sns_link\", \"$sns_er\")";
    mysqli_query($conn, $add_sns_sql);

    return mysqli_affected_rows($conn);
    
}

?>