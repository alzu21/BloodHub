<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Requests</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Blood Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Blood Type</th>
                    <th>Units Required</th>
                    <th>Date Requested</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch blood requests from the database
                $sql = "SELECT * FROM blood_requests";
                $result = mysqli_query($conn, $sql);

                // Display blood requests in a table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['hospital_name']}</td>";
                    echo "<td>{$row['blood_type']}</td>";
                    echo "<td>{$row['units_required']}</td>";
                    echo "<td>{$row['date_requested']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
