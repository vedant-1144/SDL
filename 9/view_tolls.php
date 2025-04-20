<?php
include 'db.php';

$sql = "SELECT tt.id, v.vehicle_number, v.vehicle_type, tb.name AS toll_booth_name, tt.amount, tt.transaction_time
        FROM toll_transactions tt
        JOIN vehicles v ON tt.vehicle_id = v.id
        JOIN toll_booths tb ON tt.toll_booth_id = tb.id
        ORDER BY tt.transaction_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Toll Transactions</title>
</head>
<body>
    <h1>Toll Transactions</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle Number</th>
                <th>Vehicle Type</th>
                <th>Toll Booth</th>
                <th>Amount</th>
                <th>Transaction Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['toll_booth_name']) . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['transaction_time'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No transactions found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Add New Transaction</a>
</body>
</html>
