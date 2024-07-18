<?php


include "database.php";

include "method/followed_username.php";
include "method/followed_list.php";
include "method/unfollow.php";
include "method/follow.php";

$username = $_SESSION['username'];

?>

<div class="modal fade" id="followModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <section class="connection">

                    <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-followers-tab" data-bs-toggle="pill" data-bs-target="#pills-followers" type="button" role="tab" aria-controls="pills-followers" aria-selected="true">Followers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-followed-tab" data-bs-toggle="pill" data-bs-target="#pills-followed" type="button" role="tab" aria-controls="pills-followed" aria-selected="false">Followed</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
<button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
</li> -->
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">

                            <div class="connection-item">
                                <div class="list-group" style="height: 214px; overflow-y: auto;">
                                    <?php while ($follower = $resultFollowerList->fetch_assoc()) : ?>
                                        <form method="post" action="">
                                            <input type="hidden" name="followedUser" value="<?= $follower['Username'] ?>">
                                            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="<?= $follower['PhotoProfile'] ?>" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0"><?= $follower['NAME'] ?></h6>
                                                        <p class="mb-0 opacity-75">@<?= $follower['Username'] ?></p>
                                                    </div>
                                                    <!-- <form method="post"> -->
                                                    <?= (in_array($follower['Username'], $followingArray)) ?
                                                        '<form method="post">
                            <input type="hidden" name="username_to_unfollow" value="' . $follower["Username"] . '">
                            <button type="submit" name="unfollow" class="btn btn-outline-primary">Unfollow</button>
                            </form>'
                                                        :
                                                        '<form method="post">
                            <input type="hidden" name="refresh" value="true">
                            <input type="hidden" name="username_to_follow" value="' . $follower["Username"] . '">
                            <button type="submit" name="follow" class="btn btn-primary">Follback</button>
                            </form>'
                                                    ?>
                                                    <!-- </form> -->
                                                </div>
                                            </a>
                                        </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-followed" role="tabpanel" aria-labelledby="pills-followed-tab" tabindex="0">

                            <div class="connection-item">
                                <div class="list-group" style="height: 214px; overflow-y: auto;">
                                    <?php while ($followed = $resultFollowedList->fetch_assoc()) : ?>
                                        <form method="post" action="">
                                            <input type="hidden" name="username_to_unfollow" value="<?= $followed['Username'] ?>">
                                            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="<?= $followed['PhotoProfile'] ?>" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0"><?= $followed['NAME'] ?></h6>
                                                        <p class="mb-0 opacity-75">@<?= $followed['Username'] ?></p>
                                                    </div>
                                                    <button type="submit" name="unfollow" class="btn btn-outline-primary">Unfollow</button>
                                                </div>
                                            </a>
                                        </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">...</div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<aside>
    <div>
        <h1 class="profile-title">My Profile</h1>

        <!-- Display Profile Card -->
        <div id="display-profile-card" class="card profile-card" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex flex-xl-row flex-column justify-content-center align-items-center">
                    <div class="flex-shrink-0">
                        <img src="<?= $userInfo['PhotoProfile'] ?>" alt="" class="img-fluid" style="width: 180px; height: 180px; border-radius: 10px;">
                    </div>
                    <div class="flex-grow-1 ms-3 mt-3">
                        <h5 class="mb-1"> <?= $fullname ?> </h5>
                        <p class="mb-2 pb-1"><small>@<?= $username ?></small></p>
                        <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary" data-bs-toggle="modal" data-bs-target="#followModal" style="cursor: pointer;">
                            <div>
                                <p class="small text-muted mb-1">Post</p>
                                <p class="mb-0"><?= $postCount ?></p>
                            </div>
                            <div class="px-3">
                                <p class="small text-muted mb-1">Followers</p>
                                <p class="mb-0"><?= $followerCount ?></p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Following</p>
                                <p class="mb-0"><?= $followingCount ?></p>
                            </div>
                        </div>
                        <div class="d-flex pt-1">
                            <button type="button" class="btn btn-outline-primary me-1 flex-grow-1" onclick="toggleEditProfile()">Edit</button>
                        </div>
                    </div>
                </div>
                <p class="mb-2 mt-4">Bio</p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2 mt-2 bg-body-tertiary">
                    <p><?= $userInfo['Bio'] ?></p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Card -->
        <div id="edit-profile-card" class="card profile-card" style="border-radius: 15px; display: none;">
            <div class="card-body p-4">
                <form method="post" action="profile.php" enctype="multipart/form-data">
                    <div class="d-flex flex-xl-row flex-column justify-content-center align-items-center">
                        <div class="flex-shrink-0">
                            <div class="dropzone-profile" id="dropzone">
                                <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon-profile" id="upload-icon" />
                                <input type="file" class="upload-input-profile form-control" name="profilePhoto" onchange="previewFile()">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3 mt-3">
                            <h5 class="mb-1"><input type="text" name="fullname" placeholder="<?= $fullname ?>" class="form-control"></h5>
                            <p class="mb-2 pb-1"><small>@<?= $username ?></small></p>
                            <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                                <div>
                                    <p class="small text-muted mb-1">Post</p>
                                    <p class="mb-0"><?= $postCount ?></p>
                                </div>
                                <div class="px-3">
                                    <p class="small text-muted mb-1">Followers</p>
                                    <p class="mb-0"><?= $followerCount ?></p>
                                </div>
                                <div>
                                    <p class="small text-muted mb-1">Following</p>
                                    <p class="mb-0"><?= $followingCount ?></p>
                                </div>
                            </div>
                            <div class="d-flex pt-1">
                                <button type="submit" name="saveProfile" class="btn btn-primary me-1 flex-grow-1">Save</button>
                                <button type="button" class="btn btn-secondary me-1 flex-grow-1" onclick="toggleEditProfile()">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <p class="mb-2 mt-4">Bio</p>
                    <textarea name="bio" class="form-control bg-body-tertiary"><?= $userInfo['Bio'] ?></textarea>
                </form>
            </div>
        </div>


    </div>
</aside>


<script>
    function toggleEditProfile() {
        const displayProfileCard = document.getElementById('display-profile-card');
        const editProfileCard = document.getElementById('edit-profile-card');
        if (displayProfileCard.style.display === 'none') {
            displayProfileCard.style.display = 'block';
            editProfileCard.style.display = 'none';
        } else {
            displayProfileCard.style.display = 'none';
            editProfileCard.style.display = 'block';
        }
    }

    function previewFile() {
        const preview = document.createElement('img');
        preview.className = 'img-fluid img-preview';
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.src = reader.result;
            document.getElementById('dropzone').appendChild(preview);
            document.getElementById('upload-icon').style.display = 'none';
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>