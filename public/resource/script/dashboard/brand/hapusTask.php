<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$task_id = $_GET['task_id'];

if( remove_task($task_id) > 0 ) {
    echo "
            <script>
                alert('task berhasil dihapus');
                history.go(-1);
            </script>
        ";
} else {
    echo "
            <script>
                alert('task gagal dihapus');
                history.go(-1);
            </script>
        ";
}

?>