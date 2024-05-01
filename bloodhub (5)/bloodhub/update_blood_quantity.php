<?php
// Include database connection
include 'db_connection.php';

// Check if all required parameters are present
if (isset($_GET['blood_group']) && isset($_GET['quantity']) && isset($_GET['plasma']) && isset($_GET['platelets']) && isset($_GET['red_blood_cells']) && isset($_GET['white_blood_cells'])) {
    // Get parameters
    $blood_group = $_GET['blood_group'];
    $quantity = $_GET['quantity'];
    $plasma = $_GET['plasma'];
    $platelets = $_GET['platelets'];
    $red_blood_cells = $_GET['red_blood_cells'];
    $white_blood_cells = $_GET['white_blood_cells'];

    // Update blood quantity
    $sql_update_quantity = "UPDATE blood_quantity 
                            SET units_available = units_available - $quantity, 
                                plasma = plasma - $plasma, 
                                platelets = platelets - $platelets, 
                                red_blood_cells = red_blood_cells - $red_blood_cells, 
                                white_blood_cells = white_blood_cells - $white_blood_cells
                            WHERE blood_group = '$blood_group'";
    if (mysqli_query($conn, $sql_update_quantity)) {
        echo "Blood quantity updated successfully.";
    } else {
        echo "Error updating blood quantity: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}
?>
