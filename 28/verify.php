<?php
require 'db.php';

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Find user with the token
    $stmt = $pdo->prepare("SELECT id, is_verified FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['is_verified']) {
            $message = 'Your email is already verified.';
        } else {
            // Update user to verified
            $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
            $stmt->execute([$user['id']]);
            $message = 'Your email has been successfully verified!';
        }
    } else {
        $message = 'Invalid verification token.';
    }
} else {
    $message = 'No verification token provided.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Email Verification</h2>
    <p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>
