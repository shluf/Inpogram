<?php
include "../database.php";

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "
        SELECT Comments.Username, Comments.Content, Comments.DATETIME, Users.PhotoProfile AS avatar
        FROM Comments
        JOIN Users ON Comments.Username = Users.Username
        WHERE Comments.PostID = ?
        ORDER BY Comments.DATETIME DESC;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            'username' => $row['Username'],
            'text' => $row['Content'],
            'datetime' => date("F j, Y, g:i a", strtotime($row['DATETIME'])),
            'avatar' => $row['avatar'] ?: 'default_avatar.jpg'
        ];
    }

    echo json_encode($comments);
}
?>
