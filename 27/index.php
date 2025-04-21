<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Books Catalogue</title>
  <style>
    body { font-family: Arial; }
    .book { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
  </style>
</head>
<body>

  <h2>📚 Books Catalogue</h2>

  <?php
  $result = $conn->query("SELECT * FROM books");

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<div class='book'>";
          echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
          echo "<p><b>Author:</b> " . htmlspecialchars($row['author']) . "</p>";
          echo "<p><b>Price:</b> ₹" . htmlspecialchars($row['price']) . "</p>";
          echo "</div>";
      }
  } else {
      echo "No books available.";
  }

  $conn->close();
  ?>
</body>
</html>
