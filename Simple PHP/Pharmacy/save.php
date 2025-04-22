<?php
include 'db.php';

$name = $_POST['name'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "INSERT INTO medicines (name, category, quantity, price)
        VALUES ('$name', '$category', '$quantity', '$price')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>