<?php

function query( $sql ) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function random_num($length) {
    $text = "";
    if($length < 5) {
        $length = 5;
    }

    $len = rand(4,$length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0,9);
    }

    return $text;
}

?>