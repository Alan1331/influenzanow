<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';

$erf_id = $_GET['erf_id'];
$inf_id = $_SESSION['inf_id'];

$cari = mysqli_query($conn, "SELECT * FROM apply_erf WHERE erf_id = $erf_id AND inf_id = $inf_id");
$jumlah_cari = mysqli_num_rows($cari);

// cek apakah erf sudah diajukan atau belum
if( $jumlah_cari < 1 ) {

    $result = mysqli_query($conn, "INSERT INTO apply_erf(apply_status, erf_id, inf_id) VALUES('Waiting for Approval', $erf_id, $inf_id)");

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