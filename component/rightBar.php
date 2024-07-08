<?php 
include "method/follow.php";
?>

  <section class="d-none d-md-flex main-profile p-3 rounded">
    <div class="profile-info">
      <p class="main-profile-name"><?= $_SESSION["fullname"] ?></p>
      <p class="main-profile-username"><small>@<?= $_SESSION["username"] ?></small></p>
    </div>
    <img src="<?= $_SESSION['profilepict'] ?>" class="rounded-circle" style="width: 54px; height: 54px; object-fit: cover;" >
  </section>
  
  <div class="aside-container">
    <section class="connection">
      <h3>Koneksi</h3>
      <div class="connection-item">
        <div class="list-group">
          <?php

          include "database.php";

          $username = $_SESSION["username"];
          $sql = "
            SELECT Username, NAME, Bio, PhotoProfile 
            FROM Users 
            WHERE Username != '$username' 
              AND Username NOT IN (
                SELECT FollowedUsername 
                FROM FOLLOWS 
                WHERE FollowerUsername = '$username'
              )
            LIMIT 2;
          ";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $followed = false;
              $followedText = "Follow";

              $checkFollowSql = "SELECT * FROM FOLLOWS WHERE FollowerUsername = '$username' AND FollowedUsername = '" . $row["Username"] . "'";
              $checkFollowResult = $conn->query($checkFollowSql);
              if ($checkFollowResult->num_rows > 0) {
                $followed = true;
                $followedText = "Followed";
              }
              echo '
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                  <img src="'. $row["PhotoProfile"] .'" alt=" " width="32" height="32"
                    class="rounded-circle flex-shrink-0">
                  <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                      <h6 class="mb-0">' . $row["NAME"] . '</h6>
                      <p class="mb-0 opacity-75">' . $row["Bio"] . '</p>
                    </div>
                    <form method="post">
                      <input type="hidden" name="username_to_follow" value="' . $row["Username"] . '">
                      <input type="hidden" name="refresh" value="false">
                      <button type="submit" name="follow" class="btn btn-primary">' . $followedText . '</button>
                    </form>
                  </div>
                </a>
              ';
            }
          } else {
            echo '<p class="text-center mt-4" style="color: #999;">Kamu telah mengikuti semua orang.</p>';
          }
          ?>
        </div>
      </div>
    </section>

    <section class="notification">
      <h3>Notifikasi</h3>
      <div class="list-group">
        <?php

        $sql = "
          SELECT NotificationID, Message, DATETIME 
          FROM Notifications 
          WHERE Username = '$username' 
          ORDER BY DATETIME DESC 
          LIMIT 3;
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '
              <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <i class="bi bi-bell" width="32" height="32"></i>
                  
                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                  <div>
                    <div class="notification-header">
                    <h6 class="mb-0">Ada inpo</h6>
                    <small class="opacity-50 text-nowrap">' . date("H:i, d F", strtotime($row["DATETIME"])) . '</small>
                    </div>
                    <p class="mb-0 opacity-75">' . $row["Message"] . '</p>
                  </div>
                  <form method="post" action="method/delete_notification.php">
                    <input type="hidden" name="notification_id" value="' . $row["NotificationID"] . '">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Delete</button>
                  </form>
                </div>
              </div>
            ';
          }
        } else {
          echo '<p class="text-center mt-4" style="color: #999;">Tidak ada notifikasi terbaru.</p>';
        }

        $conn->close();
        ?>
      </div>
    </section>
  </div>
