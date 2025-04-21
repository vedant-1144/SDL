<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head><title>Simple eCommerce</title></head>
<body>
  <h2>🛒 Product Catalog</h2>

  <a href="cart.php">View Cart</a>
  <a href="add_product.php">Add Product</a>
  <hr>

  <?php
  $result = $conn->query("SELECT * FROM products");
  while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h3>{$row['name']}</h3>";
    echo "<p>{$row['description']}</p>";
    echo "<p>Price: ₹{$row['price']}</p>";
    echo "<form method='POST' action='add_to_cart.php'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <input type='submit' value='Add to Cart'>
          </form>";
    echo "<hr></div>";
  }
  ?>
</body>
</html>
