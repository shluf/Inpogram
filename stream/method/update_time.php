<?php

include "../../database.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $current_time = $_POST['current_time'];
    
    $stmt = $conn->prepare("UPDATE rooms SET current_time = ? WHERE id = ?");
    $stmt->execute([$current_time, $room_id]);
    
    echo json_encode(['success' => true]);
}

?>