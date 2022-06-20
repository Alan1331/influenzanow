<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$submission_id = $_GET['submission_id'];

mysqli_query($conn, "UPDATE task_submissions SET submission_status = 'approved' WHERE submission_id = $submission_id");
$task_id = query("SELECT task_id FROM task_submissions WHERE submission_id = $submission_id")[0]['task_id'];
$task_name = query("SELECT task_name FROM task WHERE task_id = $task_id")[0]['task_name'];
$apply_erf = query("SELECT * FROM task_submissions WHERE submission_id = $submission_id")[0];
$apply_id = $apply_erf['apply_id'];
$erf_id = $apply_erf['erf_id'];
$inf_id = query("SELECT inf_id FROM apply_erf WHERE apply_id = $apply_id")[0]['inf_id'];

// kirim notifikasi ke influencer
$notif_desc = "Your work on task named " . $task_name . " was approved by the brand";
$notif_link = "erfDetail.php?erf_id=" . $erf_id;
mysqli_query($conn, "INSERT INTO inf_notifications(inf_notif_desc, inf_notif_link, inf_id) VALUES(\"$notif_desc\", \"$notif_link\", $inf_id)");

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