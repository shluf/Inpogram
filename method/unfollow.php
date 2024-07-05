<?php

include "database.php";

ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unfollow'])) {
    $username = $_SESSION["username"];
    $username_to_unfollow = $_POST["username_to_unfollow"];
  
    $sql = "DELETE FROM FOLLOWS WHERE FollowerUsername = '$username' AND FollowedUsername = '$username_to_unfollow'";
    if ($conn->query($sql) === TRUE) {
      echo $_SERVER['REQUEST_URI'];
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  ob_end_flush();

?>