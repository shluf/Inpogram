<?php

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow'])) {
    $username = $_SESSION["username"];
    $refresh = $_POST["refresh"];
    $username_to_follow = $_POST["username_to_follow"];
  
    $sql = "INSERT INTO FOLLOWS (FollowerUsername, FollowedUsername) VALUES ('$username', '$username_to_follow')";
    if ($conn->query($sql) === TRUE) {
      if ($refresh == "true" ) {
        // header("Location: " . $_SERVER['REQUEST_URI']);
        echo "<script>window.location.href = '" . $_SERVER["HTTP_REFERER"] . "'; </script>";
      }
      
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

?>