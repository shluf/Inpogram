<?php

include "database.php";

$username = $_SESSION['username'];

$sql = "SELECT * FROM Posts WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
?>

<?php include "component/modalPost.php"; ?>

<div class="container">
    <div class="tz-gallery">
        <div class="row">

            <?php

            $count = 0;

            foreach ($posts as $post) {
                $count++;
                if ($count >= 3) {
                    $count = 0;
                    echo '<div class="col-md-12" data-bs-toggle="modal" data-bs-target="#commentsModal" onclick="loadComments(\'' . htmlspecialchars($post["PostID"], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Image'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Username'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '\')">';
                } else {
                    echo '<div class="col-md-6" data-bs-toggle="modal" data-bs-target="#commentsModal" onclick="loadComments(\'' . htmlspecialchars($post["PostID"], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Image'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Username'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '\')">';
                }
                echo '<img style="width: 100%; border-radius: 5px;" src="' . $post['Image'] . '" alt="' . $post['DESCRIPTION'] . '">
                    </div>';
            }

            ?>

            <p class="text-center mt-4" style="color: #999;">Ditemukan <?= count($posts) ?> post</p>
        </div>
    </div>

    <script src="js/loadComments.js"></script>