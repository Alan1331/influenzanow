<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$apply_id = $_GET['apply_id'];

mysqli_query($conn, "UPDATE apply_erf SET apply_status = 'Done' WHERE apply_id = $apply_id");
mysqli_query($conn, "UPDATE task_submissions SET submission_status = 'Done' WHERE apply_id = $apply_id");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('ERF telah terpenuhi, enjoy your reward');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('Gagal menyelesaikan ERF karena kesalahan sistem');
                history.go(-1);
            </script>
        ";
}

?>