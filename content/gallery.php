<?php

include "database.php";

include "method/followed.php";
include "method/follow.php";
include "method/unfollow.php";

$username = $_SESSION['username'];

$sql = "SELECT Username, Image, DESCRIPTION FROM Posts";
$result = $conn->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$postUser = [];
$userResult = [];

$searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : null;


if (!empty($searchQuery)) {
    $querySearch = "SELECT Username, NAME, Bio, PhotoProfile
                    FROM Users
                    WHERE Username LIKE ? OR NAME LIKE ?;";
    $stmtSearch = $conn->prepare($querySearch);
    $searchTerm = '%' . $searchQuery . '%';
    $stmtSearch->bind_param('ss', $searchTerm, $searchTerm);
    $stmtSearch->execute();
    $resultSearch = $stmtSearch->get_result();

    if ($resultSearch->num_rows > 0) {
        $posts = [];
        while ($row = $resultSearch->fetch_assoc()) {
            $userResult[] = $row;
        }
    } else {
        $postsUser[0] = "empty";
        $userResult[0] = "empty";
    }


    $querySearch = "SELECT Posts.*, Users.Username
                    FROM Posts 
                    JOIN Users ON Posts.Username = Users.Username 
                    WHERE Users.Username LIKE ? OR Users.Name LIKE ? OR Posts.DESCRIPTION LIKE ?";
    $stmtSearch = $conn->prepare($querySearch);
    $searchTerm = '%' . $searchQuery . '%';
    $stmtSearch->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $stmtSearch->execute();
    $resultSearch = $stmtSearch->get_result();

    if ($resultSearch->num_rows > 0) {
        $posts = [];
        while ($row = $resultSearch->fetch_assoc()) {
            $postsUser[] = $row;
        }
    } else {
        $postsUser[0] = "empty";
    }
    
} else {
    $postsUser[0] = "empty";
    $userResult[0] = "empty";
}

if ($postsUser[0] != "empty") {
    $countPost = count($postsUser);
} else {
    $countPost = count($posts);
}

?>


<div class="container gallery-container">


    <h1 class="feed-title">Explore</h1>
    <p class="page-description text-center">Ditemukan <?= $countPost ?> post</p>

    <div class="tz-gallery d-flex flex-column align-items-center">

        <div class="mb-5">
            <div class="input-group search-bar d-flex justify-content-center">
                <span class="input-group-text search-bar-icon" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#c2506e" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 
                      1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                        </path>
                    </svg>
                </span>
                <form id="searchForm" method="GET" action="">
                    <input type="text" class="form-control" name="search_query" placeholder="Mencari sesuatu?" aria-label="Input group example" aria-describedby="basic-addon1">
                </form>
            </div>
        </div>



        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4 w-100">
            <?php
            if ($userResult[0] != "empty") {
                foreach ($userResult as $user) {
                    echo '<div class="container mb-3">
                        <div class="col">
                            <div class="card radius-15">
                                <div class="card-body text-center">
                                    <div class="p-4 border radius-15">
                                        <img src="' . htmlspecialchars($user['PhotoProfile'], ENT_QUOTES) . '" width="110" height="110" class="rounded-circle shadow" alt="">
                                        <h5 class="mb-0 mt-5">' . htmlspecialchars($user['NAME'], ENT_QUOTES) . '</h5>
                                        <p class="mb-3">' . htmlspecialchars($user['Username'], ENT_QUOTES) . '</p>
                                        <div class="list-inline contacts-social mt-3 mb-3"> <a href="javascript:;" class="list-inline-item bg-facebook text-white border-0"><i class="bx bxl-facebook"></i></a>
                                            <a href="javascript:;" class="list-inline-item bg-twitter text-white border-0"><i class="bx bxl-twitter"></i></a>
                                            <a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0"><i class="bx bxl-linkedin"></i></a>
                                        </div>
                                       
          
                                        ' .

                        ((in_array($user['Username'], $followingArray)) ?
                            '<form method="post">
                                            <input type="hidden" name="username_to_unfollow" value="' . $user["Username"] . '">
                                            <button type="submit" name="unfollow" class="btn btn-outline-primary">Unfollow</button>
                                            </form>'
                            :
                            '<form method="post">
                                            <input type="hidden" name="refresh" value="true">
                                            <input type="hidden" name="username_to_follow" value="' . $user["Username"] . '">
                                            <button type="submit" name="follow" class="btn btn-primary">Follow</button>
                                            </form>')

                        . '

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                }
            }
            ?>
        </div>

        <div class="row w-100">


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

            $countSearch = 0;

            if ($postsUser[0] != "empty") {
                foreach ($postsUser as $post) {
                    $countSearch++;

                    switch ($countSearch) {
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
                            $countSearch = 0;
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
            }

            ?>

        </div>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>