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
    <title><?php echo htmlspecialchars($room['RoomName']); ?> - Stream</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($room['RoomName']); ?></h1>
    <video id="videoPlayer" src="<?php echo htmlspecialchars($room['VideoPath']); ?>" controls></video>
    <div id="adminControls">
        <button onclick="playVideo()">Play</button>
        <button onclick="pauseVideo()">Pause</button>
    </div>
    
    <div id="comments"></div>
    <input type="text" id="commentInput" placeholder="Enter your comment">
    <button onclick="sendComment()">Send</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <script>
        const socket = io('http://your-websocket-server');
        const videoPlayer = document.getElementById('videoPlayer');
        const comments = document.getElementById('comments');
        const commentInput = document.getElementById('commentInput');
        const adminControls = document.getElementById('adminControls');

        let isAdmin = <?php echo isset($_GET['admin']) ? 'true' : 'false'; ?>;

        socket.on('connect', () => {
            socket.emit('join_room', <?php echo $room_id; ?>);
        });

        socket.on('update_time', (time) => {
            videoPlayer.currentTime = time;
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
            socket.emit('comment', { room_id: <?php echo $room_id; ?>, message: message });
            commentInput.value = '';
        }

        function playVideo() {
            videoPlayer.play();
            socket.emit('video_control', { room_id: <?php echo $room_id; ?>, action: 'play' });
        }

        function pauseVideo() {
            videoPlayer.pause();
            socket.emit('video_control', { room_id: <?php echo $room_id; ?>, action: 'pause' });
        }

        if (isAdmin) {
            adminControls.style.display = 'block';
            videoPlayer.addEventListener('timeupdate', () => {
                socket.emit('update_time', { room_id: <?php echo $room_id; ?>, time: videoPlayer.currentTime });
            });
        } else {
            videoPlayer.controls = false;
        }
    </script>
</body>
</html>