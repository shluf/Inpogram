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


// Check if the user already liked the post


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
      <section class="new-content content">
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


      <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-body p-0" style="height: 468px;">

              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-6 p-0">

                        <img id="modalImage" style="width: 100%; min-width: 468px; min-height: 468px; object-fit: cover; border-radius: 5px 0 0 5px" src="" alt="profile">

                      </div>
                      <div class="col-6">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="commentsModalLabel">Komentar</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>



                        <section class="overflow-y-auto" style="height: calc(468px - 62.8px);">
                          <div id="post-desc">

                          </div>
                          <div class="container" id="commentContainer">
                            <!-- Komentar akan ditambahkan di sini -->
                          </div>
                        </section>

                        <form id="commentForm" method="post" action="method/add_comment.php">
                          <div class="position-absolute w-100" style="bottom: -1px;">
                            <div class="row">
                              <div class="col-5 p-0">
                                <input type="hidden" id="postId" name="post_id">
                                <input type="text" class="form-control" id="comment-post" name="comment_post" placeholder="Tambah komentar..." style="border:0 solid white; border-radius:0;">
                              </div>
                              <div class="col-1 p-0">
                                <button type="submit" class="btn w-100"><i class="bi bi-send"></i></button>
                              </div>
                            </div>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

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

                  <div id="like" class="d-flex gap-2 w-100 justify-content-start px-5">
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

    <script>
      function loadComments(postId, imageUrl, postUsername, description) {
        document.getElementById('postId').value = postId;

        document.getElementById('modalImage').src = imageUrl;

        document.getElementById('post-desc').innerHTML = `<p><b style="margin-right: 5px;">@${postUsername}</b>${description}</p>`

        const commentContainer = document.getElementById('commentContainer');
        commentContainer.innerHTML = '';

        fetch(`method/get_comments.php?post_id=${postId}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(comment => {
              const commentElement = document.createElement('div');
              commentElement.classList.add('comment');
              commentElement.innerHTML = `
            <div class="d-flex flex-start mb-4 overflow-y-auto">
              <img class="rounded-circle shadow-1-strong me-3" src="${comment.avatar}" alt="avatar" width="32" height="32" />

                  <div class="">
                    <p class="mb-0"><b style="margin-right: 5px;">@${comment.username}</b> ${comment.text}</p>
                  
                    <p style="font-size: 0.7rem">${comment.datetime}</p>
                    <!--
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex align-items-center">
                        <a href="#!" class="link-muted me-2"><i class="fas fa-thumbs-up me-1"></i>132</a>
                        <a href="#!" class="link-muted"><i class="fas fa-thumbs-down me-1"></i>15</a>
                      </div>
                      <a href="#!" class="link-muted"><i class="fas fa-reply me-1"></i> Reply</a>
                    </div>
                    -->
                  </div>

            </div>
          `;
              commentContainer.appendChild(commentElement);
            });
          });
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