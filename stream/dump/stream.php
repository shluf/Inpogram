<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Video Streaming</title>
    <style>
        body { font-family: Arial, sans-serif; }
        #videoContainer { margin-top: 20px; }
        #controls { margin-top: 20px; }
        #videoList { margin-top: 20px; }
        #uploadForm { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Group Video Streaming</h1>

    <div id="videoContainer">
        <video id="videoPlayer" width="640" height="360" controls>
            <source id="videoSource" src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div id="controls">
        <button onclick="playVideo()">Play</button>
        <button onclick="pauseVideo()">Pause</button>
        <input type="number" id="timeInput" placeholder="Set time (seconds)">
        <button onclick="setVideoTime()">Set Time</button>
    </div>

    <div id="videoList">
        <h2>Select Video</h2>
        <ul id="videoSelection"></ul>
    </div>

    <div id="uploadForm">
        <h2>Upload Video</h2>
        <form id="videoUploadForm" enctype="multipart/form-data">
            <input type="file" name="video" accept="video/mp4" required>
            <button type="submit">Upload</button>
        </form>
        <div id="uploadStatus"></div>
    </div>

    <script>
        let video = document.getElementById('videoPlayer');
        let videoSource = document.getElementById('videoSource');

        async function fetchJSON(url) {
            let response = await fetch(url);
            return await response.json();
        }

        async function loadVideos() {
            let data = await fetchJSON('method/stream_backend.php?action=get_videos');
            let videoList = document.getElementById('videoSelection');
            videoList.innerHTML = '';
            data.videos.forEach(video => {
                let li = document.createElement('li');
                li.innerHTML = `<a href="#" onclick="selectVideo('${video}')">${video}</a>`;
                videoList.appendChild(li);
            });
        }

        async function selectVideo(video) {
            await fetch(`method/stream_backend.php?action=set_video&video=${video}`);
            loadCurrentVideo();
        }

        async function loadCurrentVideo() {
            let data = await fetchJSON('method/stream_backend.php?action=get_video');
            if (data.video) {
                videoSource.src = `videos/${data.video}`;
                video.load();
                syncVideo();
            }
        }

        async function getCurrentTime() {
            let data = await fetchJSON('method/stream_backend.php?action=get_time');
            return data.time;
        }

        async function syncVideo() {
            let currentTime = await getCurrentTime();
            video.currentTime = currentTime;
            video.play();
        }

        async function setVideoTime() {
            let time = document.getElementById('timeInput').value;
            await fetch(`method/stream_backend.php?action=set_time&time=${time}`);
            video.currentTime = time;
        }

        function playVideo() {
            video.play();
        }

        function pauseVideo() {
            video.pause();
        }

        document.getElementById('videoUploadForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            let response = await fetch('method/stream_backend.php?action=upload_video', {
                method: 'POST',
                body: formData
            });
            let result = await response.json();
            let uploadStatus = document.getElementById('uploadStatus');
            if (result.status === 'success') {
                uploadStatus.textContent = 'Upload successful';
                loadVideos();
            } else {
                uploadStatus.textContent = 'Upload failed: ' + result.message;
            }
        });

        video.addEventListener('loadedmetadata', () => {
            syncVideo();
        });

        setInterval(async () => {
            if (!video.paused) {
                await fetch(`method/stream_backend.php?action=set_time&time=${video.currentTime}`);
            }
        }, 5000);

        loadVideos();
        loadCurrentVideo();
    </script>
</body>
</html>
