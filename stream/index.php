<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
$logged_in_user = $_SESSION['username'];

include "../database.php";

function generateRoomCode()
{
    return strtoupper(substr(md5(uniqid(rand(), true)), 0, 4)) . '-' .
        strtoupper(substr(md5(uniqid(rand(), true)), 0, 4)) . '-' .
        strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomCode = generateRoomCode();
    $roomName = $_POST['roomName'];
    $descriptions = $_POST['descriptions'];
    $videoID = $_POST['videoID'];

    $sql = "INSERT INTO Rooms (RoomCode, Admin, RoomName, Descriptions, VideoID, Datetime) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $roomCode, $logged_in_user, $roomName, $descriptions, $videoID);

    if ($stmt->execute()) {
        // echo "Room created successfully with code: " . $roomCode;
        exit();
    } else {
        // echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/stream.css" />
    <title>Inpogram - Stream</title>
</head>

<body>
    <?php include("../component/leftBarStream.php") ?>
    <main>
        <h1 class="feed-title">Stream</h1>
        <div class="d-flex justify-content-around">
            
        <?php

        $stmt = $conn->prepare("SELECT * FROM Rooms");
        $stmt->execute();
        $rooms = $stmt->get_result();

        while ($row = $rooms->fetch_assoc()) {
            echo '<div class="rounded shadow-sm p-3" style="min-width: 300px; background-color: white;">';
            echo '<h3> ' . htmlspecialchars($row['RoomName'], ENT_QUOTES, 'UTF-8') . '</h3>';
            echo '<p> ' . htmlspecialchars($row['Descriptions'], ENT_QUOTES, 'UTF-8') . '</p>';
            if ($row['LiveNow']) {
                echo '<p>Sedang Tayang</p>';
            }
            echo '<a class="btn" href="room.php?id=' . htmlspecialchars($row['RoomCode'], ENT_QUOTES, 'UTF-8') . '">Join</a>';
            echo '</div>';
        }
        
        ?>

</div>
<hr>

        <form action="<?php echo $current_page; ?>" method="post" enctype="multipart/form-data">
            <label for="roomName">Nama Ruangan:</label>
            <input type="text" id="roomName" name="roomName" required><br><br>

            <label for="descriptions">Deskripsi:</label>
            <textarea id="descriptions" name="descriptions" required></textarea><br><br>

            <label for="videoID">Pilih Video:</label>
            <select name="videoID" id="videoID" required>
                <?php
                    $stmt = $conn->prepare("SELECT * FROM Videos");
                    $stmt->execute();
                    $videos = $stmt->get_result();
                    foreach ($videos as $video) {
                        echo '<option value="' . htmlspecialchars($video['VideoID']) . '">' . htmlspecialchars($video['Title']) . '</option>';
                    }
                ?>
            </select><br><br>

            <button type="submit">Create Room</button>
        </form>
    </main>

</body>

</html>