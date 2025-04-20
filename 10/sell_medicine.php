<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_id = intval($_POST['medicine_id']);
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $quantity = intval($_POST['quantity']);

    // Check if medicine exists and has enough quantity
    $sql = "SELECT price, quantity FROM medicines WHERE id = $medicine_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        die("Medicine not found.");
    }
    $medicine = $result->fetch_assoc();
    if ($medicine['quantity'] < $quantity) {
        die("Not enough quantity in stock.");
    }

    // Check if customer exists, if not insert
    $sql = "SELECT id FROM customers WHERE name = '$customer_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $customer_id = $customer['id'];
    } else {
        $sql = "INSERT INTO customers (name) VALUES ('$customer_name')";
        if ($conn->query($sql) === TRUE) {
            $customer_id = $conn->insert_id;
        } else {
            die("Error inserting customer: " . $conn->error);
        }
    }

    // Calculate total price
    $total_price = $medicine['price'] * $quantity;

    // Insert sale record
    $sql = "INSERT INTO sales (medicine_id, customer_id, quantity, total_price) VALUES ($medicine_id, $customer_id, $quantity, $total_price)";
    if ($conn->query($sql) === TRUE) {
        // Update medicine quantity
        $new_quantity = $medicine['quantity'] - $quantity;
        $sql = "UPDATE medicines SET quantity = $new_quantity WHERE id = $medicine_id";
        $conn->query($sql);

        echo "Sale recorded successfully.";
        echo "<br><a href='index.php'>Record another sale</a>";
        echo "<br><a href='view_sales.php'>View sales</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
?>
