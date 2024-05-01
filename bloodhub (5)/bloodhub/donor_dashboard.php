<?php
// Start session
session_start();

// Initialize variables
$donor_id = $name = $blood_group = $last_donation_date = $future_date = $donation_status = "";

// Check if donor is logged in
if (!isset($_SESSION['donor_id'])) {
    // Redirect to donor login page
    header("Location: donor_login.php");
    exit();
}

// Retrieve donor information from session
$donor_id = $_SESSION['donor_id'];
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// Include database connection
include 'db_connection.php';

// Retrieve the blood group from the donors table
$sql = "SELECT blood_group FROM donors WHERE donor_id = '$donor_id'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $blood_group = $row['blood_group'];
} else {
    // If no blood group found, set it to N/A
    $blood_group = "N/A";
}

// Retrieve the last donation date from the blood_donations table
$sql_last_donation = "SELECT MAX(donation_date) AS last_donation_date FROM blood_donations WHERE donor_id = '$donor_id'";
$result_last_donation = mysqli_query($conn, $sql_last_donation);

// Check if the query was successful
if ($result_last_donation && mysqli_num_rows($result_last_donation) > 0) {
    $row_last_donation = mysqli_fetch_assoc($result_last_donation);
    $last_donation_date = $row_last_donation['last_donation_date'];
} else {
    // If no donation date found, set it to N/A
    $last_donation_date = "N/A";
}

// Calculate the date when 90 days period completes
if ($last_donation_date != "N/A") {
    $last_donation_timestamp = strtotime($last_donation_date);
    $future_timestamp = $last_donation_timestamp + (90 * 24 * 60 * 60); // 90 days in seconds
    $future_date = date('Y-m-d', $future_timestamp);
} else {
    $future_date = "N/A";
}

// Calculate donation status
$current_date = date('Y-m-d');
$last_donation_timestamp = strtotime($last_donation_date);
$current_timestamp = strtotime($current_date);
$days_since_last_donation = floor(($current_timestamp - $last_donation_timestamp) / (60 * 60 * 24));
if ($days_since_last_donation >= 90) {
    $donation_status = "You can donate blood.";
} else {
    $remaining_days = 90 - $days_since_last_donation;
    $donation_status = "You can donate in $remaining_days days.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $name; ?>!</h2>
        
        <h3>Your Information</h3>
        <p><strong>Donor ID:</strong> <?php echo $donor_id; ?></p>
        <p><strong>Blood Group:</strong> <?php echo $blood_group; ?></p>
        <p><strong>Last Donation Date:</strong> <?php echo $last_donation_date; ?></p>
        <p><strong>Donation Status:</strong> <?php echo $donation_status; ?></p>
        <?php if ($future_date != "N/A") { ?>
        <p><strong>Date to Donate:</strong> <?php echo $future_date; ?></p>
        <?php } ?>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
