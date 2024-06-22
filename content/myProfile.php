<?php

include "database.php";

$username = $_SESSION['username'];

$sql = "SELECT Image, DESCRIPTION FROM Posts WHERE Username = ?";
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

<div class="container">
    <div class="tz-gallery">
        <div class="row">

            <?php

            $count = 0;

            foreach ($posts as $post) {
                $count++;
                if ($count >= 3) {
                    $count = 0;
                    echo '<div class="col-md-12">';
                } else {
                    echo '<div class="col-md-6">';
                }
                echo '<a class="lightbox" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                    <img src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                    </a>
                    </div>';
            }

            ?>

            <p class="text-center mt-4" style="color: #999;">Ditemukan <?= count($posts) ?> post</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>