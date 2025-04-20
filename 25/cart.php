<?php
session_start();
require 'db.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

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

// Handle update quantities or remove items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantities'] as $id => $qty) {
            $id = intval($id);
            $qty = intval($qty);
            if ($qty < 1) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id] = $qty;
            }
        }
    } elseif (isset($_POST['clear'])) {
        unset($_SESSION['cart']);
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart - Grocery Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <a href="index.php">Continue Shopping</a>
    <?php if (empty($cart)) : ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $id => $qty):
                        $product = $products[$id];
                        $subtotal = $product['price'] * $qty;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="0" />
                        </td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" name="update">Update Cart</button>
            <button type="submit" name="clear">Clear Cart</button>
        </form>
        <p><a href="checkout.php">Proceed to Checkout</a></p>
    <?php endif; ?>
</body>
</html>
