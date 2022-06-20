<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$inf_id = $_SESSION['inf_id'];
$erf_id = $_GET['erf_id'];

mysqli_query($conn, "DELETE FROM saved_erf WHERE inf_id = $inf_id AND erf_id = $erf_id");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('ERF berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('ERF gagal dihapus');
                history.go(-1);
            </script>
        ";
    echo mysqli_error($conn);
}

?>