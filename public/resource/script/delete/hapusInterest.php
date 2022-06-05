<?php
session_start();

require __DIR__."../../../../includes/connection.php";
require __DIR__."../../../../includes/globalFunctions.php";
require __DIR__."../../../../includes/influencerlogin/functions.php";

$interest = $_GET['interest'];

if( hapusInterest($_SESSION['inf_username'], $interest) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = '../login/influencerlogin/addInitInfo.php';
            </script>
        ";
} else {
    echo "
            <script>
                alert('data gagal dihapus');
                document.location.href = '../login/influencerlogin/addInitInfo.php';
            </script>
        ";
}

?>