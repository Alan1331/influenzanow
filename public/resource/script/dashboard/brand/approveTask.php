<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$submission_id = $_GET['submission_id'];

mysqli_query($conn, "UPDATE task_submissions SET submission_status = 'approved' WHERE submission_id = $submission_id");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('tugas influencer berhasil disetujui');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('tugas influencer gagal disetujui');
                history.go(-1);
            </script>
        ";
}

?>