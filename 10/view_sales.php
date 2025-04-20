<?php
include 'db.php';

$sql = "SELECT sales.id, medicines.name AS medicine_name, customers.name AS customer_name, sales.quantity, sales.total_price, sales.sale_date
        FROM sales
        JOIN medicines ON sales.medicine_id = medicines.id
        JOIN customers ON sales.customer_id = customers.id
        ORDER BY sales.sale_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sales</title>
</head>
<body>
    <h1>Sales Records</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Medicine</th>
            <th>Customer</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Sale Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['medicine_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                echo "<td>" . intval($row['quantity']) . "</td>";
                echo "<td>" . number_format($row['total_price'], 2) . "</td>";
                echo "<td>" . $row['sale_date'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No sales records found</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="index.php">Back to Sales</a><br>
    <a href="add_medicine.php">Add New Medicine</a><br>
    <a href="view_medicines.php">View Medicines</a>
</body>
</html>
