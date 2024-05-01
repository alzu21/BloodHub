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

// Retrieve hospital ID and name from session
$hospital_id = $_SESSION['hospital_id'];
$hospital_name = $_SESSION['hospital_name'];

// Logout functionality
if (isset($_POST['logout'])) {
    // Destroy the session
    session_unset();
    session_destroy();
    // Redirect to hospital login page
    header("Location: hospital_login.php");
    exit();
}

// Function to display sent messages to blood bank
function displaySentMessages($conn, $hospital_id) {
    $sql_messages = "SELECT * FROM messages WHERE hospital_id = $hospital_id";
    $result_messages = mysqli_query($conn, $sql_messages);
    if ($result_messages && mysqli_num_rows($result_messages) > 0) {
        echo "<h3>Sent Messages</h3>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result_messages)) {
            echo "<li>Message: " . $row['message'] . "</li>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='message_id' value='" . $row['message_id'] . "'>";
            echo "<input type='submit' name='delete_message' value='Delete'>";
            echo "</form>";
        }
        echo "</ul>";
    } else {
        echo "<p>No messages sent to blood bank.</p>";
    }
}

// Retrieve blood banks from the database
$sql_blood_banks = "SELECT * FROM blood_bank";
$result_blood_banks = mysqli_query($conn, $sql_blood_banks);

// Function to send a message to a blood bank
function sendMessageToBloodBank($conn, $hospital_id, $blood_bank_id, $message_content) {
    $sql_insert_message = "INSERT INTO messages (hospital_id, blood_bank_id, message) VALUES ('$hospital_id', '$blood_bank_id', '$message_content')";
    if (mysqli_query($conn, $sql_insert_message)) {
        return true;
    } else {
        return false;
    }
}

// Function to display reply messages from blood bank
function displayReplyMessages($conn, $hospital_id) {
    $sql_messages = "SELECT messages.*, replies.reply_message 
                     FROM messages 
                     LEFT JOIN replies ON messages.message_id = replies.message_id 
                     WHERE messages.hospital_id = $hospital_id";
    $result_messages = mysqli_query($conn, $sql_messages);
    if ($result_messages && mysqli_num_rows($result_messages) > 0) {
        echo "<h3>Reply Messages</h3>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result_messages)) {
            echo "<li>Message: " . $row['message'] . "</li>";
            if (!empty($row['reply_message'])) {
                echo "<li><strong>Reply:</strong> " . $row['reply_message'] . "</li>";
            } else {
                echo "<li>No reply yet.</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No reply messages from blood bank.</p>";
    }
}

// Function to delete a sent message
function deleteSentMessage($conn, $message_id) {
    $sql_delete = "DELETE FROM messages WHERE message_id = $message_id";
    if (mysqli_query($conn, $sql_delete)) {
        return true;
    } else {
        return false;
    }
}

// Process form submission for deleting message
if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];
    if (deleteSentMessage($conn, $message_id)) {
        echo "<p>Message deleted successfully!</p>";
    } else {
        echo "<p>Error deleting message. Please try again later.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your CSS styles here */
        .container {
            display: flex;
        }
        .sidebar {
            flex: 25%;
            padding: 20px;
            background-color: #f1f1f1;
        }
        .main {
            flex: 75%;
            padding: 20px;
            background-color: #ffffff;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 8px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: black;
        }
        .sidebar ul li a:hover {
            color: blue;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>Dashboard Menu</h3>
            <ul>
                <li><a href="blood_request.php" class="button">New Blood Requests</a></li>
                <li><a href="blood_request_status.php" class="button">Blood Request Status</a></li>
                
            </ul>
        </div>
        
        <div class="main">
            <h2>Welcome, <?php echo $hospital_name; ?>!</h2>
            
            <!-- Logout button -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="submit" name="logout" value="Logout" class="button">
            </form>
            
            <!-- Form to send message to blood bank -->
            <h3>Send Message to Blood Bank</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="blood_bank">Select Blood Bank:</label>
                <select id="blood_bank" name="blood_bank" required>
                    <option value="">Select Blood Bank</option>
                    <?php while ($row = mysqli_fetch_assoc($result_blood_banks)) { ?>
                        <option value="<?php echo $row['blood_bank_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select><br><br>
                <label for="message_content">Message:</label><br>
                <textarea id="message_content" name="message_content" rows="4" cols="50" required></textarea><br><br>
                <input type="submit" name="send_message" value="Send Message" class="button">
            </form>
            
            <!-- Process form submission -->
            <?php
            if (isset($_POST['send_message'])) {
                $blood_bank_id = $_POST['blood_bank'];
                $message_content = $_POST['message_content'];
                
                if (!empty($blood_bank_id) && !empty($message_content)) {
                    if (sendMessageToBloodBank($conn, $hospital_id, $blood_bank_id, $message_content)) {
                        echo "<p>Message sent successfully!</p>";
                    } else {
                        echo "<p>Error sending message. Please try again later.</p>";
                    }
                } else {
                    echo "<p>Please select a blood bank and enter a message.</p>";
                }
            }
            ?>
            
            <!-- Display sent messages -->
            <?php displaySentMessages($conn, $hospital_id); ?>
            
            <!-- Display reply messages -->
            <?php displayReplyMessages($conn, $hospital_id); ?>
        </div>
    </div>
</body>
</html>
