<?php
session_start();

require __DIR__."../../../../includes/connection.php";
require __DIR__."../../../../includes/globalFunctions.php";
require __DIR__."../../../../includes/influencerlogin/functions.php";

$sns_type = $_GET['sns_type'];
$inf_username = $_SESSION['inf_username'];

$sns_sum = count(query("SELECT * FROM sns WHERE inf_username = \"$inf_username\""));

if( $sns_sum == 1 ) {
    echo "
            <script>
                alert('tidak dapat menghapus data terakhir, minimal wajib ada 1 sns!');
                history.go(-1);
            </script>
        ";
    exit;
}

if( hapusSns($inf_username, $sns_type) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus');
                history.go(-2);
            </script>
        ";
} else {
    echo "
            <script>
                alert('data gagal dihapus');
                history.go(-2);
            </script>
        ";
}

?>