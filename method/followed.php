<?php
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