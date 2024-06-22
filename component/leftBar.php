<?php 
  $header = $_SERVER['REQUEST_URI'];
?>

<navbar>
    <div class="d-flex flex-column flex-shrink-0 justify-content-between bg-body-tertiary rounded nav-container border"
      style="width: 4.5rem;">
      <div></div>
      <div>
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $header == "/Inpogram/dashboard.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" aria-current="page"
              data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
              <i class="bi bi-house"></i>
            </a>
          </li>
          <li>
            <a href="explore.php" class="nav-link <?= $header == "/Inpogram/explore.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip"
              data-bs-placement="right" aria-label="Dashboard" data-bs-original-title="Dashboard">
              <i class="bi bi-compass"></i>
            </a>
          </li>
          <li>
            <a href="upload.php" class="nav-link <?= $header == "/Inpogram/upload.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip"
              data-bs-placement="right" aria-label="Chat" data-bs-original-title="Chat">
              <i class="bi bi-upload"></i>
            </a>
          </li>
          <li>
            <a href="profile.php" class="nav-link <?= $header == "/Inpogram/profile.php" ? "active" : "" ?> py-3 m-2 border-bottom rounded-circle" data-bs-toggle="tooltip"
              data-bs-placement="right" aria-label="Upload" data-bs-original-title="Upload">
              <i class="bi bi-person"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="dropdown border-top">
        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none"
          data-bs-toggle="dropdown" aria-expanded="false">
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

