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
$email = $password = '';
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Retrieve blood bank from database based on email
    $sql = "SELECT * FROM blood_bank WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Blood bank found, verify password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to management page
            $_SESSION['blood_bank_id'] = $row['blood_bank_id'];
            $_SESSION['blood_bank_name'] = $row['name'];
            header("Location: blood_bank_management.php");
            exit();
        } else {
            // Password is incorrect
            $error = 'Invalid email or password. Please try again.';
        }
    } else {
        // Blood bank not found
        $error = 'Invalid email or password. Please try again.';
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
    <title>Blood Bank Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Blood Bank Login</h2>
        
        <!-- Display error message if login fails -->
        <?php if ($error) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        
        <!-- Login form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
