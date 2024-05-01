<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if blood bank ID and name are set in session
if (!isset($_SESSION['blood_bank_id'], $_SESSION['blood_bank_name'])) {
    // Redirect to blood bank login page or handle as needed
    header("Location: blood_bank_login.php");
    exit();
}

// Get the blood bank name from session
$bloodBankName = $_SESSION['blood_bank_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Blood Requests</title>
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
        .accepted {
            background-color: #b3ffb3;
        }
        .rejected {
            background-color: #ff9999;
        }
        .pending {
            background-color: #b3d9ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Received Blood Requests</h2>
        
        <!-- PHP code to display blood requests -->
        <?php
        // Query to fetch blood requests for the current blood bank
        $sql_requests = "SELECT br.*, rs.status FROM blood_request br LEFT JOIN request_status rs ON br.request_id = rs.request_id WHERE br.blood_bank_name = '$bloodBankName' ORDER BY br.request_id DESC";
        $result_requests = mysqli_query($conn, $sql_requests);

        if (mysqli_num_rows($result_requests) > 0) {
            echo "<table>";
            echo "<tr><th>Hospital Name</th><th>Request ID</th><th>Blood Group</th><th>Priority</th><th>Blood Quantity</th><th>Red Blood Cells</th><th>White Blood Cells</th><th>Platelets</th><th>Plasma</th><th>Status</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result_requests)) {
                echo "<tr>";
                echo "<td>" . $row['hospital_name'] . "</td>";
                echo "<td>" . $row['request_id'] . "</td>";
                echo "<td>" . $row['blood_group'] . "</td>";
                echo "<td>" . $row['priority'] . "</td>";
                echo "<td>" . $row['blood_quantity'] . "</td>";
                echo "<td>" . $row['Red_blood_cells'] . "</td>";
                echo "<td>" . $row['White_blood_cells'] . "</td>";
                echo "<td>" . $row['Platelets'] . "</td>";
                echo "<td>" . $row['Plasma'] . "</td>";
                echo "<td id='status_" . $row['request_id'] . "' class='" . (isset($row['status']) ? strtolower($row['status']) : 'pending') . "'>" . (isset($row['status']) ? ucfirst($row['status']) : 'Pending') . "</td>";
                echo "<td><button onclick='acceptRequest(" . $row['request_id'] . ", \"" . $row['blood_group'] . "\", \"" . $row['hospital_name'] . "\", " . $row['blood_quantity'] . ", " . $row['Plasma'] . ", " . $row['Platelets'] . ", " . $row['Red_blood_cells'] . ", " . $row['White_blood_cells'] . ")'>Accept</button> <button onclick='rejectRequest(" . $row['request_id'] . ", \"" . $row['hospital_name'] . "\")'>Reject</button> <button onclick='checkAvailability(\"" . $row['blood_group'] . "\")'>Check Availability</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No blood requests found.</p>";
        }
        ?>

        <!-- JavaScript functions for accept, reject, and availability popup -->
        <script>
            function acceptRequest(requestId, bloodGroup, hospitalName, quantity, plasma, platelets, redBloodCells, whiteBloodCells) {
                console.log("Accepting request: " + requestId);
                // Make AJAX request to update status to "Accepted" in blood_request table
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("status_" + requestId).innerHTML = "Accepted";
                        document.getElementById("status_" + requestId).className = "accepted";

                        // Make AJAX request to update status to "Accepted" in request_status table
                        var xhttp2 = new XMLHttpRequest();
                        xhttp2.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log("Status updated in request_status table.");
                            }
                        };
                        xhttp2.open("GET", "update_request_status.php?request_id=" + requestId + "&status=accepted&hospital_name=" + hospitalName, true);
                        xhttp2.send();

                        // Make AJAX request to update blood quantity
                        updateBloodQuantity(bloodGroup, quantity, plasma, platelets, redBloodCells, whiteBloodCells);
                    }
                };
                xhttp.open("GET", "update_status.php?request_id=" + requestId + "&status=accepted", true);
                xhttp.send();
            }

            function rejectRequest(requestId, hospitalName) {
                console.log("Rejecting request: " + requestId);
                // Make AJAX request to update status to "Rejected" in blood_request table
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("status_" + requestId).innerHTML = "Rejected";
                        document.getElementById("status_" + requestId).className = "rejected";

                        // Make AJAX request to update status to "Rejected" in request_status table
                        var xhttp2 = new XMLHttpRequest();
                        xhttp2.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log("Status updated in request_status table.");
                            }
                        };
                        xhttp2.open("GET", "update_request_status.php?request_id=" + requestId + "&status=rejected&hospital_name=" + hospitalName, true);
                        xhttp2.send();
                    }
                };
                xhttp.open("GET", "update_status.php?request_id=" + requestId + "&status=rejected", true);
                xhttp.send();
            }

            function checkAvailability(bloodGroup) {
                console.log("Checking availability for blood group: " + bloodGroup);
                // Open blood_quantity.php in a new window with the blood group as a parameter
                window.open("blood_quantity.php?blood_group=" + bloodGroup, "_blank");
            }

            // Function to update blood quantity
            function updateBloodQuantity(bloodGroup, quantity, plasma, platelets, redBloodCells, whiteBloodCells) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log("Blood quantity updated successfully.");
                    }
                };
                xhttp.open("GET", "update_blood_quantity.php?blood_group=" + bloodGroup + "&quantity=" + quantity + "&plasma=" + plasma + "&platelets=" + platelets + "&red_blood_cells=" + redBloodCells + "&white_blood_cells=" + whiteBloodCells, true);
                xhttp.send();
            }
        </script>
        
        <!-- Logout button -->
        <form action="logout.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>
</body>
</html>
