<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Check if user already liked the post
$check_sql = "SELECT id FROM likes WHERE post_id=$post_id AND user_id=$user_id";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    // Unlike
    $delete_sql = "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id";
    $conn->query($delete_sql);
} else {
    // Like
    $insert_sql = "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)";
    $conn->query($insert_sql);
}

header("Location: news_feed.php");
exit();
?>
