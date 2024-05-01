<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if hospital name is set in session
if (!isset($_SESSION['hospital_name'])) {
    // Redirect to hospital login page or handle as needed
    header("Location: hospital_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Blood Request Form</h2>
        <!-- Blood Request Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="blood_bank">Blood Bank:</label>
                <select name="blood_bank" id="blood_bank">
                    <?php
                    // Fetch blood bank names
                    $sql_blood_banks = "SELECT name FROM blood_bank";
                    $result_blood_banks = mysqli_query($conn, $sql_blood_banks);
                    while ($row = mysqli_fetch_assoc($result_blood_banks)) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <select name="blood_group" id="blood_group">
                    <?php
                    // Define blood groups
                    $blood_groups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
                    foreach ($blood_groups as $group) {
                        echo "<option value='$group'>$group</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="blood_quantity">Blood Quantity:</label>
                <input type="number" name="blood_quantity" id="blood_quantity" min="1" required>
            </div>
            <div class="form-group">
                <label for="Red_blood_cells">Red Blood Cells:</label>
                <input type="number" name="Red_blood_cells" id="Red_blood_cells" min="0" required>
            </div>
            <div class="form-group">
                <label for="White_blood_cells">White Blood Cells:</label>
                <input type="number" name="White_blood_cells" id="White_blood_cells" min="0" required>
            </div>
            <div class="form-group">
                <label for="Platelets">Platelets:</label>
                <input type="number" name="Platelets" id="Platelets" min="0" required>
            </div>
            <div class="form-group">
                <label for="Plasma">Plasma:</label>
                <input type="number" name="Plasma" id="Plasma" min="0" required>
            </div>
            <div class="form-group">
                <label for="priority">Priority:</label>
                <select name="priority" id="priority">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <textarea name="remarks" id="remarks" cols="30" rows="5"></textarea>
            </div>
            <!-- Hidden input field to store hospital name -->
            <input type="hidden" name="hospital_name" value="<?php echo $_SESSION['hospital_name']; ?>">
            <button type="submit" name="request">Request</button>
        </form>

        <!-- Logout button -->
        <form action="logout.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>

        <!-- PHP code to process form submission -->
        <?php
        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request'])) {
            // Check if form fields are set
            if (isset($_POST['blood_bank'], $_POST['blood_group'], $_POST['blood_quantity'], $_POST['Red_blood_cells'], $_POST['White_blood_cells'], $_POST['Platelets'], $_POST['Plasma'], $_POST['priority'], $_POST['remarks'], $_POST['hospital_name'])) {
                // Retrieve form data
                $blood_bank = $_POST['blood_bank'];
                $blood_group = $_POST['blood_group'];
                $blood_quantity = $_POST['blood_quantity'];
                $Red_blood_cells = $_POST['Red_blood_cells'];
                $White_blood_cells = $_POST['White_blood_cells'];
                $Platelets = $_POST['Platelets'];
                $Plasma = $_POST['Plasma'];
                $priority = $_POST['priority'];
                $remarks = $_POST['remarks'];
                $hospital_name = $_POST['hospital_name'];

                // Insert data into blood_requests table
                $sql_insert = "INSERT INTO blood_request (hospital_name, blood_bank_name, blood_group, blood_quantity, Red_blood_cells, White_blood_cells, Platelets, Plasma, priority, remarks) 
                               VALUES ('$hospital_name', '$blood_bank', '$blood_group', $blood_quantity, $Red_blood_cells, $White_blood_cells, $Platelets, $Plasma, '$priority', '$remarks')";
                if (mysqli_query($conn, $sql_insert)) {
                    echo "<p class='success'>Request successful!</p>";
                } else {
                    echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p class='error'>Please fill out all the fields.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
