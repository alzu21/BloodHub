<?php
// Include database connection
include 'db_connection.php';

// Check if blood group is set in the URL parameters
if (isset($_GET['blood_group'])) {
    // Get the blood group from the URL
    $blood_group = $_GET['blood_group'];

    // Query to fetch blood availability for the specified blood group
    $sql_availability = "SELECT * FROM blood_quantity WHERE blood_group = '$blood_group'";
    $result_availability = mysqli_query($conn, $sql_availability);

    // Check if there are any rows returned
    if (mysqli_num_rows($result_availability) > 0) {
        echo "<h2>Blood Availability for Blood Group: " . $blood_group . "</h2>";
        echo "<table>";
        echo "<tr><th>Blood Bank Name</th><th>Units Available</th><th>Red Blood Cells</th><th>White Blood Cells</th><th>Platelets</th><th>Plasma</th></tr>";
        while ($row = mysqli_fetch_assoc($result_availability)) {
            echo "<tr>";
            echo "<td>" . $row['blood_bank_name'] . "</td>";
            echo "<td>" . $row['units_available'] . "</td>";
            echo "<td>" . $row['red_blood_cells'] . "</td>";
            echo "<td>" . $row['white_blood_cells'] . "</td>";
            echo "<td>" . $row['platelets'] . "</td>";
            echo "<td>" . $row['plasma'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No blood availability details found for blood group: " . $blood_group;
    }
} else {
    echo "Blood group not provided.";
}
?>
