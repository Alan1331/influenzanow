<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$apply_id = $_GET['apply_id'];
$inf_id = $_SESSION['inf_id'];

// cek apakah pengajuan sudah ditolak sebelumnya
$apply_check = mysqli_query($conn, "SELECT apply_id FROM apply_erf WHERE apply_id = $apply_id");
if( mysqli_num_rows($apply_check) < 1 ) {
    header('Location: erfDetail.php');
}

$erf_id = query("SELECT erf_id FROM apply_erf WHERE apply_id = $apply_id")[0]['erf_id'];
$brand_id = query("SELECT brand_id FROM erf WHERE erf_id = $erf_id")[0]['brand_id'];
$inf_username = query("SELECT inf_username FROM influencer WHERE inf_id = $inf_id")[0]['inf_username'];
$erf_name = query("SELECT erf_name FROM erf WHERE erf_id = $erf_id")[0]['erf_name'];

$result = mysqli_query($conn, "DELETE FROM apply_erf WHERE apply_id = $apply_id");

// remove apply notification for brand
$notif_desc = $inf_username . " apply to your erf named " . $erf_name;
$notify_brand = mysqli_query($conn, "DELETE FROM brand_notifications WHERE brand_notif_desc = \"$notif_desc\"");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('Pengajuan ERF berhasil dibatalkan');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('Pengajuan ERF gagal dibatalkan');
                history.go(-1);
            </script>
        ";
}

?>