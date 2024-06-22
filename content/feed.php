<?php

include "database.php";

$logged_in_user = $_SESSION['username'];

$sql = "
    SELECT Posts.PostID, Posts.Username, Posts.Image, Posts.DESCRIPTION, Posts.DATETIME
    FROM Posts
    JOIN FOLLOWS ON Posts.Username = FOLLOWS.FollowedUsername
    WHERE FOLLOWS.FollowerUsername = ?
    ORDER BY Posts.DATETIME DESC;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_user);
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
          <p>add</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
        <li class="profile-status" style="margin: 10px;">
          <i class="bi bi-person-circle status-icon" style="border-radius: 50%;"></i>
          <p>name</p>
        </li>
      </ul>
    </section>

    <section class="feeds">
      <section class="new-content content">
        <div class="content-header">
          <i class="bi bi-person-circle"></i>
        </div>
        <div class="content-body">
          <textarea id="feed-caption" rows="2" cols="60" placeholder="Apa yang sedang kamu pikirkan?"></textarea>
          <div class="d-flex gap-2 d-flex justify-content-end mt-2 mx-2">
            <button class="btn btn-primary" onclick="moveCaption()">Bagikan</button>
          </div>
        </div>
      </section>

      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
          <div class="content">
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
                  <div class="d-flex gap-2 w-100 justify-content-start px-5">
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-chat-left-text"></i>
                    <i class="bi bi-share"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>No posts available.</p>";
      }
      $stmt->close();
      $conn->close();
      ?>
    </section>

    <script>
      function moveCaption() {
        const captionText = document.getElementById('feed-caption').value;
        window.location.href = 'upload.php?caption=' + encodeURIComponent(captionText);
      }
    </script>
  </main>