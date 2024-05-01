<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if blood bank ID and name are set in session
if (!isset($_SESSION['blood_bank_id'], $_SESSION['blood_bank_name'])) {
    // Redirect to blood bank login page or handle as needed
    header("Location: blood_bank_login.php");
    exit();
}

// Check if request ID and status are set
if (isset($_GET['request_id'], $_GET['status'])) {
    // Get request ID and status from GET parameters
    $request_id = $_GET['request_id'];
    $status = $_GET['status'];
    
    // Get blood bank name from session
    $blood_bank_name = $_SESSION['blood_bank_name'];

    // Update status in the blood_request table
    $sql_update_status = "UPDATE blood_request SET status = '$status' WHERE request_id = $request_id";

    if (mysqli_query($conn, $sql_update_status)) {
        // Get hospital name from blood_request table
        $sql_get_hospital_name = "SELECT hospital_name FROM blood_request WHERE request_id = $request_id";
        $result_hospital_name = mysqli_query($conn, $sql_get_hospital_name);
        if (!$result_hospital_name) {
            die("Error: " . mysqli_error($conn));
        }
        $row_hospital_name = mysqli_fetch_assoc($result_hospital_name);
        $hospital_name = $row_hospital_name['hospital_name'];

        // Check if status already exists for the request ID
        $sql_check_status = "SELECT * FROM request_status WHERE request_id = $request_id";
        $result_check_status = mysqli_query($conn, $sql_check_status);

        if (mysqli_num_rows($result_check_status) > 0) {
            // Update status in the request_status table
            $sql_update_request_status = "UPDATE request_status SET status = '$status', hospital_name = '$hospital_name', blood_bank_name = '$blood_bank_name' WHERE request_id = $request_id";
            if (mysqli_query($conn, $sql_update_request_status)) {
                echo "Status updated successfully.";
            } else {
                echo "Error updating status in request_status table: " . mysqli_error($conn);
            }
        } else {
            // Insert new status into the request_status table
            $sql_insert_request_status = "INSERT INTO request_status (request_id, status, hospital_name, blood_bank_name, created_at) VALUES ($request_id, '$status', '$hospital_name', '$blood_bank_name', NOW())";
            if (mysqli_query($conn, $sql_insert_request_status)) {
                echo "Status inserted successfully.";
            } else {
                echo "Error inserting status into request_status table: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error updating status in blood_request table: " . mysqli_error($conn);
    }
} else {
    echo "Request ID or status not provided.";
}
?>
