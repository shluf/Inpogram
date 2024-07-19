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

        <div class="distance">
            <section class="distance__section distance__cycling">
                <p><?= $postCount ?> </p>
                <h2>Post</h2>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.1935 16.793C20.8437 19.2739 20.6689 20.5143 19.7717 21.2572C18.8745 22 17.5512 22 14.9046 22H9.09536C6.44881 22 5.12553 22 4.22834 21.2572C3.33115 20.5143 3.15626 19.2739 2.80648 16.793L2.38351 13.793C1.93748 10.6294 1.71447 9.04765 2.66232 8.02383C3.61017 7 5.29758 7 8.67239 7H15.3276C18.7024 7 20.3898 7 21.3377 8.02383C22.0865 8.83268 22.1045 9.98979 21.8592 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M19.5617 7C19.7904 5.69523 18.7863 4.5 17.4617 4.5H6.53788C5.21323 4.5 4.20922 5.69523 4.43784 7" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M17.4999 4.5C17.5283 4.24092 17.5425 4.11135 17.5427 4.00435C17.545 2.98072 16.7739 2.12064 15.7561 2.01142C15.6497 2 15.5194 2 15.2588 2H8.74099C8.48035 2 8.35002 2 8.24362 2.01142C7.22584 2.12064 6.45481 2.98072 6.45704 4.00434C6.45727 4.11135 6.47146 4.2409 6.49983 4.5" stroke="#1C274C" stroke-width="1.5" />
                    <circle cx="16.5" cy="11.5" r="1.5" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M19.9999 20L17.1157 17.8514C16.1856 17.1586 14.8004 17.0896 13.7766 17.6851L13.5098 17.8403C12.7984 18.2542 11.8304 18.1848 11.2156 17.6758L7.37738 14.4989C6.6113 13.8648 5.38245 13.8309 4.5671 14.4214L3.24316 15.3803" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                </svg>

            </section>
            <section class="distance__section distance__running">
                <p>22 </p>
                <h2>Videos</h2>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.5617 7C19.7904 5.69523 18.7863 4.5 17.4617 4.5H6.53788C5.21323 4.5 4.20922 5.69523 4.43784 7" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M17.4999 4.5C17.5283 4.24092 17.5425 4.11135 17.5427 4.00435C17.545 2.98072 16.7739 2.12064 15.7561 2.01142C15.6497 2 15.5194 2 15.2588 2H8.74099C8.48035 2 8.35002 2 8.24362 2.01142C7.22584 2.12064 6.45481 2.98072 6.45704 4.00434C6.45727 4.11135 6.47146 4.2409 6.49983 4.5" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M21.1935 16.793C20.8437 19.2739 20.6689 20.5143 19.7717 21.2572C18.8745 22 17.5512 22 14.9046 22H9.09536C6.44881 22 5.12553 22 4.22834 21.2572C3.33115 20.5143 3.15626 19.2739 2.80648 16.793L2.38351 13.793C1.93748 10.6294 1.71447 9.04765 2.66232 8.02383C3.61017 7 5.29758 7 8.67239 7H15.3276C18.7024 7 20.3898 7 21.3377 8.02383C22.0865 8.83268 22.1045 9.98979 21.8592 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M14.5812 13.6159C15.1396 13.9621 15.1396 14.8582 14.5812 15.2044L11.2096 17.2945C10.6669 17.6309 10 17.1931 10 16.5003L10 12.32C10 11.6273 10.6669 11.1894 11.2096 11.5258L14.5812 13.6159Z" stroke="#1C274C" stroke-width="1.5" />
                </svg>

            </section>
            <section class="distance__section distance__swimming">
                <p>10 </p>
                <h2>Music</h2>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 17C12 17.8284 11.3284 18.5 10.5 18.5C9.67157 18.5 9 17.8284 9 17C9 16.1716 9.67157 15.5 10.5 15.5C11.3284 15.5 12 16.1716 12 17ZM12 17V10.5C12 12.1569 13.8954 13.5 15 13.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19.5617 7C19.7904 5.69523 18.7863 4.5 17.4617 4.5H6.53788C5.21323 4.5 4.20922 5.69523 4.43784 7" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M17.4999 4.5C17.5283 4.24092 17.5425 4.11135 17.5427 4.00435C17.545 2.98072 16.7739 2.12064 15.7561 2.01142C15.6497 2 15.5194 2 15.2588 2H8.74099C8.48035 2 8.35002 2 8.24362 2.01142C7.22584 2.12064 6.45481 2.98072 6.45704 4.00434C6.45727 4.11135 6.47146 4.2409 6.49983 4.5" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M21.1935 16.793C20.8437 19.2739 20.6689 20.5143 19.7717 21.2572C18.8745 22 17.5512 22 14.9046 22H9.09536C6.44881 22 5.12553 22 4.22834 21.2572C3.33115 20.5143 3.15626 19.2739 2.80648 16.793L2.38351 13.793C1.93748 10.6294 1.71447 9.04765 2.66232 8.02383C3.61017 7 5.29758 7 8.67239 7H15.3276C18.7024 7 20.3898 7 21.3377 8.02383C22.0865 8.83268 22.1045 9.98979 21.8592 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                </svg>

            </section>
            <section class="distance__section distance__swimming">
                <p>10 </p>
                <h2>Text</h2>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.8978 16H7.89778C6.96781 16 6.50282 16 6.12132 16.1022C5.08604 16.3796 4.2774 17.1883 4 18.2235" stroke="#1C274D" stroke-width="1.5" />
                    <path d="M8 7H16" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M8 10.5H13" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M13 16V19.5309C13 19.8065 13 19.9443 12.9051 20C12.8103 20.0557 12.6806 19.9941 12.4211 19.8708L11.1789 19.2808C11.0911 19.2391 11.0472 19.2182 11 19.2182C10.9528 19.2182 10.9089 19.2391 10.8211 19.2808L9.57889 19.8708C9.31943 19.9941 9.18971 20.0557 9.09485 20C9 19.9443 9 19.8065 9 19.5309V16.45" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M10 22C7.17157 22 5.75736 22 4.87868 21.1213C4 20.2426 4 18.8284 4 16V8C4 5.17157 4 3.75736 4.87868 2.87868C5.75736 2 7.17157 2 10 2H14C16.8284 2 18.2426 2 19.1213 2.87868C20 3.75736 20 5.17157 20 8M14 22C16.8284 22 18.2426 22 19.1213 21.1213C20 20.2426 20 18.8284 20 16V12" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                </svg>

            </section>
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