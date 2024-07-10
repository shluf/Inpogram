<?php
include "database.php";

$notify = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profileDefault = 'images/profiles/default-profile.png';

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (Username, NAME, Email, Password, PhotoProfile) VALUES
        ('$username', '$fullname', '$email', '$hashed_password', '$profileDefault')";
    try {
        if ($conn->query($sql)) {
            $notify = "| Akun berhasil dibuat";
        } else {
            $notify = "| Gagal membuat akun";
        }
    } catch (mysqli_sql_exception) {
        $notify = "| Masukan data kembali";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="images/icon.png">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/login.css" />
    <title>Inpogram - Register</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-11 mt-60 mx-md-auto">
                <div class="login-box bg-white pl-lg-5 pl-0 ml-3 mr-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-6">
                            <div class="form-wrap bg-white">
                                <h4 class="btm-sep pb-3 mb-4">Register</h4>

                                <form class="form" method="POST" action="register.php">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <span class="zmdi">@</span>
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <span class="zmdi zmdi-account"></span>
                                                <input type="text" placeholder="Fullname" class="form-control" name="fullname" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <span class="zmdi zmdi-email"></span>
                                                <input type="email" placeholder="Email" class="form-control" name="email" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <span class="zmdi zmdi-lock"></span>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                            </div>
                                        </div>
                                        <i class="login-notify"><?= $notify != null ? $notify : "" ?></i>
                                        <div class="col-12 mt-30">
                                            <button type="submit" name="register" id="submit" class="btn btn-lg btn-custom btn-dark btn-block">Sign up
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="login-title content text-center m-4">
                                <div class="border-bottom pt-4 pb-3 mb-3 pb-md-5 mb-md-5">
                                    <h3 class="c-black">Sudah punya akun?</h3>
                                    <a href="index.php" class="btn btn-custom">Gass masuk</a>
                                </div>
                                <h5 class="c-black mb-2 mt-n1">Inpogram</h5>
                                <div class="socials">
                                    <a>Created by <a href="https://github.com/shluf/" target="_blank">Salis Haidar</a> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>