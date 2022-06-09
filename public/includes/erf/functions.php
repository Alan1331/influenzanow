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
?>