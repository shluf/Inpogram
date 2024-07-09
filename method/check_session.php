<?php
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    $current_page = basename($_SERVER['PHP_SELF']);
?>