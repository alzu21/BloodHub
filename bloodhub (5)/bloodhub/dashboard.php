<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if donor is logged in
if (!isset($_SESSION['donor_id'])) {
    // Redirect to donor login page
    header("Location: donor_login.php");
    exit();
}

// Retrieve donor ID and name from session
$donor_id = $_SESSION['donor_id'];
$donor_name = $_SESSION['donor_name'];

// Function to display donor details
function displayDonorDetails($conn, $donor_id) {
    // Query to fetch donor details
    $sql = "SELECT * FROM donors WHERE donor_id = '$donor_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch donor details
        $row = mysqli_fetch_assoc($result);
        
        // Display donor details
        echo "<h2>Welcome, " . $row['name'] . "!</h2>";
        echo "<p>Donor ID: " . $row['donor_id'] . "</p>";
        echo "<p>Name: " . $row['name'] . "</p>";
        echo "<p>Blood Group: " . $row['blood_group'] . "</p>";
        echo "<p>Last Donated Date: " . $row['last_donated_date'] . "</p>";
        
        // Calculate current donation status
        $last_donated_date = strtotime($row['last_donated_date']);
        $current_date = strtotime(date('Y-m-d'));
        $days_since_last_donation = floor(($current_date - $last_donated_date) / (60 * 60 * 24));

        if ($days_since_last_donation >= 90) {
            echo "<p>You are eligible to donate blood.</p>";
        } else {
            $remaining_days = 90 - $days_since_last_donation;
            echo "<p>You can donate blood in $remaining_days days.</p>";
        }
    } else {
        echo "<p>Error: Unable to fetch donor details.</p>";
    }
}

// Call function to display donor details
displayDonorDetails($conn, $donor_id);
?>
