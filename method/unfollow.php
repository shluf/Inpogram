<?php

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unfollow'])) {
    $username = $_SESSION["username"];
    $username_to_unfollow = $_POST["username_to_unfollow"];
  
    $sql = "DELETE FROM FOLLOWS WHERE FollowerUsername = '$username' AND FollowedUsername = '$username_to_unfollow'";
    if ($conn->query($sql) === TRUE) {
        // header("Location: " . $_SERVER['REQUEST_URI']);
        echo "<script>window.location.href = '" . $_SERVER["HTTP_REFERER"] . "'; </script>";
        exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

?>