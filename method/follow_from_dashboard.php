<?php
session_start();

include "../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $username_to_follow = $_POST["username_to_follow"];
  
    $sql = "INSERT INTO FOLLOWS (FollowerUsername, FollowedUsername) VALUES ('$username', '$username_to_follow')";
    if ($conn->query($sql) === TRUE) {
      header("Location: ../dashboard.php"); 
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

?>