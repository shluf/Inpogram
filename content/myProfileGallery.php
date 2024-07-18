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

<div class="container main-app">
    <div class="tz-gallery">
        <div class="row">

            <?php

            $count = 0;

            foreach ($posts as $post) {
                $count++;
                if ($count >= 3) {
                    $count = 0;
                    echo '<div class="col-md-12 position-relative" onmouseover="this.querySelector(\'button\').style.display=\'block\'" onmouseout="this.querySelector(\'button\').style.display=\'none\'">';
                } else {
                    echo '<div class="col-md-6 position-relative" onmouseover="this.querySelector(\'button\').style.display=\'block\'" onmouseout="this.querySelector(\'button\').style.display=\'none\'">';
                }
                echo '<button class="delete-post position-absolute btn btn-danger" data-postid="' . htmlspecialchars($post["PostID"], ENT_QUOTES) . '" style="z-index: 25; display: none; top: 10px; right: 10px;"><i class="bi bi-trash-fill"></i></button>
                        <img data-bs-toggle="modal" data-bs-target="#commentsModal" 
                            style="width: 100%; border-radius: 5px;" 
                            src="' . $post['Image'] . '" alt="' . $post['DESCRIPTION'] . '" 
                            onclick="loadComments(\'' . htmlspecialchars($post["PostID"], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Image'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['Username'], ENT_QUOTES) . '\', \'' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '\')">
                    </div>';
            }

            ?>

            <p class="text-center mt-4" style="color: #999;">Ditemukan <?= count($posts) ?> post</p>
        </div>
    </div>

    <script src="js/loadComments.js"></script>
    <script>
        document.querySelectorAll('.delete-post').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus postingan ini?')) {
                    const postID = this.getAttribute('data-postid');
                    fetch('method/deletePost.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                postID: postID
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Gagal menghapus postingan.');
                            }
                        });
                }
            });
        });
    </script>