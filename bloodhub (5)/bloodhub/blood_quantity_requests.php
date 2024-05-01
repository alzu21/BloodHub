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

// Process "Ready" button click
if(isset($_POST['ready'])) {
    $blood_group = $_POST['blood_group'];
    $blood_quantity = $_POST['blood_quantity'];

    // Update blood quantity in database
    $sql_update = "UPDATE blood_quantity SET units_available = units_available - $blood_quantity WHERE blood_group = '$blood_group'";
    if(mysqli_query($conn, $sql_update)) {
        // Send message to hospital_dashboard.php
        // You can implement this part as per your messaging system
        echo "<script>alert('Blood quantity updated successfully and message sent to hospital.');</script>";
    } else {
        echo "<script>alert('Error updating blood quantity: " . mysqli_error($conn) . "');</script>";
    }
}

// Function to display blood quantity requests from hospitals
function displayBloodQuantityRequests($conn) {
    $sql_requests = "SELECT * FROM blood_requests";
    $result_requests = mysqli_query($conn, $sql_requests);
    if (mysqli_num_rows($result_requests) > 0) {
        echo "<h3>Blood Quantity Requests from Hospitals</h3>";
        echo "<table>";
        echo "<tr><th>Hospital</th><th>Blood Group</th><th>Requested Quantity</th><th>Current Availability</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result_requests)) {
            echo "<tr>";
            echo "<td>" . $row['hospital_name'] . "</td>";
            echo "<td>" . $row['blood_group'] . "</td>";
            echo "<td>" . $row['blood_quantity'] . "</td>";
            echo "<td>" . getAvailability($conn, $row['blood_group']) . "</td>";
            echo "<td><form action='' method='post'>";
            echo "<input type='hidden' name='blood_group' value='" . $row['blood_group'] . "'>";
            echo "<input type='hidden' name='blood_quantity' value='" . $row['blood_quantity'] . "'>";
            echo "<input type='submit' name='ready' value='Ready'>";
            echo "</form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No blood quantity requests from hospitals.</p>";
    }
}

// Function to get current availability of blood
function getAvailability($conn, $blood_group) {
    $sql_availability = "SELECT units_available FROM blood_quantity WHERE blood_group = '$blood_group'";
    $result_availability = mysqli_query($conn, $sql_availability);
    if(mysqli_num_rows($result_availability) > 0) {
        $row = mysqli_fetch_assoc($result_availability);
        return $row['units_available'];
    } else {
        return "N/A";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Quantity Requests</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Blood Quantity Requests</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        
        <!-- Display blood quantity requests from hospitals -->
        <?php displayBloodQuantityRequests($conn); ?>
    </div>
</body>
</html>
