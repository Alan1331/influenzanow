<?php
session_start();

require __DIR__."../../../../includes/connection.php";
require __DIR__."../../../../includes/globalFunctions.php";
require __DIR__."../../../../includes/influencerlogin/functions.php";

$interest = $_GET['interest'];
$inf_id = $_SESSION['inf_id'];
$interest_sum = count(query("SELECT * FROM inf_interest WHERE inf_id = $inf_id"));

if( $interest_sum == 1 ) {
    echo "
            <script>
                alert('tidak dapat menghapus data terakhir, minimal wajib ada 1 interest!');
                history.go(-1);
            </script>
        ";
    exit;
}

if( hapusInterest($inf_id, $interest) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('data gagal dihapus');
                history.go(-1);
            </script>
        ";
}

?>