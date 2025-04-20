<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaint Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 30px;
        }

        h1 {
            color:rgb(222, 47, 24);
        }

        form {
            display: inline-block;
            text-align: left;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 90%;
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Submit a Complaint</h1>
    <form action="create_complaint.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="complaint">Complaint:</label><br>
        <textarea id="complaint" name="complaint" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
    <br>
    
    <table border="5" cellpadding="10"> 
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Complaint</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM complaints");
        if ($result->num_rows > 0) {       
            while($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['complaint']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                </tr> ";
            }
        } else {
            echo "<tr> <td colspan='6'> No complaints found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
