<?php
function setERF($data, $erf_draft, $brand_id) {
    global $conn;

    $erf_pict = $data['erf_pict'];
    $erf_name = test_input($data['erf_name']);
    $product_name = test_input($data['product_name']);
    $product_price = $data['product_price'];
    $gen_brief = test_input($data['gen_brief']);
    $negotiation = $data['negotiation'];

    // jika tidak ada draft, maka insert
    if( empty($erf_draft) ) {
        $sql = "INSERT INTO erf
        (
            erf_pict, erf_name, product_name, product_price, gen_brief, negotiation, brand_id, erf_status
        )
        VALUES
        (
            \"$erf_pict\",\"$erf_name\", \"$product_name\", \"$product_price\", \"$gen_brief\", $negotiation, $brand_id, 'drafted'
        )";
        $result = mysqli_query($conn, $sql);
    } else {
        $erf_id = $erf_draft['erf_id'];
        $sql = "UPDATE erf SET
                    erf_pict = \"$erf_pict\",
                    erf_name = \"$erf_name\",
                    product_name = \"$product_name\",
                    product_price = \"$product_price\",
                    gen_brief = \"$gen_brief\",
                    negotiation = $negotiation
                WHERE erf_id = $erf_id";
        $result = mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
}

function add_criteria($data, $erf_id) {
    global $conn;

    $criteria = test_input($data['inf_criteria']);

    $result = mysqli_query($conn, "INSERT INTO inf_criteria VALUES($erf_id, \"$criteria\")");

    return mysqli_affected_rows($conn);
}

function add_ref_link($data, $erf_id) {
    global $conn;

    $link = $data['ref_link'];
    // validasi link
    if( !filter_var($link, FILTER_VALIDATE_URL) ) {
        echo "
                <script>
                    alert('reference link tidak valid');
                </script>
            ";
        return false;
    }

    $result = mysqli_query($conn, "INSERT INTO ref_link VALUES($erf_id, \"$link\")");

    return mysqli_affected_rows($conn);
}

?>