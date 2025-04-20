<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Management System - Add Sale</title>
</head>
<body>
    <h1>Record Medicine Sale</h1>
    <form action="sell_medicine.php" method="POST">
        <label for="medicine">Medicine:</label><br>
        <select id="medicine" name="medicine_id" required>
            <?php
            include 'db.php';
            $sql = "SELECT id, name FROM medicines";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
            } else {
                echo "<option value=''>No medicines available</option>";
            }
            ?>
        </select><br><br>

        <label for="customer">Customer:</label><br>
        <input type="text" id="customer" name="customer_name" required><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>

        <input type="submit" value="Record Sale">
    </form>

    <br>
    <a href="add_medicine.php">Add New Medicine</a><br>
    <a href="view_medicines.php">View Medicines</a><br>
    <a href="view_sales.php">View Sales</a>
</body>
</html>
