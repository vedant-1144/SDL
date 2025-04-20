<!DOCTYPE html>
<html>
<head>
    <title>Toll Tax Management System</title>
</head>
<body>
    <h1>Enter Toll Tax Transaction</h1>
    <form action="add_toll.php" method="POST">
        <label for="vehicle_number">Vehicle Number:</label><br>
        <input type="text" id="vehicle_number" name="vehicle_number" required><br><br>

        <label for="vehicle_type">Vehicle Type:</label><br>
        <select id="vehicle_type" name="vehicle_type" required>
            <option value="Car">Car</option>
            <option value="Truck">Truck</option>
            <option value="Bus">Bus</option>
            <option value="Motorcycle">Motorcycle</option>
        </select><br><br>

        <label for="toll_booth">Toll Booth:</label><br>
        <select id="toll_booth" name="toll_booth" required>
            <?php
            include 'db.php';
            $sql = "SELECT id, name FROM toll_booths";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
            } else {
                echo "<option value=''>No toll booths available</option>";
            }
            ?>
        </select><br><br>

        <label for="amount">Amount:</label><br>
        <input type="number" step="0.01" id="amount" name="amount" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <br>
    <a href="view_tolls.php">View Toll Transactions</a>
</body>
</html>
