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

// Retrieve blood bank ID and name from session
$blood_bank_id = $_SESSION['blood_bank_id'];
$blood_bank_name = $_SESSION['blood_bank_name'];

// Logout functionality
if (isset($_POST['logout'])) {
    // Destroy the session
    session_unset();
    session_destroy();
    // Redirect to blood bank login page
    header("Location: blood_bank_login.php");
    exit();
}

// Function to display donors list
function displayDonorsList($conn) {
    $sql_donors = "SELECT * FROM donors";
    $result_donors = mysqli_query($conn, $sql_donors);
    if (mysqli_num_rows($result_donors) > 0) {
        echo "<h3>Blood Donors</h3>";
        echo "<table>";
        echo "<tr><th>Donor ID</th><th>Name</th><th>Email</th><th>Blood Group</th><th>Last Donation Date</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result_donors)) {
            echo "<tr>";
            echo "<td>" . $row['donor_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['blood_group'] . "</td>";
            // Retrieve last donation date
            $donor_id = $row['donor_id'];
            $sql_last_donation = "SELECT MAX(donation_date) AS last_donation_date FROM blood_donations WHERE donor_id = '$donor_id'";
            $result_last_donation = mysqli_query($conn, $sql_last_donation);
            $last_donation_date = "N/A";
            if ($result_last_donation && mysqli_num_rows($result_last_donation) > 0) {
                $row_last_donation = mysqli_fetch_assoc($result_last_donation);
                $last_donation_date = $row_last_donation['last_donation_date'];
            }
            echo "<td>" . $last_donation_date . "</td>";
            echo "<td><a href='edit_donor.php?donor_id=" . $row['donor_id'] . "'>Edit</a> | <a href='delete_donor.php?donor_id=" . $row['donor_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No donors found.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donors</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $blood_bank_name; ?>!</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        
        <!-- Donors List -->
        <?php displayDonorsList($conn); ?>
    </div>
</body>
</html>
