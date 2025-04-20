<?php
include 'db.php';

$sql = "SELECT id, name, email, complaint, status, created_at FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
</head>
<body>
    <h1>Complaints List</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Complaint</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No complaints found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <br>
    <a href="index.php">Submit New Complaint</a>
</body>
</html>
