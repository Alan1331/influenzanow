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

function upload($gambar, $path) {

    $namaFile = $gambar['name'];
    $ukuranFile = $gambar['size'];
    $error = $gambar['error'];
    $tmpName = $gambar['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "
                <script>
                    alert('pilih gambar terlebih dahulu');
                </script>
            ";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "
                <script>
                    alert('hanya diperbolehkan upload gambar');
                </script>
            ";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > (5*1000*1000) ) {
        echo "
                <script>
                    alert('ukuran gambar terlalu besar (maksimal: 5MB)');
                </script>
            ";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, $path . $namaFileBaru);

    return $namaFileBaru;
}

?>