<?php
session_start();

$action = $_GET['action'] ?? '';
$video = $_GET['video'] ?? '';
$time = $_GET['time'] ?? 0;

switch ($action) {
    case 'get_videos':
        // Mengembalikan daftar video
        $videos = array_filter(glob('../videos/*.mp4'), 'is_file');
        $videoList = array_map(function($v) { return basename($v); }, $videos);
        echo json_encode(['videos' => $videoList]);
        break;

    case 'get_time':
        // Mengembalikan waktu tayang saat ini
        $currentTime = file_get_contents('current_time.txt');
        echo json_encode(['time' => $currentTime]);
        break;

    case 'set_time':
        // Mengatur waktu tayang baru
        file_put_contents('current_time.txt', $time);
        echo json_encode(['status' => 'success']);
        break;

    case 'set_video':
        // Mengatur video yang diputar
        file_put_contents('current_video.txt', $video);
        echo json_encode(['status' => 'success']);
        break;

    case 'get_video':
        // Mengembalikan video yang sedang diputar
        $currentVideo = file_get_contents('current_video.txt');
        echo json_encode(['video' => $currentVideo]);
        break;

    case 'upload_video':
        // Mengelola upload video
        if ($_FILES['video']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['video']['tmp_name'])) {
            $uploadDir = 'videos/';
            $uploadFile = $uploadDir . basename($_FILES['video']['name']);
            if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadFile)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
        }
        break;
}
?>
