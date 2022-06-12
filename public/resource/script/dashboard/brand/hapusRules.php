<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$rules_id = $_GET['rules_id'];

if( remove_rules($rules_id) > 0 ) {
    echo "
            <script>
                alert('rules berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('rules gagal dihapus');
                history.go(-1);
            </script>
        ";
}

?>