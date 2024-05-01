<?php
// Start session
session_start();

// Check if registration status is set in session
if (isset($_SESSION['registration_status'])) {
    $registration_status = $_SESSION['registration_status'];

    // Display appropriate message based on registration status
    if ($registration_status === 'success') {
        $message = 'Registration successful. You can now <a href="donor_login.php">login</a>.';
    } else {
        $message = 'Registration failed. Please try again.';
    }
    
    // Unset registration status from session
    unset($_SESSION['registration_status']);
} else {
    // If registration status is not set, redirect to registration page
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registration Status</h2>
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
