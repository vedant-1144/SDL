<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Toll Tax Management System</title>
</head>

<body>
    <h2>Add Toll Entry</h2>
    <form method="post" action="save.php">
        <label>Vehicle Number:</label><br>
        <input type="text" name="vehicle_number" required><br><br>

        <label>Vehicle Type:</label><br>
        <select name="vehicle_type">
            <option value="Car">Car</option>
            <option value="Truck">Truck</option>
            <option value="Bike">Bike</option>
            <option value="Bus">Bus</option>
        </select><br><br>

        <label>Amount Paid (Rs):</label><br>

        <input type="number" name="amount_paid" required><br><br>
        <input type="submit" value="Add Entry">
    </form>
    <hr>

    <h2>All Toll Entries</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Vehicle Number</th>
            <th>Vehicle Type</th>
            <th>Amount Paid</th>
            <th colspan="2">Actions</th>
        </tr>
        
        <?php
        $result = $conn->query("SELECT * FROM toll_entries");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['vehicle_number']}</td>
                    <td>{$row['vehicle_type']}</td>
                    <td>Rs.{$row['amount_paid']}</td>
                    <td><a href='delete.php?id={$row['id']}'>Delete</a></td>
                    <td><a href='edit.php?id={$row['id']}'>Edit</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>

</html>