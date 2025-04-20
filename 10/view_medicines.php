<?php
include 'db.php';

$sql = "SELECT id, name, description, price, quantity FROM medicines ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicines</title>
</head>
<body>
    <h1>Medicines List</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . intval($row['quantity']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No medicines found</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="add_medicine.php">Add New Medicine</a><br>
    <a href="index.php">Back to Sales</a>
</body>
</html>
