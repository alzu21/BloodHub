<?php
// Include database connection
include 'db_connection.php';

// Check if request ID, status, and hospital name are provided in the GET request
if (isset($_GET['request_id'], $_GET['status'], $_GET['hospital_name'])) {
    // Sanitize input
    $request_id = mysqli_real_escape_string($conn, $_GET['request_id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $hospital_name = mysqli_real_escape_string($conn, $_GET['hospital_name']);

    // Check if the request ID already exists in the request_status table
    $check_query = "SELECT * FROM request_status WHERE request_id = '$request_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing record
        $update_query = "UPDATE request_status SET status = '$status', hospital_name = '$hospital_name', blood_bank_name = '$bloodBankName' WHERE request_id = '$request_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        // Insert a new record
        $insert_query = "INSERT INTO request_status (request_id, status, hospital_name, blood_bank_name, created_at) VALUES ('$request_id', '$status', '$hospital_name', '$bloodBankName', NOW())";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "Status inserted successfully.";
        } else {
            echo "Error inserting status: " . mysqli_error($conn);
        }
    }
} else {
    // Request ID, status, or hospital name not provided
    echo "Request ID, status, or hospital name not provided.";
}
?>
