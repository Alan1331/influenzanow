<?php
session_start();

require __DIR__."../../../../includes/connection.php";
require __DIR__."../../../../includes/globalFunctions.php";
require __DIR__."../../../../includes/influencerlogin/functions.php";

$sns_type = $_GET['sns_type'];

if( hapusSns($_SESSION['inf_username'], $sns_type) > 0 ) {
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