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

// Function to display available blood quantity in the current blood bank
function displayBloodQuantity($conn, $blood_bank_name) {
    $sql = "SELECT blood_group, units_available, red_blood_cells, white_blood_cells, plasma, platelets FROM blood_quantity WHERE blood_bank_name = '$blood_bank_name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Available Blood Quantity in $blood_bank_name</h2>";
        echo "<table>";
        echo "<tr><th>Blood Group</th><th>Units Available</th><th>RBC</th><th>WBC</th><th>Plasma</th><th>Platelets</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['blood_group'] . "</td>";
            echo "<td>" . $row['units_available'] . "</td>";
            echo "<td>" . $row['red_blood_cells'] . "</td>";
            echo "<td>" . $row['white_blood_cells'] . "</td>";
            echo "<td>" . $row['plasma'] . "</td>";
            echo "<td>" . $row['platelets'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No blood quantity data found for $blood_bank_name.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Blood Quantity</title>
    <link rel="stylesheet" href="styles.css"> <!-- Make sure to link your CSS file here -->
</head>
<body>
    <div class="container">
        <h1>Available Blood Quantity</h1>
        
        <!-- Display blood quantity -->
        <?php displayBloodQuantity($conn, $blood_bank_name); ?>

        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>
</body>
</html>
