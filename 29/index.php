<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Web Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {    
            background-color: white;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            margin-top: 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Simple PHP Web Application</h1>
        <p>Please fill out the contact form below:</p>
        <form action="process_form.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
