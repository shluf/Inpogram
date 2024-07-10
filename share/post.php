<?php

include "../database.php";


if (isset($_GET['id'])) {
    $post_id = $_GET['id'];


    if (isset($_SESSION['username'])) {
        $logged_in_user = $_SESSION['username'];

        $sql = "
        SELECT PostID, Username, Image, DESCRIPTION, DATETIME,
        (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID) AS LikeCount, 
        (SELECT COUNT(*) FROM Comments WHERE Comments.PostID = Posts.PostID) AS CommentsCount,
        (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID AND Likes.Username = ?) AS UserLiked
        FROM Posts
        WHERE PostID = ?;
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $logged_in_user, $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "
        SELECT PostID, Username, Image, DESCRIPTION, DATETIME,
        (SELECT COUNT(*) FROM Likes WHERE Likes.PostID = Posts.PostID) AS LikeCount, 
        (SELECT COUNT(*) FROM Comments WHERE Comments.PostID = Posts.PostID) AS CommentsCount
        FROM Posts
        WHERE PostID = ?;
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $row = $result->fetch_assoc();
} else {
    header("Location: ../index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <title>Inpogram</title>
</head>

<body>

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
                    <img class="rounded" src="../<?php echo $row['Image']; ?>" alt="profile">

                    <div id="like" class="d-flex gap-2 w-100 justify-content-start px-md-5 px-2">
                        <div class="btn" onclick="addLike(<?php echo $row['PostID']; ?>)">
                            <span><?php echo $row['LikeCount']; ?></span>
                            <?php
                            if (isset($row['UserLiked'])) {
                                if ($row['UserLiked'] == 0) {
                                    echo '<i id="like-icon-' . $row['PostID'] . '" class="bi bi-heart"></i>';
                                } else {
                                    echo '<i id="like-icon-' . $row['PostID'] . '" class="bi bi-heart-fill" style="color:red;"></i>';
                                }
                            } else {
                                echo '<i id="like-icon-' . $row['PostID'] . '" class="bi bi-heart"></i>';
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>