<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if hospital name is set in session
if (!isset($_SESSION['hospital_name'])) {
    // Redirect to hospital login page or handle as needed
    header("Location: hospital_login.php");
    exit();
}

// Check if request_id and status are set
if (isset($_GET['request_id'], $_GET['status'])) {
    $request_id = $_GET['request_id'];
    $status = $_GET['status'];

    // Prepare statement to insert/update status in request_status table
    $stmt = $conn->prepare("INSERT INTO request_status (hospital_name, request_id, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status)");
    $stmt->bind_param("sis", $hospital_name, $request_id, $status);

    // Get hospital name from session
    $hospital_name = $_SESSION['hospital_name'];

    // Execute statement
    if ($stmt->execute()) {
        // Return success message
        echo "Status updated successfully.";
    } else {
        // Return error message
        echo "Error updating status: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Return error message if request_id or status is not set
    echo "Error: Request ID or status not set.";
}

// Close connection
$conn->close();
?>
