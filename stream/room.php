<?php
$room_id = $_GET['id'] ?? null;
if (!$room_id) {
    exit('Room ID not provided.');
}

include "../database.php";

$stmt = $conn->prepare("SELECT * FROM rooms WHERE RoomID = ?");
$stmt->execute([$room_id]);
$resultRooms = $stmt->get_result();
$room = $resultRooms->fetch_assoc();
if (!$room) {
    exit('Room not found.');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <title>Inpogram - <?php echo htmlspecialchars($room['RoomName']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        #videoPlayer {
            width: 100%;
            max-width: 800px;
        }

        #adminControls {
            display: none;
            margin-top: 10px;
        }

        #timeRange {
            width: 100%;
            margin-top: 10px;
        }

        .time-display {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }

        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 15px;
            border-radius: 5px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            transition: opacity .2s;
        }

        input[type="range"]:hover {
            opacity: 1;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #4CAF50;
            cursor: pointer;
        }

        input[type="range"]::-moz-range-thumb {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #4CAF50;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1><?php echo htmlspecialchars($room['RoomName']); ?></h1>

    <?php

    $stmt = $conn->prepare("SELECT * FROM Videos");
    $stmt->execute();
    $videos = $stmt->get_result();

    echo '<div class="video-item">';
    echo '<label for="videoPath">Pilih video:</label>';
    echo '<select name="videoPath" id="videoPath" onchange="updateVideo(this.value)">';
    foreach ($videos as $video) {
        echo '<option value="' . htmlspecialchars($video['Video']) . '">' . htmlspecialchars($video['Video']) . '</option>';
    }
    echo '</select>';
    echo '<h3>' . htmlspecialchars($video['Uploader']) . '</h3>';
    echo '<p>' . htmlspecialchars($video['DESCRIPTION']) . '</p>';
    echo '<p>' . $video['DATETIME'] . '</p>';
    echo '</div>';
    ?>

    <video id="videoPlayer" src="<?php echo htmlspecialchars($room['VideoPath']); ?>"></video>

    <div id="adminControls">
        <button onclick="playVideo()">Play</button>
        <button onclick="pauseVideo()">Pause</button>
        <input type="range" id="timeRange" min="0" max="100" value="0">
        <div class="time-display">
            <span id="currentTime">0:00</span>
            <span id="duration">0:00</span>
        </div>
    </div>

    <div id="comments"></div>
    <input type="text" id="commentInput" placeholder="Enter your comment">
    <button onclick="sendComment()">Send</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <script>
        const socket = io('https://x5g9hbb7pxzk.share.zrok.io'
        // , {
        //     withCredentials: true
        // }
    );
        const videoPlayer = document.getElementById('videoPlayer');
        const comments = document.getElementById('comments');
        const commentInput = document.getElementById('commentInput');
        const adminControls = document.getElementById('adminControls');
        const timeRange = document.getElementById('timeRange');
        const currentTimeSpan = document.getElementById('currentTime');
        const durationSpan = document.getElementById('duration');

        let isAdmin = <?php echo isset($_GET['admin']) ? 'true' : 'false'; ?>;
        let isSeekingByAdmin = false;

        socket.on('connect', () => {
            socket.emit('join_room', <?php echo $room_id; ?>);
        });

        socket.on('update_time', (time) => {
            if (!isAdmin && !isSeekingByAdmin) {
                videoPlayer.currentTime = time;
                updateTimeDisplay();
            }
        });

        socket.on('video_control', (action) => {
            if (action === 'play') {
                videoPlayer.play();
            } else if (action === 'pause') {
                videoPlayer.pause();
            }
        });

        socket.on('new_comment', (comment) => {
            const commentElement = document.createElement('p');
            commentElement.textContent = comment.message;
            comments.appendChild(commentElement);
        });

        function sendComment() {
            const message = commentInput.value;
            socket.emit('comment', {
                room_id: <?php echo $room_id; ?>,
                message: message
            });
            commentInput.value = '';
        }

        function playVideo() {
            videoPlayer.play();
            socket.emit('video_control', {
                room_id: <?php echo $room_id; ?>,
                action: 'play'
            });
            updateLiveNow(<?php echo $room_id; ?>, 1)
        }

        function pauseVideo() {
            videoPlayer.pause();
            socket.emit('video_control', {
                room_id: <?php echo $room_id; ?>,
                action: 'pause'
            });
        }

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            seconds = Math.floor(seconds % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        function updateTimeDisplay() {
            currentTimeSpan.textContent = formatTime(videoPlayer.currentTime);
            durationSpan.textContent = formatTime(videoPlayer.duration);
            timeRange.value = (videoPlayer.currentTime / videoPlayer.duration) * 100;
            if (timeRange.value >= 100) {
                updateLiveNow(<?php echo $room_id; ?>, 0)
            }
        }

        videoPlayer.addEventListener('loadedmetadata', () => {
            // timeRange.max = videoPlayer.duration;
            updateTimeDisplay();
        });

        videoPlayer.addEventListener('timeupdate', () => {
            if (isAdmin && !isSeekingByAdmin) {
                updateTimeDisplay();
                socket.emit('update_time', {
                    room_id: <?php echo $room_id; ?>,
                    time: videoPlayer.currentTime
                });
            }
        });

        if (isAdmin) {
            adminControls.style.display = 'block';

            timeRange.addEventListener('input', () => {
                isSeekingByAdmin = true;
                const seekTime = (timeRange.value / 100) * videoPlayer.duration;
                videoPlayer.currentTime = seekTime;
                updateTimeDisplay();
            });

            timeRange.addEventListener('change', () => {
                isSeekingByAdmin = false;
                const seekTime = (timeRange.value / 100) * videoPlayer.duration;
                socket.emit('update_time', {
                    room_id: <?php echo $room_id; ?>,
                    time: seekTime
                });
            });

            window.addEventListener('resize', updateTimeDisplay);

            function UpdateVideo() {

            }
        } else {
            videoPlayer.controls = false;
        }


        function updateLiveNow(room_id, live_now) {

            const data = new URLSearchParams();
            data.append('room_id', room_id);
            data.append('live_now', live_now);

            fetch('method/update_live_now.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: data.toString(),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('LiveNow updated successfully');
                    } else {
                        console.error('Failed to update LiveNow');
                    }
                })
                .catch(error => {
                    console.error('Error updating LiveNow:', error);
                });
        }
    </script>
</body>

</html>