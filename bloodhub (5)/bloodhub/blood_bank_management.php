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

// Function to update blood quantity table
function updateBloodQuantity($conn, $blood_bank_name, $blood_group, $blood_unit) {
    global $blood_bank_name; // Access global variable within the function
    
    // Calculate blood components based on units donated
    $plasma = $blood_unit * 20;
    $red_blood_cells = $blood_unit * 10;
    $white_blood_cells = $blood_unit * 15;
    $platelets = $blood_unit * 20;
    
    // Check if data already exists for blood group and blood bank name
    $sql_check = "SELECT * FROM blood_quantity WHERE blood_group = '$blood_group' AND blood_bank_name = '$blood_bank_name'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        // Update blood quantity
        $sql_update = "UPDATE blood_quantity SET 
                        units_available = units_available + $blood_unit, 
                        plasma = plasma + $plasma, 
                        red_blood_cells = red_blood_cells + $red_blood_cells, 
                        white_blood_cells = white_blood_cells + $white_blood_cells, 
                        platelets = platelets + $platelets 
                      WHERE blood_group = '$blood_group' AND blood_bank_name = '$blood_bank_name'";
        mysqli_query($conn, $sql_update);
    } else {
        // Insert new blood group with quantity
        $sql_insert = "INSERT INTO blood_quantity (blood_bank_name, blood_group, units_available, plasma, red_blood_cells, white_blood_cells, platelets) 
                      VALUES ('$blood_bank_name', '$blood_group', $blood_unit, $plasma, $red_blood_cells, $white_blood_cells, $platelets)";
        mysqli_query($conn, $sql_insert);
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
        // Update blood quantity
        $sql_get_blood_group = "SELECT blood_group FROM donors WHERE donor_id = '$donor_id'";
        $result_get_blood_group = mysqli_query($conn, $sql_get_blood_group);
        if ($result_get_blood_group && mysqli_num_rows($result_get_blood_group) > 0) {
            $row_get_blood_group = mysqli_fetch_assoc($result_get_blood_group);
            $blood_group = $row_get_blood_group['blood_group'];
            updateBloodQuantity($conn, $blood_bank_name, $blood_group, $blood_unit);
        } else {
            echo "<p>Error retrieving blood group.</p>";
        }
        
        echo "<p>Blood donation details added successfully!</p>";
    } else {
        echo "<p>Error adding blood donation details: " . mysqli_error($conn) . "</p>";
        // Add debug statement to check the SQL query
        echo "<p>SQL Query: $sql_insert</p>";
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
    <style>
        /* Add CSS styles for the sidebar */
        .sidebar {
            float: left;
            width: 20%;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .sidebar h3 {
            margin-top: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
        }

        .sidebar a:hover {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $blood_bank_name; ?>!</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        
        <!-- Sidebar with links -->
        <div class="sidebar">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="blood_donors.php">Donor Details</a></li>
                <li><a href="blood_quantity.php">Blood Inventory</a></li>
                <li><a href="received_request.php">New Blood Requests</a></li>
            </ul>
        </div>
        
        <!-- Main content area -->
        <div class="main">
            <!-- Messages from Hospitals -->
            <?php displayMessagesFromHospitals($conn, $blood_bank_id); ?>

            <!-- Form to display donor details --> <br><br><br><br><br><br><br><br>

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
                <input type="text" name="donor_id" placeholder="Donor ID"><br>
                Blood Donation Date
                <input type="date" name="donation_date" placeholder="Donation Date"><br><br>
                <input type="text" name="blood_unit" value="1" readonly> This is the default value <br><br>
                <input type="submit" name="submit_blood_donation" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
