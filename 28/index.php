<?php
$conn = new mysqli("localhost", "root", "", "phpmail");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $result = $conn->query("SELECT id FROM users WHERE email = '$email' ");
    if ($result->num_rows > 0) {
        echo "Email already registered!";
        exit;
    }
    
    $token = bin2hex(random_bytes(16)); // 32-character token
    $sql = "INSERT INTO users (name, email, token) VALUES ('$name', '$email', '$token')";

    if ($conn->query($sql) === TRUE) {
        header("Location: verify.php?token=$token");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        .form-box h2 {
            text-align: center;
        }
        .form-box input, .form-box button {
            width: 90%;
            padding: 10px;
            margin: 10px auto;
        }
        .form-box button {
            background:rgb(80, 133, 33);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
