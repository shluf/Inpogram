<navbar class="d-none d-md-flex d-lg-flex d-xl-flex">
  <div class="d-flex flex-column flex-shrink-0 justify-content-between bg-body-tertiary rounded nav-container border" style="width: 4.5rem;">
    <div class="nav nav-pills nav-flush flex-column text-center">
      <a href="stream/" class="nav-link  py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-togle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
        <i class="bi bi-camera-reels-fill"></i>
      </a>
    </div>
    <div>
      <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link <?= strpos($current_page, 'dashboard.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
            <i class="bi bi-house"></i>
          </a>
        </li>
        <li>
          <a href="explore.php" class="nav-link <?= strpos($current_page, 'explore.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Dashboard" data-bs-original-title="Dashboard">
            <i class="bi bi-compass"></i>
          </a>
        </li>
        <li>
          <a href="upload.php" class="nav-link <?= strpos($current_page, 'upload.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Chat" data-bs-original-title="Chat">
            <i class="bi bi-upload"></i>
          </a>
        </li>
        <li>
          <a href="profile.php" class="nav-link <?= strpos($current_page, 'profile.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Upload" data-bs-original-title="Upload">
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


        <li class="dropdown">
          <a class="dropdown-item tema-dropdown">
            Tema
          </a>
          <span class="tema-dropdown-content" style="position: absolute; left: 100%; top: -8px; display: none;">
            <div class="rounded mode-selector" style="background-color: white; margin-left: 8px;">
              <a id="lightMode" class="dropdown-item btn rounded"><i class="bi bi-brightness-high-fill"></i> Light </a>
              <a id="darkMode" class="dropdown-item btn rounded"><i class="bi bi-moon-stars-fill"></i> Dark </a>
              <a id="systemMode" class="dropdown-item btn rounded"><i class="bi bi-circle-half"></i> System</a>
            </div>
          </span>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>
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
      <a href="stream/" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-camera-reels" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0M1 3a2 2 0 1 0 4 0 2 2 0 0 0-4 0" />
          <path d="M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm6 8.73V7.27l-3.5 1.555v4.35zM1 8v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1" />
          <path d="M9 6a3 3 0 1 0 0-6 3 3 0 0 0 0 6M7 3a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />

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

<script src="js/toggleDarkLightMode.js"></script>