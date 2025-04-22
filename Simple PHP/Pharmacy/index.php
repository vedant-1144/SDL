<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Management System</title>
</head>
<body>
    <p>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></p>

    <h2>Add Medicine</h2>
    <form method="post" action="save.php">
        <label>Medicine Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category"><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>

        <label>Price per Unit (Rs):</label><br>
        <input type="number" name="price" required><br><br>

        <input type="submit" value="Add Medicine">
    </form>

    <hr>

    <h2>All Medicines</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price (Rs)</th>
            <th>Added On</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM medicines ORDER BY added_on DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['added_on']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
