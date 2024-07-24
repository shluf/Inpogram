<?php

include "database.php";

$logged_in_user = $_SESSION['username'];

$sql = "
    SELECT Posts.PostID, Posts.Username, Posts.Image, Posts.OriginalImage, Posts.DESCRIPTION, Posts.DATETIME,
    (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID) AS LikeCount, 
    (SELECT COUNT(*) FROM Comments WHERE Comments.PostID = Posts.PostID) AS CommentsCount,
    (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID AND Likes.Username = ?) AS UserLiked,
    (SELECT PhotoProfile FROM Users WHERE Posts.Username = Users.Username) AS PhotoProfile
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
      <a class="btn d-block d-md-none" href="notifications.php" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
        </svg>
      </a>
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
        <div class="content-header gap-3">
          <img src="<?= $_SESSION['profilepict'] ?>" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">

          <p class="username">@<?php echo $_SESSION['username']; ?></p>

        </div>
        <div class="content-body">
          <textarea id="feed-caption" rows="2" cols="60" style="resize: none;" placeholder="Apa yang sedang kamu pikirkan?"></textarea>
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
              <img src="<?= $row['PhotoProfile'] ?>" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover; margin-right: 10px;">
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

                  <div id="like" class="d-flex gap-2 w-100 justify-content-between px-md-5 px-2"> 
                      <div class="relative">
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
                        <span id="popover-<?php echo $row['PostID']; ?>" class="popoverCopy"></span>
                        <i class="bi bi-share btn" onclick="sharePost(<?php echo $row['PostID']; ?>)"></i>
                      </div>
                    <div>
                      <a href="<?= $row['OriginalImage'] ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-arrows-fullscreen btn"></i>
                      </a>
                    </div>

                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
      <?php
        }

        echo '<p class="text-secondary mt-5">-- END --</p>';
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

      function copyToClipboard(text, postId) {
        navigator.clipboard.writeText(text).then(function() {
          showPopover('Link telah di salin', postId);
        }, function(err) {
          alert('Failed to copy: ', err);
        });
      }

      function sharePost(postId) {
        const url = `https://inpogram.share.zrok.io/share/post.php?id=${postId}`;
        copyToClipboard(url, postId);
      }

      function showPopover(message, postId) {
        const popover = document.getElementById(`popover-${postId}`);
        popover.innerText = message;
        popover.classList.add('show');
        setTimeout(function() {
          popover.classList.remove('show');
        }, 2000);
      }
    </script>

  </main>