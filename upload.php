<?php
session_start();
include "method/check_session.php";

include "database.php";

$notification="";

// Method untuk mengunggah gambar dan menyimpan data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = $_POST['caption'];
    $target_dir = "images/posts/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check) {
        $uploadOk = 1;
    } else {
        $notification = "*File bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $notification = "*File terlalu besar.";
        $uploadOk = 0;
    }

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $notification = "*Hanya JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika $uploadOk
    if ($uploadOk == 1) {
        $uploaded = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        
        if ($uploaded) {

            $logged_in_user = $_SESSION['username'];
            $sql = "INSERT INTO Posts (Username, Image, DESCRIPTION, DATETIME) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $logged_in_user, $target_file, $caption);
            if ($stmt->execute()) {
                $notification = "*File " . basename($_FILES["fileToUpload"]["name"]) . " telah terunggah.";
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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css" />
  <link rel="stylesheet" href="style/upload.css" />
  <title>Inpogram - Upload</title>
</head>

<body>

<?php include("component/leftBar.php") ?>
<?php include("content/uploadFile.php") ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>