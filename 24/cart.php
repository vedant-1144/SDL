<?php
include 'db.php';
session_start();
echo "<h2>Your Cart</h2><a href='index.php'>Back to Shop</a><hr>";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
  echo "Your cart is empty.";
  exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
  $result = $conn->query("SELECT * FROM products WHERE id = $id");
  $product = $result->fetch_assoc();
  $line_total = $product['price'] * $qty;
  $total += $line_total;
  echo "<p><b>{$product['name']}</b> × $qty = ₹$line_total</p>";
}
echo "<hr><p><b>Total:</b> ₹$total</p>";
echo "<a href='checkout.php'>Checkout</a>";
?>
