<?php
header('Content-Type: application/json');
require 'db.php';

$sql = "SELECT id, title, author, description, published_year FROM books ORDER BY created_at DESC";
$result = $conn->query($sql);

$books = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

echo json_encode($books);

$conn->close();
?>
