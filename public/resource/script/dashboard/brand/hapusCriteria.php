<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

$erf_id = $_GET['erf_id'];
$criteria = $_GET['criteria'];

query("DELETE FROM inf_criteria WHERE erf_id = $erf_id AND criteria = \"$criteria\"");

header('Location: newERF.php');

?>