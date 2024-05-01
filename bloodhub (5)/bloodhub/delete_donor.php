<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if blood bank is logged in
if (!isset($_SESSION['blood_bank_id'])) {
    // Redirect to blood bank login page
    header("Location: blood_bank_login.php");
    exit();
}

// Handle delete request
if (isset($_POST['delete_donor_id'])) {
    $donor_id = $_POST['delete_donor_id'];

    // Delete associated records in blood_donations table
    $sql_delete_donations = "DELETE FROM blood_donations WHERE donor_id = '$donor_id'";
    if (mysqli_query($conn, $sql_delete_donations)) {
        // Deletion successful, proceed to delete donor record
        $sql_delete_donor = "DELETE FROM donors WHERE donor_id = '$donor_id'";
        if (mysqli_query($conn, $sql_delete_donor)) {
            echo "<script>alert('Donor deleted successfully.');</script>";
        } else {
            echo "<script>alert('Error deleting donor: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Error deleting associated blood donations: " . mysqli_error($conn) . "');</script>";
    }
}

// Redirect back to blood_donors.php
header("Location: blood_donors.php");
exit();
?>
