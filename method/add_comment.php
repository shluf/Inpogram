<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post']) && isset($_POST['post_id'])) {
    if ($_POST['comment_post'] != '') {
        $comment_text = $_POST['comment_post'];
        $post_id = $_POST['post_id'];
        $username = $_SESSION['username'];
        $reply_comment_id = isset($_POST['reply_comment_id']) && !empty($_POST['reply_comment_id']) ? $_POST['reply_comment_id'] : null;

        if ($reply_comment_id === null) {
            $sql = "INSERT INTO Comments (PostID, Username, Content, DATETIME) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $post_id, $username, $comment_text);
        } else {
            $sql = "INSERT INTO Comments (PostID, Username, Content, DATETIME, ReplyToCommentID) VALUES (?, ?, ?, NOW(), ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issi", $post_id, $username, $comment_text, $reply_comment_id);
        }

        if ($stmt->execute()) {
            // Redirect back to the feed or post
            // header("Location: ".$_SERVER['REQUEST_URI']);
            echo "<script>window.location.href = '" . $_SERVER["HTTP_REFERER"] . "'; console.log('" . $_SERVER["HTTP_REFERER"] . "');</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
    // echo "Masukan komentar";
}
?>