<?php
if (isset($_GET['new_video_path'])) {
        $new_video_path = $_GET['new_video_path'];
        $stmt = $conn->prepare("UPDATE rooms SET VideoPath = ? WHERE RoomID = ?");
        $stmt->execute([$new_video_path, $room_id]);
        $room['VideoPath'] = $new_video_path;
    }
?>