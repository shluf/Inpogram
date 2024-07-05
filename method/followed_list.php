<?php
include "database.php";

$username = $_SESSION['username'];

$query = "SELECT Users.Username, Users.NAME, Users.PhotoProfile
          FROM Users
          JOIN FOLLOWS ON Users.Username = FOLLOWS.FollowedUsername
          WHERE FOLLOWS.FollowerUsername = '$username'";

$resultFollowedList = $conn->query($query);
?>
