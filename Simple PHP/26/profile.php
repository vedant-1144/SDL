<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $bio = $conn->real_escape_string($_POST['bio']);

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check === false) {
            $error = "File is not an image.";
        } elseif ($_FILES["profile_picture"]["size"] > 5000000) {
            $error = "Sorry, your file is too large.";
        } elseif(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $conn->real_escape_string($target_file);
                $sql = "UPDATE users SET full_name='$full_name', bio='$bio', profile_picture='$profile_picture' WHERE id=$user_id";
                if ($conn->query($sql) === TRUE) {
                    $success = "Profile updated successfully.";
                } else {
                    $error = "Error updating profile: " . $conn->error;
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update without changing profile picture
        $sql = "UPDATE users SET full_name='$full_name', bio='$bio' WHERE id=$user_id";
        if ($conn->query($sql) === TRUE) {
            $success = "Profile updated successfully.";
        } else {
            $error = "Error updating profile: " . $conn->error;
        }
    }
}

// Fetch user info
$sql = "SELECT username, email, full_name, bio, profile_picture FROM users WHERE id=$user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h2>Your Profile</h2>
    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <?php if ($user['profile_picture']): ?>
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="150"><br>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="profile.php" enctype="multipart/form-data">
        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>"><br><br>
        <label>Bio:</label><br>
        <textarea name="bio" rows="4" cols="50"><?php echo htmlspecialchars($user['bio']); ?></textarea><br><br>
        <label>Profile Picture:</label><br>
        <input type="file" name="profile_picture" accept="image/*"><br><br>
        <input type="submit" value="Update Profile">
    </form>

    <p><a href="news_feed.php">Back to News Feed</a> | <a href="logout.php">Logout</a></p>
</body>
</html>
