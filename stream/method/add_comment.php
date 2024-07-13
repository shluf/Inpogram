<?php

include "../../database.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO Comments (room_id, user_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$room_id, $user_id, $message]);
    
    echo json_encode(['success' => true]);
}

?>