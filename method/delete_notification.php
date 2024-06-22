<?php
session_start();

include "../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $notification_id = $_POST["notification_id"];

  $sql = "DELETE FROM Notifications WHERE NotificationID = '$notification_id'";
  if ($conn->query($sql) === TRUE) {
    header("Location: ../dashboard.php"); 
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
