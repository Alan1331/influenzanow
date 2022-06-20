<?php

function addSNS($data) {
    global $conn;

    $inf_id = $data['inf_id'];
    $sns_type = strtolower(test_input($data['sns_type']));
    $sns_username = test_input($data['sns_username']);
    $sns_followers = test_input($data['sns_followers']);
    $sns_link = $data['sns_link'];
    if( empty($data['sns_er']) ) {
        $sns_er = null;
    } else {
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
    if( $sns_er != null ) {
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
    $sns_type_sql = "SELECT sns_type FROM sns WHERE inf_id = \"$inf_id\" AND sns_type = \"$sns_type\"";
    $sns_type_query = mysqli_query($conn, $sns_type_sql);
    if( mysqli_fetch_assoc($sns_type_query) ) {
        echo "
                <script>
                    alert('anda pernah menambahkan tipe sns ini');
                </script>
            ";
        return false;
    }
    
    // tambahkan sns baru ke database
    $add_sns_sql = "INSERT INTO sns VALUES(\"$inf_id\", \"$sns_type\", \"$sns_username\", \"$sns_followers\", \"$sns_link\", \"$sns_er\")";
    mysqli_query($conn, $add_sns_sql);

    return mysqli_affected_rows($conn);
}

function getSnsPage($sns_type) {
    switch($sns_type) {
        case "facebook":
            return "fbReg.php";
            break;
        case "instagram":
            return "igReg.php";
            break;
        case "tiktok":
            return "ttReg.php";
            break;
        case "twitter":
            return "twtReg.php";
            break;
        case "youtube":
            return "ytReg.php";
            break;
        default:
            echo "
                    <script>
                        alert('sns type not found');
                    </script>
                ";
    }
}

function updateSNS($data) {
    global $conn;

    $inf_id = $data['inf_id'];
    $sns_type = strtolower(test_input($data['sns_type']));
    $sns_username = test_input($data['sns_username']);
    $sns_followers = test_input($data['sns_followers']);
    $sns_link = $data['sns_link'];
    if( empty($data['sns_er']) ) {
        $sns_er = null;
    } else {
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
    if( $sns_er != null ) {
        if( is_numeric($sns_er) === false ) {
            echo "
                    <script>
                        alert('er yang dimasukkan tidak valid');
                    </script>
                ";
            return false;
        }
    }

    if( $sns_er == null ) {
        // tambahkan sns baru ke database jika er kosong
        $add_sns_sql = "UPDATE sns SET
                            inf_id = \"$inf_id\",
                            sns_type = \"$sns_type\",
                            sns_username = \"$sns_username\",
                            sns_followers = \"$sns_followers\",
                            sns_link = \"$sns_link\"
                        WHERE inf_id = \"$inf_id\" AND sns_type = \"$sns_type\"
                        ";
        mysqli_query($conn, $add_sns_sql);

        return mysqli_affected_rows($conn);
    } else {
        // tambahkan sns baru ke database
        $add_sns_sql = "UPDATE sns SET
                            inf_id = \"$inf_id\",
                            sns_type = \"$sns_type\",
                            sns_username = \"$sns_username\",
                            sns_followers = \"$sns_followers\",
                            sns_link = \"$sns_link\",
                            sns_er = \"$sns_er\"
                        WHERE inf_id = \"$inf_id\" AND sns_type = \"$sns_type\"
                        ";
        mysqli_query($conn, $add_sns_sql);
    
        return mysqli_affected_rows($conn);
    }
    
}

?>