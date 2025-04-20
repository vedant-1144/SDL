<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart'];
$product_ids = array_keys($cart);
$products = [];

if (count($product_ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $types = str_repeat('i', count($product_ids));
    $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
}

$total = 0;
foreach ($cart as $id => $qty) {
    $total += $products[$id]['price'] * $qty;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For simplicity, no user authentication or payment integration
    // Insert order and order items into database

    // Insert user_id as 1 for demo purposes
    $user_id = 1;

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $id => $qty) {
        $price = $products[$id]['price'];
        $stmt_item->bind_param("iiid", $order_id, $id, $qty, $price);
        $stmt_item->execute();
    }

    // Clear cart
    unset($_SESSION['cart']);

    $message = "Order placed successfully! Your order ID is " . $order_id;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Grocery Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Checkout</h1>
    <a href="cart.php">Back to Cart</a>

    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
        <p><a href="index.php">Continue Shopping</a></p>
    <?php else: ?>
        <h2>Order Summary</h2>
        <ul>
            <?php foreach ($cart as $id => $qty): ?>
                <li><?php echo htmlspecialchars($products[$id]['name']); ?> x <?php echo $qty; ?> = $<?php echo number_format($products[$id]['price'] * $qty, 2); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>

        <form method="post" action="">
            <button type="submit">Place Order</button>
        </form>
    <?php endif; ?>
</body>
</html>
