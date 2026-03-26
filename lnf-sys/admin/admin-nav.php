<?php $page = basename($_SERVER['PHP_SELF']); ?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            Lost & Found <span class="fw-normal">Management</span>
        </a>

        <!-- Sidebar toggle button (hamburger) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Layout Wrapper -->
<div class="container-fluid mt-5 pt-3">
    <div class="row">

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light p-3 border shadow-sm position-fixed top-0 vh-100 mt-5">
            <div class="pt-3">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'pending-reports.php') ? 'active' : '' ?>" href="pending-reports.php">Pending Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'approved-reports.php') ? 'active' : '' ?>" href="approved-reports.php">Approved Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'rejected-reports.php') ? 'active' : '' ?>" href="rejected-reports.php">Rejected Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content start -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <!-- Your page content -->
