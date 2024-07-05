<?php
session_start();
include '../database.php';

if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    $username = $_SESSION['username'];

    // Check if the user already liked the post
    $checkLike = $conn->prepare("SELECT * FROM Likes WHERE PostID = ? AND Username = ?");
    $checkLike->bind_param("is", $postId, $username);
    $checkLike->execute();
    $result = $checkLike->get_result();

    if ($result->num_rows == 0) {
        // Add like to the post
        $addLike = $conn->prepare("INSERT INTO Likes (PostID, Username) VALUES (?, ?)");
        $addLike->bind_param("is", $postId, $username);
        if ($addLike->execute()) {
            echo "Liked";
        } else {
            echo "Error adding like";
        }
    } else {
        $deleteLike = $conn->prepare("DELETE FROM Likes WHERE PostID = ? AND Username = ?");
        $deleteLike->bind_param("is", $postId, $username);
        if ($deleteLike->execute()) {
            echo "Unliked";
        } else {
            echo "Error adding like";
        }
    }
    $checkLike->close();
    $conn->close();
}
?>
