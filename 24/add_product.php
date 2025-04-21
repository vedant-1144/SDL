<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $sql = "INSERT INTO products (name, price, description) 
            VALUES ('$name', '$price', '$desc')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Product added successfully!<br><a href='index.php'>Back to Catalog</a>";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Product</title></head>
<body>
  <h2>➕ Add New Product</h2>
  <form method="POST" action="">
    <label>Product Name: <input type="text" name="name" required></label><br><br>
    <label>Price: ₹<input type="number" step="0.01" name="price" required></label><br><br>
    <label>Description:<br>
      <textarea name="description" rows="4" cols="40" required></textarea>
    </label><br><br>
    <input type="submit" value="Add Product">
  </form>
  <br>
  <a href="index.php">⬅ Back to Catalog</a>
</body>
</html>
