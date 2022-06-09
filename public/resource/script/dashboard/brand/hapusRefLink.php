<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$erf_id = $_GET['erf_id'];
$link = $_GET['link'];

query("DELETE FROM ref_link WHERE erf_id = $erf_id AND link = \"$link\"");

header('Location: newERF.php');

?>