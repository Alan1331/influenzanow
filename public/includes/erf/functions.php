<?php
function setERF($data, $erf_draft, $brand_id, $erf_pict) {
    global $conn;

    $erf_name = test_input($data['erf_name']);
    $product_name = test_input($data['product_name']);
    $product_price = $data['product_price'];
    $gen_brief = test_input($data['gen_brief']);
    $negotiation = $data['negotiation'];

    // jika tidak ada draft, maka insert
    if( !isset($erf_draft['erf_id']) ) {
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

function set_task($data, $task_draft, $erf_id) {
    global $conn;

    $task_name = test_input($data['task_name']);
    $task_deadline = $data['task_deadline'];
    $brief = test_input($data['brief']);

    if( !isset($task_draft['task_id']) ) {
        $sql = "INSERT INTO task(
            task_name, task_deadline, task_status, brief, erf_id
        ) VALUES(
            \"$task_name\", \"$task_deadline\", 'drafted', \"$brief\", $erf_id
        )";
        $result = mysqli_query($conn, $sql);
    } else {
        $task_id = $task_draft['task_id'];
        $sql = "UPDATE task SET
            task_name = \"$task_name\",
            task_deadline = \"$task_deadline\",
            brief = \"$brief\"
        WHERE task_id = $task_id";
        $result = mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
}

function add_rules($rules, $task_id, $rules_type) {
    global $conn;

    $rules = test_input($rules);

    if( $rules == '' ) {
        return false;
    }

    mysqli_query($conn, "INSERT INTO rules_list VALUES('', $task_id, \"$rules\", \"$rules_type\")");

    return mysqli_affected_rows($conn);
}

function add_task($task_draft) {
    global $conn;

    $task_id = $task_draft['task_id'];

    mysqli_query($conn, "UPDATE task SET task_status = 'added' WHERE task_id = $task_id");

    return mysqli_affected_rows($conn);
}

function remove_task($task_id) {
    global $conn;

    $sql = "DELETE FROM task WHERE task_id = $task_id";
    $result = mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function remove_criteria($erf_id, $criteria) {
    global $conn;

    $sql = "DELETE FROM inf_criteria WHERE erf_id = $erf_id AND criteria = \"$criteria\"";
    $result = mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function remove_ref_link($erf_id, $link) {
    global $conn;

    $sql = "DELETE FROM ref_link WHERE erf_id = $erf_id AND link = \"$link\"";
    $result = mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function remove_rules($rules_id) {
    global $conn;

    $sql = "DELETE FROM rules_list WHERE rules_id = $rules_id";
    $result = mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function check_erf_criteria($erf_id) {
    global $conn;

    $sql = "SELECT * FROM inf_criteria WHERE erf_id = $erf_id";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result);
}

function check_erf_task($erf_id) {
    global $conn;

    $sql = "SELECT * FROM task WHERE erf_id = $erf_id";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result);
}

function post_erf($erf_id) {
    global $conn;

    mysqli_query($conn, "UPDATE erf SET erf_status = 'posted' WHERE erf_id = $erf_id");

    return mysqli_affected_rows($conn);
}

function check_draft_task($erf_id) {
    global $conn;

    $sql = "SELECT * FROM task WHERE erf_id = $erf_id AND task_status = 'drafted'";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result);
}

?>