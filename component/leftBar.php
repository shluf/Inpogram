<?php
$header = $_SERVER['REQUEST_URI'];
?>

<navbar class="d-none d-md-flex d-lg-flex d-xl-flex">
  <div class="d-flex flex-column flex-shrink-0 justify-content-between bg-body-tertiary rounded nav-container border" style="width: 4.5rem;">
    <div></div>
    <div>
      <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link <?= $header == "/Inpogram/dashboard.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
            <i class="bi bi-house"></i>
          </a>
        </li>
        <li>
          <a href="explore.php" class="nav-link <?= $header == "/Inpogram/explore.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Dashboard" data-bs-original-title="Dashboard">
            <i class="bi bi-compass"></i>
          </a>
        </li>
        <li>
          <a href="upload.php" class="nav-link <?= $header == "/Inpogram/upload.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Chat" data-bs-original-title="Chat">
            <i class="bi bi-upload"></i>
          </a>
        </li>
        <li>
          <a href="profile.php" class="nav-link <?= $header == "/Inpogram/profile.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Upload" data-bs-original-title="Upload">
            <i class="bi bi-person"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="dropdown border-top">
      <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-list"></i>
      </a>
      <ul class="dropdown-menu text-small shadow">
        <!-- <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li> -->
        <li>
          <form action="method/logout.php" method="POST">
            <button class="dropdown-item" type="submit" name="logout">Sign out</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</navbar>

<!-- Bottom Navbar -->
<nav class="navbar bg-body-tertiary bg-info navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none">
  <ul class="navbar-nav nav-justified w-100">
    <li class="nav-item">
      <a href="dashboard.php" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
          <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="explore.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rm" height="1.5em" fill="currentColor" class="bi bi-compass" viewBox="0 0 16 16">
          <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016m6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0" />
          <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="upload.php" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
          <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="profile.php" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
        </svg>
      </a>
    </li>
  </ul>
</nav>