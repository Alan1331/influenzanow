<?php
session_start();

require __DIR__."../../../../includes/connection.php";
require __DIR__."../../../../includes/globalFunctions.php";
require __DIR__."../../../../includes/influencerlogin/functions.php";

$interest = $_GET['interest'];
$inf_username = $_SESSION['inf_username'];

$interest_sum = count(query("SELECT * FROM inf_interest WHERE inf_username = \"$inf_username\""));

if( $interest_sum == 1 ) {
    echo "
            <script>
                alert('tidak dapat menghapus data terakhir, minimal wajib ada 1 interest!');
                history.go(-1);
            </script>
        ";
    exit;
}

if( hapusInterest($inf_username, $interest) > 0 ) {
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