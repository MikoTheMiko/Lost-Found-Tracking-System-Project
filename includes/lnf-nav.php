<?php $page = basename($_SERVER['PHP_SELF']); ?>

<nav class="col-md-3 col-lg-2 d-md-block bg-light p-3 border shadow-sm position-sticky top-0 vh-100">
    <p class="navbar-brand fs-5 ps-1">Menu</p>
    <hr>

    <ul class="nav flex-column fs-6 nav-pills mt-2">

        <li class="nav-item">
            <a class="nav-link <?= ($page == 'index.php') ? 'active' : '' ?>" href="index.php">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($page == 'lnf-itemdisplay.php') ? 'active' : '' ?>" href="includes/lnf-itemdisplay.php">
                Lost Items
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($page == 'lnf-form.php') ? 'active' : '' ?>" href="includes/lnf-form.php">
                Report an Item
            </a>
        </li>

        <!--
        <li class="nav-item">
            <a class="nav-link <?= ($page == 'about.php') ? 'active' : '' ?>" href="about.php">
                About Us
            </a>
        </li>

-->

    </ul>
</nav>