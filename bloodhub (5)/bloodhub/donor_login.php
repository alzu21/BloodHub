<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement to retrieve donor information
    $sql = "SELECT * FROM donors WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if the donor exists and verify the password
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Authentication successful, set session variables
            $_SESSION['donor_id'] = $row['donor_id'];
            $_SESSION['name'] = $row['name'];
            // Redirect to donor dashboard or any other page
            header("Location: donor_dashboard.php");
            exit();
        } else {
            // Invalid password
            $error = "Invalid email or password.";
        }
    } else {
        // Donor not found
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Donor Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
