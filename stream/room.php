<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
$login_in_user = $_SESSION['username'];

include "../database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM Rooms");
    $stmt->execute();
    $resultRooms = $stmt->get_result();
    $room = null;
    $isAdmin = false;

    while ($row = $resultRooms->fetch_assoc()) {
        if ($id == $row['RoomCode']) {
            $room = $row;
            if ($room['Admin'] == $login_in_user) {
                $isAdmin = true;
            }
            break;
        }
    }

    $room_id = $room['RoomID'];

    if (!$room) {
        exit('Room not found.');
    }
} else {
    exit('Room ID not provided.');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <title>Inpogram - <?php echo htmlspecialchars($room['RoomName']); ?></title>
    <style>
        main {
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
    <?php include("../component/leftBarStream.php") ?>
    <main>
        <h1><?php echo htmlspecialchars($room['RoomName']); ?></h1>

        <?php

        $stmt = $conn->prepare("SELECT * FROM Videos");
        $stmt->execute();
        $videos = $stmt->get_result();
        // $videos = $videos->fetch_assoc();
        $roomVideo = null;
        foreach ($videos as $video) {
            if ($video['VideoID'] == $room['VideoID']) {
                $roomVideo = $video;
            }
        }


        if ($isAdmin) {
            echo '<label for="videoPath">Pilih video:</label>';
            echo '<select name="videoPath" id="videoPath" onchange="changeVideo(this.value)">';
            foreach ($videos as $video) {
                $selected = ($video['VideoID'] == $room['VideoID']) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($video['VideoID']) . '" ' . $selected . '>' . htmlspecialchars($video['Title']) . '</option>';
            }
            echo '</select>';
        }
        
        ?>

        <video id="videoPlayer" src="<?php echo htmlspecialchars($roomVideo['VideoPath']); ?>"></video>

        <div id="adminControls">
            <button onclick="playVideo()">Play</button>
            <button onclick="pauseVideo()">Pause</button>
            <input type="range" id="timeRange" min="0" max="100" value="0">
            <div class="time-display">
                <span id="currentTime">0:00</span>
                <span id="duration">0:00</span>
            </div>
        </div>

        <div class="video-item">
        <div class="card">
            <div class="card-body">
                <img style="max-width: 100px; max-height: 100px; object-fit: cover;" class="card-title" src="<?php echo htmlspecialchars($roomVideo['Thumbnail']); ?>"></img>
                <h5 class="card-title"><?php echo htmlspecialchars($roomVideo['Title']); ?></h5>
                <p class="card-text">Uploader: <?php echo htmlspecialchars($roomVideo['Uploader']); ?></p>
                <p class="card-text">Description: <?php echo htmlspecialchars($roomVideo['DESCRIPTION']); ?></p>
                <p class="card-text">Uploaded on: <?php echo $roomVideo['DATETIME']; ?></p>
            </div>
        </div>

        </div>

        <aside>
        <div id="comments"></div>
        <input type="text" id="commentInput" placeholder="Enter your comment">
        <button onclick="sendComment()">Send</button>
        </aside>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <script>
        const socket = io('https://socketinpogram.share.zrok.io'
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

        let isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
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


            function changeVideo(videoID) {
                const data = new URLSearchParams();
                data.append('id', <?php echo $room_id; ?>);
                data.append('new_video_id', videoID);

                fetch('method/update_video_src.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: data.toString(),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                            console.log('Video updated successfully');
                        } else {
                            console.error('Failed to update Video');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating videoPath:', error);
                    });

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
                        console.log('LiveNow updated successfully : ', (live_now ? 'live' : 'not live'));
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
