
<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM toll_entries WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Toll Entry</title>
</head>
<body>
    <h2>Edit Toll Entry</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Vehicle Number:</label><br>
        <input type="text" name="vehicle_number" value="<?php echo $row['vehicle_number']; ?>" required><br><br>

        <label>Vehicle Type:</label><br>
        <select name="vehicle_type">
            <option value="Car" <?php if($row['vehicle_type'] == 'Car') echo 'selected'; ?>>Car</option>
            <option value="Truck" <?php if($row['vehicle_type'] == 'Truck') echo 'selected'; ?>>Truck</option>
            <option value="Bike" <?php if($row['vehicle_type'] == 'Bike') echo 'selected'; ?>>Bike</option>
            <option value="Bus" <?php if($row['vehicle_type'] == 'Bus') echo 'selected'; ?>>Bus</option>
        </select><br><br>

        <label>Amount Paid (Rs):</label><br>
        <input type="number" name="amount_paid" value="<?php echo $row['amount_paid']; ?>" required><br><br>
        <input type="submit" value="Update Entry">
    </form>
    <hr>
    <a href="index.php">Back to Home</a>
</body>
</html>
<?php
$conn->close();
?>
