<?php
session_start();
require 'db.php';

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grocery Store - Product Listing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Grocery Store - Products</h1>
    <a href="cart.php">View Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
    <div class="products">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="product">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</body>
</html>
