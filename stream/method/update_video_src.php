<?php
include "../../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_video_id']) && isset( $_POST['id'])) {
        $room_id = $_POST['id'];
        $new_video_id = $_POST['new_video_id'];
        $stmt = $conn->prepare("UPDATE Rooms SET VideoID = ? WHERE RoomID = ?");
        $stmt->execute([$new_video_id, $room_id]);

        echo json_encode(['success' => true]);

    } else {
        echo $room_id;
        echo $new_video_id;
        echo json_encode(['success' => false]);
    }
}
