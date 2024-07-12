<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include "../database.php";


$notification = "";

// Method untuk mengunggah video dan menyimpan data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $target_dir = "videos/";
    $original_file_name = basename($_FILES["fileToUpload"]["name"]);
    $videoFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

    $new_file_name = $target_dir . date("YmdHis") . "_" . uniqid() . "." . $videoFileType;

    $uploadOk = 1;
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    // if ($check) {
    //     $uploadOk = 1;
    // } else {
    //     $notification = "*File bukan gambar.";
    //     $uploadOk = 0;
    // }

    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $notification = "*File besar terdeteksi.";
        $uploadOk = 1;
    }

    if ($videoFileType != "mp4" && $videoFileType != "mp4") {
        $notification = "*Hanya mp4 yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        $uploaded = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_file_name);

        if ($uploaded) {
            $logged_in_user = $_SESSION['username'];
            $sql = "INSERT INTO Videos (Uploader, Video, DESCRIPTION, DATETIME) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $logged_in_user, $new_file_name, $description);
            if ($stmt->execute()) {
                $notification = "*Video telah berhasil terunggah.";
            } else {
                $notification = "*Ada kesalahan saat menyimpan data.";
            }
            $stmt->close();
        } else {
            $notification = "*Ada kesalahan saat mengunggah file.";
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
    <title>Inpogram - Stream</title>
</head>
<body>
<h1>Style</h1>
<?php

$stmt = $conn->prepare("SELECT * FROM rooms");
$stmt->execute();
$rooms = $stmt->get_result();

while ($row = $rooms->fetch_assoc()) {
        echo '<p>Room Name: ' . htmlspecialchars($row['RoomName'], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p>Description: ' . htmlspecialchars($row['Descriptions'], ENT_QUOTES, 'UTF-8') . '</p>';
        if ($row['LiveNow']) {
            echo '<p>Sedang Tayang</p>';
        }
        echo '<a href="room.php?id=' . htmlspecialchars($row['RoomID'], ENT_QUOTES, 'UTF-8') . '">Join</a>';
        echo '<hr>';
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Pilih video untuk diunggah:</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <label for="description">Deskripsi:</label>
    <textarea name="description" id="description" rows="4" cols="50"></textarea>
    <br>
    <input type="submit" value="Unggah Video" name="submit">
</form>


</body>
</html>