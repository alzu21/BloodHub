<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Initialize variables to store form data
$email = $password = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Retrieve user from database based on email
    $sql = "SELECT * FROM donors WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User found, verify password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['user_id'] = $row['donor_id'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect, redirect to login page with error message
            $_SESSION['login_error'] = 'Invalid email or password. Please try again.';
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found, redirect to login page with error message
        $_SESSION['login_error'] = 'Invalid email or password. Please try again.';
        header("Location: login.php");
        exit();
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
