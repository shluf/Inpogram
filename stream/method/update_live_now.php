<?php

include "../../database.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['room_id']) && isset($_POST['live_now'])) {
    $room_id = $_POST['room_id'];
    $LiveNow = $_POST['live_now'];
    
    $stmt = $conn->prepare("UPDATE rooms SET LiveNow = ? WHERE RoomID = ?");
    $stmt->execute([$LiveNow, $room_id]);
    
    // echo json_encode(['success' => true]);
    } else {
        echo 'Gagal';
    }
}

?>