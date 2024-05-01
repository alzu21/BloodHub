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

// Function to display messages from hospitals
function displayMessagesFromHospitals($conn, $blood_bank_id) {
    $sql_messages = "SELECT * FROM messages WHERE blood_bank_id = $blood_bank_id";
    $result_messages = mysqli_query($conn, $sql_messages);
    if (mysqli_num_rows($result_messages) > 0) {
        echo "<h3>Messages from Hospitals</h3>";
        while ($row = mysqli_fetch_assoc($result_messages)) {
            echo "<p>From: Hospital<br>";
            echo "Message: " . $row['message'] . "</p>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='message_id' value='" . $row['message_id'] . "'>";
            echo "<textarea name='reply_message' placeholder='Enter your reply'></textarea><br>";
            echo "<input type='submit' name='reply' value='Reply'>";
            echo "</form>";
        }
    } else {
        echo "<p>No messages from hospitals.</p>";
    }
}

// Function to reply to a message from a hospital
function replyToHospitalMessage($conn, $message_id, $reply_message) {
    $sql_reply = "INSERT INTO replies (message_id, reply_message) VALUES ('$message_id', '$reply_message')";
    if (mysqli_query($conn, $sql_reply)) {
        return true;
    } else {
        return false;
    }
}

// Function to display donors list
function displayDonorsList($conn) {
    $sql_donors = "SELECT * FROM donors";
    $result_donors = mysqli_query($conn, $sql_donors);
    if (mysqli_num_rows($result_donors) > 0) {
        echo "<h3>List of Donors</h3>";
        echo "<table>";
        echo "<tr><th>Donor ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result_donors)) {
            echo "<tr>";
            echo "<td>" . $row['donor_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><a href='edit_donor.php?donor_id=" . $row['donor_id'] . "'>Edit</a> | <a href='delete_donor.php?donor_id=" . $row['donor_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No donors found.</p>";
    }
}

// Process reply to a message from a hospital
if (isset($_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $reply_message = $_POST['reply_message'];
    if (!empty($reply_message)) {
        if (replyToHospitalMessage($conn, $message_id, $reply_message)) {
            echo "<p>Reply sent successfully!</p>";
        } else {
            echo "<p>Error sending reply. Please try again later.</p>";
        }
    } else {
        echo "<p>Please enter a reply message.</p>";
    }
}

// Function to display donor details
function displayDonorDetails($conn, $donor_id) {
    $sql = "SELECT * FROM donors WHERE donor_id = '$donor_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<p>Name: " . $row['name'] . "</p>";
        echo "<p>Email: " . $row['email'] . "</p>";
        echo "<p>Blood Group: " . $row['blood_group'] . "</p>";
    } else {
        echo "<p>No donor found with the provided ID.</p>";
    }
}

// Process form submission for displaying donor details
if (isset($_POST['submit_donor_id'])) {
    $donor_id = $_POST['donor_id'];
    displayDonorDetails($conn, $donor_id);
}

// Process form submission for adding blood donation details
if (isset($_POST['submit_blood_donation'])) {
    $donor_id = $_POST['donor_id'];
    $donation_date = $_POST['donation_date'];
    $blood_unit = $_POST['blood_unit'];

    // Insert blood donation details into the database
    $sql_insert = "INSERT INTO blood_donations (donor_id, donation_date, blood_unit) 
                   VALUES ('$donor_id', '$donation_date', '$blood_unit')";
    if (mysqli_query($conn, $sql_insert)) {
        echo "<p>Blood donation details added successfully!</p>";
    } else {
        echo "<p>Error adding blood donation details: " . mysqli_error($conn) . "</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $blood_bank_name; ?>!</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        
        <!-- Messages from Hospitals -->
        <?php displayMessagesFromHospitals($conn, $blood_bank_id); ?>
        
        <!-- Donors List -->
        <?php displayDonorsList($conn); ?>
    

<!-- Form to display donor details -->
        <h3>Enter Donor ID to Display Details</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="donor_id" placeholder="Enter Donor ID">
            <input type="submit" name="submit_donor_id" value="Submit">
        </form>

        <!-- Display donor details -->
        <?php
        if (isset($_POST['submit_donor_id'])) {
            echo "<h3>Donor Details</h3>";
            displayDonorDetails($conn, $_POST['donor_id']);
        }
        ?>
        
        <!-- Form to add blood donation details -->
        <h3>Add Blood Donation Details</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="donor_id" placeholder="Donor ID">
            <input type="date" name="donation_date" placeholder="Donation Date">
            <input type="text" name="blood_unit" placeholder="Blood Units">
            <input type="submit" name="submit_blood_donation" value="Submit">
        </form>
</div>

</body>
</html>
