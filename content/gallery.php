<?php

include "database.php";

$username = $_SESSION['username'];

$sql = "SELECT Username, Image, DESCRIPTION FROM Posts";
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
?>


<div class="container gallery-container">
    
    
    <h1 class="feed-title">Explore</h1>
    <p class="page-description text-center">Ditemukan <?= count($posts) ?> post</p>
    
    <div class="tz-gallery d-flex flex-column align-items-center">

        <div class="col-md-4 mb-5">
            <div class="input-group search-bar">
                <span class="input-group-text search-bar-icon" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#c2506e" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 
                      1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                        </path>
                    </svg>
                </span>
                <input type="text" class="form-control" placeholder="Mencari sesuatu?" aria-label="Input group example" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="row">


            <?php

            $count = 0;

            foreach ($posts as $post) {
                $count++;

                switch ($count) {
                    case 1:
                        echo '<div class="col-sm-12 col-md-4">
                            <div style="position: relative;">
                                <a class="lightbox" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>
                        </div>';
                        break;
                    case 2:
                        echo '<div class="col-sm-6 col-md-4 row-1">
                            <div style="position: relative;">
                                <a class="lightbox" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img style="object-fit: cover;" src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>
                        </div>';
                        break;
                    case 3:
                        echo '<div class="col-sm-6 col-md-4">
                            <div style="position: relative;">
                                <a class="lightbox" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>
                        </div>
                    ';
                        break;
                    case 4:
                        echo '<div class="col-sm-12 col-md-8">
                            <div style="position: relative;">
                                <a class="lightbox" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>
                        </div>';
                        break;
                    case 5:
                        echo '<div class="col-sm-12 col-md-4 ">
                            <div style="position: relative;">
                                <a class="lightbox col-sm-6" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img class="w-100 shadow-1-strong rounded mb-1" src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>';
                        break;
                    case 6:
                        $count = 0;
                        echo '<div style="position: relative;">
                            <a class="lightbox col-sm-6" href="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '">
                                <img class="w-100 shadow-1-strong rounded" src="' . htmlspecialchars($post['Image'], ENT_QUOTES) . '" alt="' . htmlspecialchars($post['DESCRIPTION'], ENT_QUOTES) . '">
                                </a>
                                <p class="rounded p-2 mt-2 mb-0 text-center" style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5);">@' . htmlspecialchars($post['Username'], ENT_QUOTES) . '</p>
                            </div>
                        </div>';
                        break;
                }
            }

            ?>

        </div>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>