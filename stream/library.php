<?php
// var_dump(shell_exec("whoami"));

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);

include "../database.php";

$notification = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $target_dir = "videos/";
    $original_file_name = basename($_FILES["fileToUpload"]["name"]);
    // echo '<script>console.log("' . $original_file_name . '")</script>';
    $videoFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

    $new_file_name = $target_dir . date("YmdHis") . "_" . uniqid() . "." . $videoFileType;

    $uploadOk = 1;

    if ($_FILES["fileToUpload"]["size"] > 1500000000) {
        echo json_encode(['status' => 'error', 'message' => '*File besar terdeteksi.']);
        exit;
    }

    if ($videoFileType != "mp4" && $videoFileType != "webm" && $videoFileType != "mkv") {
        echo json_encode(['status' => 'error', 'message' => '*Hanya mp4, webm, dan mkv yang diizinkan.']);
        exit;
    }

    if ($uploadOk == 1) {
        $uploaded = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_file_name);

        if ($uploaded) {
            $thumbnail = 'videos/thumb/' . date("YmdHis") . "_" . uniqid() . ".jpg";
            $ffmpeg = "/usr/bin/ffmpeg";
            $cmd = "LD_LIBRARY_PATH=/usr/lib $ffmpeg -i $new_file_name -ss 00:00:01.000 -vframes 1 $thumbnail 2>&1";
            $output = [];
            $return_var = 0;
            exec($cmd, $output, $return_var);

//            if ($return_var !== 0) {
//                echo json_encode(['status' => 'error', 'message' => '*Error saat membuat thumbnail: ' . implode("\n", $output)]);
//                exit;
//            }


            $logged_in_user = $_SESSION['username'];
            $sql = "INSERT INTO Videos (Title, Thumbnail, Uploader, VideoPath, Description, Datetime) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $title, $thumbnail, $logged_in_user, $new_file_name, $description);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => '*Video telah berhasil terunggah.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => '*Ada kesalahan saat menyimpan data.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => '*Ada kesalahan saat mengunggah file.']);
        }
    }
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
    <link rel="stylesheet" href="../style/stream.css" />
    <title>Inpogram - Stream</title>
    <style>
        main {
            padding-left: 90px;
            padding-right: 90px;
        }

        #progressBar {
            width: 100%;
            background-color: #ddd;
        }

        #progressBar div {
            width: 0;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }
    </style>
</head>

<body>
    <?php include("../component/leftBarStream.php") ?>
    
    <main>
        <h1 class="feed-title">Upload Video</h1>

    <div class="container mb-4 p-5 rounded" style="max-width: 600px; background: white;">
        <form id="uploadForm" action="library.php" method="post" enctype="multipart/form-data" class="form-group">
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Pilih video untuk diunggah:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Judul:</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi:</label>
                <textarea name="description" id="description" rows="4" cols="50" class="form-control"></textarea>
            </div>
            <p id="notification" class="text-danger"></p>
            
            <div id="progressBar" class="progress">
                <div class="progress-bar" role="progressbar"></div>
            </div>
            <br>
            <input type="submit" value="Unggah Video" name="submit" class="btn btn-primary">
        </form>
        </div>


        <h1 class="feed-title">Daftar Video</h1>

        <div class="px-5 row">
            <?php
            include "../database.php";
            $stmt = $conn->prepare("SELECT * FROM Videos");
            $stmt->execute();
            $videos = $stmt->get_result();

            while ($video = $videos->fetch_assoc()) {
                echo '<div class="col-md-3 mb-3">';
                echo '<div class="video-item shadow-sm relative" style="background-image: url(' . htmlspecialchars($video['Thumbnail']) . '); min-height: 300px; overflow: hidden;">';
                echo '<span style="z-index: 20;position:absolute; top: 0; left: 0; height:100%; width:100%; background: linear-gradient(to bottom, rgba(255,255,255,1), rgba(255,255,255,0.9), rgba(255,255,255,0.5));"></span>';
                echo '<div style="z-index: 30; position: relative;">';
                echo '<h3>' . htmlspecialchars($video['Title']) . '</h3>';
                echo '<p>' . htmlspecialchars($video['DESCRIPTION']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <hr>


        
    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total * 100;
                                $('#progressBar div').css('width', percentComplete + '%');
                                $('#progressBar div').html(Math.round(percentComplete) + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    url: 'library.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var res = JSON.parse(response);
                        $('#notification').html(res.message);
                    },
                    error: function() {
                        $('#notification').html('*Ada kesalahan saat mengunggah file.');
                    }
                });
            });

            $('#fileToUpload').on('change', function() {
                if (this.files.length > 1) {
                    alert('Hanya satu file yang diizinkan.');
                    this.value = '';
                }
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>
