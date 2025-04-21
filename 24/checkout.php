<?php
session_start();
$_SESSION['cart'] = [];
echo "<h2>✅ Thank you! Your order has been placed.</h2>";
echo "<a href='index.php'>Continue Shopping</a>";
