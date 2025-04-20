<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) {
        $message = 'Invalid email address.';
    } elseif (empty($password)) {
        $message = 'Password is required.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = 'Email is already registered.';
        } else {
            // Generate verification token
            $token = bin2hex(random_bytes(32));
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = $pdo->prepare("INSERT INTO users (email, password, verification_token) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashed_password, $token]);

            // Send verification email
            $verification_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/verify.php?token=$token";
            $subject = "Email Verification";
            $body = "Please click the following link to verify your email: $verification_link";
            $headers = "From: no-reply@example.com";

            if (mail($email, $subject, $body, $headers)) {
                $message = 'Registration successful! Please check your email to verify your account.';
            } else {
                $message = 'Failed to send verification email.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification Registration</title>
</head>
<body>
    <h2>Register</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
