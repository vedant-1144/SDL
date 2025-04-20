<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $sql = "INSERT INTO medicines (name, description, price, quantity) VALUES ('$name', '$description', $price, $quantity)";
    if ($conn->query($sql) === TRUE) {
        echo "Medicine added successfully.";
        echo "<br><a href='add_medicine.php'>Add another medicine</a>";
        echo "<br><a href='view_medicines.php'>View medicines</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Medicine</title>
</head>
<body>
    <h1>Add New Medicine</h1>
    <form action="add_medicine.php" method="POST">
        <label for="name">Medicine Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="price">Price:</label><br>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <input type="submit" value="Add Medicine">
    </form>
    <br>
    <a href="index.php">Back to Sales</a><br>
    <a href="view_medicines.php">View Medicines</a>
</body>
</html>
<?php
}
?>
