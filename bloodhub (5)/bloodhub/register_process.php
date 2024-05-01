<?php
// Include database connection
include 'db_connection.php';

// Initialize variables to store form data
$name = $email = $password = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $blood_group =sanitize_input($_POST['blood_group']);
    $password = sanitize_input($_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO donors (name, email,blood_group,password) VALUES ('$name', '$email','$blood_group','$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        session_start();
        $_SESSION['registration_status'] = 'success';
        header("Location: registration_status.php");
        exit();
    } else {
        // Registration failed
        session_start();
        $_SESSION['registration_status'] = 'error';
        header("Location: registration_status.php");
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
