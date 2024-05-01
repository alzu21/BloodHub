<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Blood Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Include database connection
    include 'db_connection.php';

    // Function to redirect
    function redirect($url) {
        header("Location: $url");
        exit();
    }

    // Get blood bank names
    $sql_blood_banks = "SELECT name FROM blood_bank";
    $result_blood_banks = mysqli_query($conn, $sql_blood_banks);

    // Get blood groups
    $blood_groups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if form is submitted
        if (isset($_POST['blood_bank']) && isset($_POST['blood_group']) && isset($_POST['quantity']) && isset($_POST['priority'])) {
            // Get form data
            $blood_bank = $_POST['blood_bank'];
            $blood_group = $_POST['blood_group'];
            $quantity = $_POST['quantity'];
            $priority = $_POST['priority'];

            // Get current date
            $requested_date = date("Y-m-d");

            // Insert data into blood_requests table
            $sql_insert = "INSERT INTO blood_requests (hospital_name, blood_bank_name, blood_group, requested_quantity, priority, requested_date) 
                           VALUES ('$hospital_name', '$blood_bank', '$blood_group', '$quantity', '$priority', '$requested_date')";
            if (mysqli_query($conn, $sql_insert)) {
                echo "<h2>Request Successful!</h2>";
                echo "<p>Thank you for your request. You will be redirected to the hospital dashboard shortly.</p>";
                // Redirect to hospital dashboard after 2 seconds
                echo "<script>setTimeout(function() { window.location.href = 'hospital_dashboard.php'; }, 2000);</script>";
            } else {
                echo "<h2>Error!</h2>";
                echo "<p>There was an error processing your request. Please try again later.</p>";
            }
        } else {
            echo "<h2>Error!</h2>";
            echo "<p>Invalid request. Please fill out all the required fields.</p>";
        }
    }
    ?>
</body>
</html>
