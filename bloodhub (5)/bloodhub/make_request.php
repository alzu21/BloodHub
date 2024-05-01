<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Blood Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Make Blood Request</h2>
        <form action="submit_request.php" method="post">
            <label for="blood_type">Blood Type:</label><br>
            <input type="text" id="blood_type" name="blood_type" required><br><br>
            
            <label for="units_required">Units Required:</label><br>
            <input type="number" id="units_required" name="units_required" required><br><br>
            
            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>
