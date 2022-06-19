<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$notif_id = $_GET['notif_id'];
mysqli_query($conn, "UPDATE inf_notifications SET hide = 1 WHERE inf_notif_id = $notif_id");
header('Location: notification.php');

?>