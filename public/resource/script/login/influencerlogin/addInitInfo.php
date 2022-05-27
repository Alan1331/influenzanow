<?php
require '../../../../includes/influencerlogin/functions.php';
require '../../../../includes/connection.php';

$username = $_POST['inf_username'];
$interests = query("SELECT * FROM inf_interest WHERE inf_username='$username'");

// cek apakah tombol add_interest sudah diclick atau belum
if( isset($_POST['add_interest']) ) {

    // cek apakah interest berhasil ditambahkan atau tidak
    if( addInterest($_POST) > 0 ) {
        echo "
                <script>
                    alert('interest berhasil ditambahkan');
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('interest gagal ditambahkan');
                </script>
            ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Information</title>
</head>
<body>
<h1>Input Additional Information</h1>

<h2>Interests</h2>
<form action="" method="post">
    <input type="hidded" name="inf_username" value="<?= $username ?>">
    <ul>
        <li>
            <label for="interest">Add interest</label>
            <input type="text" placeholder="type new interest here!" name="interest" id="interest">
        </li>
        <li>
            <button type="submit" name="add_interest">Add Interest!</button>
        </li>
    </ul>
</form>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No.</th>
        <th>Interest</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach( $interests as $interest ): ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= $interest['interest'] ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
</table>

<br><br>

</body>
</html>