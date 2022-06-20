<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$inf_id = $_SESSION['inf_id'];
$erf_id = $_GET['erf_id'];

mysqli_query($conn, "INSERT INTO saved_erf(inf_id, erf_id) VALUES($inf_id, $erf_id)");

echo "
    <script>
        history.go(-1);
    </script>
    ";

?>