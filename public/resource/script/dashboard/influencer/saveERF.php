<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$inf_id = $_SESSION['inf_id'];
$erf_id = $_GET['erf_id'];

mysqli_query($conn, "INSERT INTO saved_erf(inf_id, erf_id) VALUES($inf_id, $erf_id)");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('ERF berhasil disimpan');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('ERF gagal disimpan');
                history.go(-1);
            </script>
        ";
    echo mysqli_error($conn);
}

?>