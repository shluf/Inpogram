<?php
// video_server.php

header('Content-Type: application/json');

// Simulasi informasi video dari database
$videoInfo = [
    'id' => 1,
    'title' => 'Live Stream',
    'url' => 'videos/video.mp4',
    'current_time' => time()
];

echo json_encode($videoInfo);
?>