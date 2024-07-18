<?php
session_start();
include "method/check_session.php";

include "database.php";

$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveProfile'])) {
  $newFullname = ($_POST['fullname'] == '' ? $_SESSION['fullname'] : $_POST['fullname']);
  $newBio = $_POST['bio'];
  $newPhoto = $_SESSION['profilepict'];

  if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == UPLOAD_ERR_OK) {
      $target_dir = 'images/profiles/';
      $newPhoto = $target_dir . date("YmdHis") . "_" . uniqid() . "_" . basename($_FILES['profilePhoto']['name']);
      
      move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $newPhoto);
      $_SESSION['profilepict'] = $newPhoto;
  }

  // Update query untuk memperbarui informasi pengguna
  $queryUpdate = "UPDATE Users SET NAME = ?, Bio = ?, PhotoProfile = ? WHERE Username = ?";
  $stmtUpdate = $conn->prepare($queryUpdate);
  $stmtUpdate->bind_param('ssss', $newFullname, $newBio, $newPhoto, $username);
  $stmtUpdate->execute();

  // Refresh data pengguna
  $_SESSION['fullname'] = $newFullname;
  $fullname = $newFullname;

 
}

// Query untuk mendapatkan informasi pengguna
$queryUserInfo = "SELECT * FROM Users WHERE Username = ?";
$stmtUserInfo = $conn->prepare($queryUserInfo);
$stmtUserInfo->bind_param('s', $username);
$stmtUserInfo->execute();
$resultUserInfo = $stmtUserInfo->get_result();
$userInfo = $resultUserInfo->fetch_assoc();

// Query untuk mendapatkan jumlah postingan
$queryPosts = "SELECT COUNT(*) AS PostCount FROM Posts WHERE Username = ?";
$stmtPosts = $conn->prepare($queryPosts);
$stmtPosts->bind_param('s', $username);
$stmtPosts->execute();
$resultPosts = $stmtPosts->get_result();
$postCount = $resultPosts->fetch_assoc()['PostCount'];

// Query untuk mendapatkan jumlah pengikut
$queryFollowers = "SELECT COUNT(*) AS FollowerCount FROM FOLLOWS WHERE FollowedUsername = ?";
$stmtFollowers = $conn->prepare($queryFollowers);
$stmtFollowers->bind_param('s', $username);
$stmtFollowers->execute();
$resultFollowers = $stmtFollowers->get_result();
$followerCount = $resultFollowers->fetch_assoc()['FollowerCount'];

// Query untuk mendapatkan jumlah mengikuti
$queryFollowing = "SELECT COUNT(*) AS FollowingCount FROM FOLLOWS WHERE FollowerUsername = ?";
$stmtFollowing = $conn->prepare($queryFollowing);
$stmtFollowing->bind_param('s', $username);
$stmtFollowing->execute();
$resultFollowing = $stmtFollowing->get_result();
$followingCount = $resultFollowing->fetch_assoc()['FollowingCount'];

// Query untuk mendapatkan daftar pengikut
$queryFollowerList = "SELECT Users.Username, Users.NAME, Users.PhotoProfile FROM FOLLOWS JOIN Users ON FOLLOWS.FollowerUsername = Users.Username WHERE FOLLOWS.FollowedUsername = ?";
$stmtFollowerList = $conn->prepare($queryFollowerList);
$stmtFollowerList->bind_param('s', $username);
$stmtFollowerList->execute();
$resultFollowerList = $stmtFollowerList->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/png" href="images/icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
  <link rel="stylesheet" href="style/gallery.css">
  <link rel="stylesheet" href="style/style.css" />
  <title>Inpogram - Profile</title>
</head>

<body>

  <?php include("component/leftBar.php") ?>
  <div class="app flex-md-row d-flex flex-column-reverse ">
  <main class="my-gallery-container">
    <?php include("content/myProfileGallery.php") ?>
  </main>
  <?php include("component/rightBarProfile.php") ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>