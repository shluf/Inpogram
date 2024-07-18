<?php
session_start();
include "../database.php";

$notification = "";
// Method untuk mengunggah gambar dan menyimpan data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = $_POST['caption'];
    $target_dir = "images/posts/";
    $imageFileType = strtolower(pathinfo(basename($_FILES["originalImage"]["name"]), PATHINFO_EXTENSION));

    $new_file_name = $target_dir . date("YmdHis") . "_" . uniqid() . "." . $imageFileType;
    $new_original_file_name = $target_dir . "o/" . date("YmdHis") . "_" . uniqid() . "." . $imageFileType;

    $uploadOk = 1;
    $check = getimagesize($_FILES["originalImage"]["tmp_name"]);
    if ($check) {
        $uploadOk = 1;
    } else {
        $notification = "*File bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES["originalImage"]["size"] > 5000000) {
        $notification = "*File terlalu besar.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $notification = "*Hanya JPG, JPEG, PNG & GIF yang diizinkan. >" . $imageFileType;
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        $originalUploaded = move_uploaded_file($_FILES["originalImage"]["tmp_name"], "../" . $new_original_file_name);
        if (!$originalUploaded) {
            $notification = "*Ada kesalahan saat mengunggah file asli.";
            $uploadOk = 0;
        }

        if (isset($_FILES["croppedImage"])) {
            $uploaded = move_uploaded_file($_FILES["croppedImage"]["tmp_name"], "../" . $new_file_name);
            if (!$uploaded) {
                $notification = "*Ada kesalahan saat mengunggah file yang telah dicrop.";
                $uploadOk = 0;
            }
        } else {
            $notification = "*File crop tidak ditemukan.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $logged_in_user = $_SESSION['username'];
            $sql = "INSERT INTO Posts (Username, Image, OriginalImage, DESCRIPTION, DATETIME) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $logged_in_user, $new_file_name, $new_original_file_name, $caption);
            if ($stmt->execute()) {
                $notification = "*Postingan telah berhasil terunggah.";
            } else {
                $notification = "*Ada kesalahan saat menyimpan data.";
            }
            $stmt->close();
        }
    }
    echo json_encode(['success' => $uploadOk == 1, 'notification' => $notification]);
}
?>