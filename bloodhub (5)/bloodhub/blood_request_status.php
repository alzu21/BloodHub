<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if hospital is logged in
if (!isset($_SESSION['hospital_name'])) {
    // Redirect to hospital login page
    header("Location: hospital_login.php");
    exit();
}

// Retrieve hospital name from session
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

// Function to display blood request status
function displayBloodRequests($conn, $hospital_name) {
    $sql = "SELECT br.request_id, br.blood_group, br.priority, br.blood_quantity, br.Red_blood_cells, br.White_blood_cells, br.Platelets, br.Plasma, rs.status, rs.created_at 
            FROM blood_request br
            LEFT JOIN request_status rs ON br.request_id = rs.request_id
            WHERE br.hospital_name = '$hospital_name' AND (rs.status IS NULL OR rs.created_at = (SELECT MAX(created_at) FROM request_status WHERE request_id = br.request_id))
            ORDER BY br.request_id DESC"; // Order by request ID in descending order
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h3>Blood Request Status</h3>";
        echo "<table>";
        echo "<tr><th>Request ID</th><th>Blood Group</th><th>Priority</th><th>Blood Quantity</th><th>Red Blood Cells</th><th>White Blood Cells</th><th>Platelets</th><th>Plasma</th><th>Status</th><th>Status Updated On</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['request_id'] . "</td>";
            echo "<td>" . $row['blood_group'] . "</td>";
            echo "<td>" . $row['priority'] . "</td>";
            echo "<td>" . $row['blood_quantity'] . "</td>";
            echo "<td>" . $row['Red_blood_cells'] . "</td>";
            echo "<td>" . $row['White_blood_cells'] . "</td>";
            echo "<td>" . $row['Platelets'] . "</td>";
            echo "<td>" . $row['Plasma'] . "</td>";
            echo "<td style='background-color: " . getStatusColor($row['status']) . "'>" . getStatusText($row['status']) . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No blood requests found.</p>";
    }
}

// Function to get status color
function getStatusColor($status) {
    switch ($status) {
        case 'Accepted':
            return 'green';
        case 'Rejected':
            return 'red';
        default:
            return 'lightblue';
    }
}

// Function to get status text
function getStatusText($status) {
    if ($status) {
        return $status;
    } else {
        return 'Pending';
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $hospital_name; ?>!</h2>
        
        <!-- Logout button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>

        <!-- Display blood request status -->
        <?php displayBloodRequests($conn, $hospital_name); ?>
    </div>
</body>
</html>
