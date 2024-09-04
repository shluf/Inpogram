<navbar class="d-none d-md-flex d-lg-flex d-xl-flex">
  <div class="d-flex flex-column flex-shrink-0 justify-content-between bg-body-tertiary rounded nav-container border" style="width: 4.5rem;">
    <div class="nav nav-pills nav-flush flex-column text-center">
      <a href="../dashboard.php" class="nav-link <?= strpos($current_page, 'dashboard.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
        <i class="bi bi-box-arrow-left"></i>
      </a>
    </div>
    <div>
      <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li class="nav-item">
          <a href="./index.php" class="nav-link <?= strpos($current_page, 'index.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
            <i class="bi bi-door-open"></i>
          </a>
        </li>
        <li class="nav-item">
          <a href="./library.php" class="nav-link <?= strpos($current_page, 'library.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
            <i class="bi bi-film"></i>
          </a>
        </li>
        <li>
          <a href="./room.php" class="disabled nav-link <?= strpos($current_page, 'room.php') !== false ? 'active' : '' ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Dashboard" data-bs-original-title="Dashboard">
            <i class="bi bi-cup-hot"></i>
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
              <!-- <a id="systemMode" class="dropdown-item btn rounded"><i class="bi bi-circle-half"></i> System</a> -->
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
      <a href="../dashboard.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-house-down" viewBox="0 0 16 16">
          <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708z" />
          <path d="M12.5 9a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7m.354 5.854 1.5-1.5a.5.5 0 0 0-.708-.707l-.646.646V10.5a.5.5 0 0 0-1 0v2.793l-.646-.646a.5.5 0 0 0-.708.707l1.5 1.5a.5.5 0 0 0 .708 0" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="./index.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
          <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="./library.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
          <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z" />
        </svg>
      </a>
    </li>
    <li class="nav-item">
      <a href="../profile.php" class="nav-link">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
        </svg>
      </a>
    </li>
  </ul>
</nav>

<script src="../js/toggleDarkLightMode.js"></script>