<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$erf_id = $_GET['erf_id'];
$inf_id = $_SESSION['inf_id'];

$cari = mysqli_query($conn, "SELECT * FROM apply_erf WHERE erf_id = $erf_id AND inf_id = $inf_id");
$jumlah_cari = mysqli_num_rows($cari);
$brand_id = query("SELECT brand_id FROM erf WHERE erf_id = $erf_id")[0]['brand_id'];
$inf_username = query("SELECT inf_username FROM influencer WHERE inf_id = $inf_id")[0]['inf_username'];
$erf_name = query("SELECT erf_name FROM erf WHERE erf_id = $erf_id")[0]['erf_name'];

// cek apakah erf sudah diajukan atau belum
if( $jumlah_cari < 1 ) {

    $result = mysqli_query($conn, "INSERT INTO apply_erf(apply_status, erf_id, inf_id) VALUES('Waiting for Approval', $erf_id, $inf_id)");
    
    // send notification to brand
    $notif_desc = $inf_username . " apply to your erf named " . $erf_name;
    $notif_link = "viewERF.php?erf_id=" . $erf_id;
    $notify_brand = mysqli_query($conn, "INSERT INTO brand_notifications(brand_notif_desc, brand_notif_link, brand_id) VALUES(\"$notif_desc\", \"$notif_link\", $brand_id)");

    if( mysqli_affected_rows($conn) > 0 ) {
        echo "
                <script>
                    alert('ERF berhasil diajukan, silahkan menunggu untuk persetujuan!');
                    history.go(-1);
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('ERF gagal diajukan');
                    history.go(-1);
                </script>
            ";
    }
} else {
    echo "
            <script>
                alert('anda sudah mengajukan erf ini');
                history.go(-1);
            </script>
        ";
}

?>