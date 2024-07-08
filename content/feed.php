<?php

include "database.php";

$logged_in_user = $_SESSION['username'];

$sql = "
    SELECT Posts.PostID, Posts.Username, Posts.Image, Posts.DESCRIPTION, Posts.DATETIME,
    (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID) AS LikeCount, 
    (SELECT COUNT(*) FROM Comments WHERE Comments.PostID = Posts.PostID) AS CommentsCount,
    (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID AND Likes.Username = ?) AS UserLiked
    FROM Posts
    JOIN FOLLOWS ON Posts.Username = FOLLOWS.FollowedUsername
    WHERE FOLLOWS.FollowerUsername = ?
    ORDER BY Posts.DATETIME DESC;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $logged_in_user, $logged_in_user);
$stmt->execute();
$result = $stmt->get_result();


?>

<div class="app">
  <main class="feed-container">
    <section class="header">
      <h1 class="feed-title">Inpogram</h1>

    </section>

    <section class="status">
      <ul class="status-list">
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-plus-circle status-icon" style="border-radius: 50%;"></i>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>

        </li>
      </ul>
    </section>

    <section class="feeds">
      <section class="new-content content shadow-sm">
        <div class="content-header">
          <img src="<?= $_SESSION['profilepict'] ?>" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
        </div>
        <div class="content-body">
          <textarea id="feed-caption" rows="2" cols="60" placeholder="Apa yang sedang kamu pikirkan?"></textarea>
          <div class="d-flex gap-2 d-flex justify-content-end mt-2 mx-2">
            <button class="btn btn-primary" onclick="moveCaption()">Bagikan</button>
          </div>
        </div>
      </section>

      <?php include "component/modalPost.php"; ?>

      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>

          <div class="content shadow-sm">
            <div class="content-header">
              <i class="bi bi-person-circle"></i>
              <div class="username-time">
                <p class="username">@<?php echo $row['Username']; ?></p>
                <p class="time"><?php echo date("F j, Y, g:i a", strtotime($row['DATETIME'])); ?></p>
              </div>
            </div>
            <div class="content-body">
              <p><?php echo $row['DESCRIPTION']; ?></p>
              <?php if ($row['Image']) { ?>
                <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                  <img class="rounded" src="<?php echo $row['Image']; ?>" alt="profile">

                  <div id="like" class="d-flex gap-2 w-100 justify-content-start px-md-5 px-2">
                    <div class="btn" onclick="addLike(<?php echo $row['PostID']; ?>)">
                      <span><?php echo $row['LikeCount']; ?></span>
                      <?php
                      if ($row['UserLiked'] == 0) {
                        echo '<i id="like-icon-' . $row['PostID'] . '" class="bi bi-heart"></i>';
                      } else {
                        echo '<i id="like-icon-' . $row['PostID'] . '" class="bi bi-heart-fill" style="color:red;"></i>';
                      }
                      ?>
                    </div>

                    <div class="btn" data-bs-toggle="modal" data-bs-target="#commentsModal" onclick="loadComments(<?= $row['PostID']; ?>, '<?= $row['Image']; ?>', '<?= $row['Username']; ?>', '<?= $row['DESCRIPTION']; ?>')">
                      <span><?php echo $row['CommentsCount']; ?></span>
                      <i class="bi bi-chat-left-text"></i>
                    </div>
                    <i class="bi bi-share btn"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Kosong...</p>";
      }
      $stmt->close();
      $conn->close();
      ?>
    </section>

    <script src="js/loadComments.js"></script>
    <script>
      function moveCaption() {
        const captionText = document.getElementById('feed-caption').value;
        window.location.href = 'upload.php?caption=' + encodeURIComponent(captionText);
      }

      function addLike(postId) {
        fetch('method/add_like.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
              post_id: postId
            })
          })
          .then(response => response.text())
          .then(data => {
            if (data == "Liked") {
              location.reload();
            } else if (data == "Unliked") {
              location.reload();
            }
          })
          .catch(error => console.error('Error:', error));
      }
    </script>

  </main>