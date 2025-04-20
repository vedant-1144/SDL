<?php
include 'db.php';

$sql = "SELECT applications.id, students.name AS student_name, courses.name AS course_name, applications.application_date, applications.status
        FROM applications
        JOIN students ON applications.student_id = students.id
        JOIN courses ON applications.course_id = courses.id
        ORDER BY applications.application_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Applications</title>
</head>
<body>
    <h1>View Applications</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Course Name</th>
            <th>Application Date</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
                echo "<td>" . $row['application_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No applications found</td></tr>";
        }
        ?>
    </table>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
