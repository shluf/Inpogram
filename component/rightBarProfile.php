<?php


include "database.php";

$username = $_SESSION['username']; 

$queryFollowingList = "SELECT FollowedUsername FROM FOLLOWS WHERE FollowerUsername = ?";
$stmtFollowingList = $conn->prepare($queryFollowingList);
$stmtFollowingList->bind_param('s', $username);
$stmtFollowingList->execute();
$resultFollowingList = $stmtFollowingList->get_result();

$followingArray = [];
while ($following = $resultFollowingList->fetch_assoc()) {
    $followingArray[] = $following['FollowedUsername'];
}

?>

<aside>
    <div class="aside-container">
        <h1 class="profile-title">Profile</h1>

        <!-- Display Profile Card -->
        <div id="display-profile-card" class="card profile-card" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="<?= htmlspecialchars($userInfo['PhotoProfile']) ?>" alt="Profile Image" class="img-fluid" style="width: 180px; height: 180px; border-radius: 10px;">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1"><?= htmlspecialchars($fullname) ?></h5>
                        <p class="mb-2 pb-1"><small>@<?= htmlspecialchars($username) ?></small></p>
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
                            <button type="button" class="btn btn-outline-primary me-1 flex-grow-1" onclick="toggleEditProfile()">Edit</button>
                        </div>
                    </div>
                </div>
                <p class="mb-2 mt-4">Bio</p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2 mt-2 bg-body-tertiary">
                    <p><?= htmlspecialchars($userInfo['Bio']) ?></p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Card -->
        <div id="edit-profile-card" class="card profile-card" style="border-radius: 15px; display: none;">
            <div class="card-body p-4">
                <form method="post" action="profile.php" enctype="multipart/form-data">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="dropzone-profile" id="dropzone">
                                <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon-profile" id="upload-icon" />
                                <input type="file" class="upload-input-profile form-control" name="profilePhoto" onchange="previewFile()">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><input type="text" name="fullname" placeholder="<?= htmlspecialchars($fullname) ?>" class="form-control"></h5>
                            <p class="mb-2 pb-1"><small>@<?= htmlspecialchars($username) ?></small></p>
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
                        <textarea name="bio" class="form-control bg-body-tertiary"><?= htmlspecialchars($userInfo['Bio']) ?></textarea>
                </form>
            </div>
        </div>

        <section class="connection">
            <h3 class="followers-tab">Followers</h3>
            <div class="connection-item">
                <div class="list-group">
                    <?php while ($follower = $resultFollowerList->fetch_assoc()): ?>
                        <form method="post" action="">
                            <input type="hidden" name="followedUser" value="<?= htmlspecialchars($follower['Username']) ?>">
                            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($follower['NAME']) ?></h6>
                                        <p class="mb-0 opacity-75">@<?= htmlspecialchars($follower['Username']) ?></p>
                                    </div>
                                    <?php if (in_array($follower['Username'], $followingArray)): ?>
                                        <button type="submit" name="unfollow" class="btn btn-outline-primary">Unfollow</button>
                                    <?php else: ?>
                                        <button type="submit" name="follow" class="btn btn-primary">Follback</button>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </form>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
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

    reader.addEventListener("load", function () {
        preview.src = reader.result;
        document.getElementById('dropzone').appendChild(preview);
        document.getElementById('upload-icon').style.display = 'none';
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>