<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION['blood_bank_id'])) {
    // Redirect to blood bank management page
    header("Location: blood_bank_management.php");
    exit();
}

// Initialize variables to store form data
$name = $email = $password = $location = '';
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    $location = sanitize_input($_POST['location']);

    // Check if blood bank with same email already exists
    $sql_check_email = "SELECT * FROM blood_bank WHERE email='$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) == 0) {
        // Blood bank does not exist, proceed with registration
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert blood bank into the database
        $sql_insert_blood_bank = "INSERT INTO blood_bank (name, email, password, location) VALUES ('$name', '$email', '$hashedPassword', '$location')";
        if (mysqli_query($conn, $sql_insert_blood_bank)) {
            // Registration successful, redirect to login page
            header("Location: blood_bank_login.php");
            exit();
        } else {
            // Registration failed
            $error = 'Registration failed. Please try again later.';
        }
    } else {
        // Blood bank with same email already exists
        $error = 'An account with this email already exists. Please use a different email.';
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
    <title>Blood Bank Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Blood Bank Registration</h2>
        
        <!-- Display error message if registration fails -->
        <?php if ($error) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        
        <!-- Registration form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" required><br><br>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
