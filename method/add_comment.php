<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post']) && isset($_POST['post_id'])) {
    if ($_POST['comment_post'] != '') {
        $comment_text = $_POST['comment_post'];
        $post_id = $_POST['post_id'];
        $username = $_SESSION['username'];

        // Insert the comment into the database
        $sql = "INSERT INTO Comments (PostID, Username, Content, DATETIME) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $post_id, $username, $comment_text);
        if ($stmt->execute()) {
            // Redirect back to the feed or post
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    header("Location: ../dashboard.php");
}
