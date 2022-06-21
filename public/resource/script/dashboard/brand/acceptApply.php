<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    if( $_COOKIE['tp'] === hash('sha256', 'brand')) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil username berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan username
        if( $key === hash('sha256', $row['brand_name']) ) {
            $_SESSION['login'] = true;
            $_SESSION['brand_username'] = $row['brand_name'];
        }
    }
}

// cek login
if( !isset($_SESSION['login']) || !isset($_SESSION['brand_username']) ) {
    header('Location: ../../login/brandlogin/login.php');
}

$apply_id = $_GET['apply_id'];
$erf_id = query("SELECT erf_id FROM apply_erf WHERE apply_id = $apply_id")[0]['erf_id'];
$task_list = query("SELECT task_id FROM task WHERE erf_id = $erf_id");
$inf_id = query("SELECT inf_id FROM apply_erf WHERE apply_id = $apply_id")[0]['inf_id'];
$inf_username = query("SELECT inf_username FROM influencer WHERE inf_id = $inf_id")[0]['inf_username'];
$erf_name = query("SELECT erf_name FROM erf WHERE erf_id = $erf_id")[0]['erf_name'];

$result1 = mysqli_query($conn, "UPDATE apply_erf SET apply_status = 'Accepted/Joined' WHERE apply_id = $apply_id");
$notif_desc = "You have accepted to join campaign named " . $erf_name;
$notif_link = "erfDetail.php?erf_id=" . $erf_id;
$result2 = mysqli_query($conn, "INSERT INTO inf_notifications(inf_notif_desc, inf_notif_link, inf_id) VALUES(\"$notif_desc\", \"$notif_link\", $inf_id)");
// input tugas ke task_submission dengan apply_id tertera
foreach( $task_list as $task ) {
    $task_id = $task['task_id'];
    mysqli_query($conn, "INSERT INTO task_submissions(task_id, apply_id, submission_status, erf_id) VALUES($task_id, $apply_id, 'not submitted', $erf_id)");
}

// remove apply notifications
$rm_notif_desc = $inf_username . " apply to your erf named " . $erf_name;
$rm_notify_brand = mysqli_query($conn, "DELETE FROM brand_notifications WHERE brand_notif_desc = \"$rm_notif_desc\"");

if( mysqli_affected_rows($conn) > 0 ) {
    echo "
            <script>
                alert('partisipan berhasil diterima');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('partisipan gagal diterima');
                history.go(-1);
            </script>
        ";
}


?>