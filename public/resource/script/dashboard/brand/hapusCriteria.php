<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$erf_id = $_GET['erf_id'];
$criteria = $_GET['criteria'];

if( remove_criteria($erf_id, $criteria) > 0 ) {
    echo "
            <script>
                alert('kriteria berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('kriteria gagal dihapus');
                history.go(-1);
            </script>
        ";
}

?>