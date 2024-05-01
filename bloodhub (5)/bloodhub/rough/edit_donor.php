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

// Retrieve donor ID from URL parameter
if (!isset($_GET['donor_id']) || empty($_GET['donor_id'])) {
    // Redirect to blood donors page if donor ID is not provided
    header("Location: blood_donors.php");
    exit();
}
$donor_id = $_GET['donor_id'];

// Retrieve donor information from database
$sql_donor = "SELECT * FROM donors WHERE donor_id = '$donor_id'";
$result_donor = mysqli_query($conn, $sql_donor);
if (mysqli_num_rows($result_donor) == 1) {
    $row_donor = mysqli_fetch_assoc($result_donor);
    $name = $row_donor['name'];
    $email = $row_donor['email'];
    $blood_group = $row_donor['blood_group'];
} else {
    // Redirect to blood donors page if donor ID is invalid
    header("Location: blood_donors.php");
    exit();
}

// Update donor information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $blood_group = $_POST['blood_group'];

    $sql_update = "UPDATE donors SET name = '$name', email = '$email', blood_group = '$blood_group' WHERE donor_id = '$donor_id'";
    if (mysqli_query($conn, $sql_update)) {
        // Redirect to blood donors page after successful update
        header("Location: blood_donors.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Donor</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>

        <!-- Edit Donor Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?donor_id=" . $donor_id; ?>" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>
            <label for="blood_group">Blood Group:</label><br>
            <select id="blood_group" name="blood_group">
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select><br><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
