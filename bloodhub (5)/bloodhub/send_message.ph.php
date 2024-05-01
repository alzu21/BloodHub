<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if hospital is logged in
if (!isset($_SESSION['hospital_id'])) {
    // Redirect to hospital login page
    header("Location: hospital_login.php");
    exit();
}

// Initialize variables to store form data
$message = '';
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $message = sanitize_input($_POST['message']);

    // Retrieve hospital ID from session
    $hospital_id = $_SESSION['hospital_id'];

    // Insert message into database
    $sql_insert_message = "INSERT INTO messages (hospital_id, message) VALUES ('$hospital_id', '$message')";
    if (mysqli_query($conn, $sql_insert_message)) {
        // Message sent successfully, redirect to hospital dashboard
        header("Location: hospital_dashboard.php");
        exit();
    } else {
        // Error sending message
        $error = 'Error sending message. Please try again later.';
    }
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message to Blood Bank</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Send Message to Blood Bank</h2>
        
        <!-- Display error message if message sending fails -->
        <?php if ($error) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        
        <!-- Message form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required><?php echo $message; ?></textarea><br><br>
            
            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>
