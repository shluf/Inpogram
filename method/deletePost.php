<?php
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $postID = $data['postID'];

    if (!empty($postID)) {
        $sql = "DELETE FROM Posts WHERE PostID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postID);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error executing query.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid PostID.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
