<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$erf_id = $_GET['erf_id'];
$link = $_GET['link'];

if( remove_ref_link($erf_id, $link) > 0 ) {
    echo "
            <script>
                alert('reference link berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('reference link gagal dihapus');
                history.go(-1);
            </script>
        ";
}

?>