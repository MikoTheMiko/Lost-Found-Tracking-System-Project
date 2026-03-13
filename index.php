<?php
date_default_timezone_set('Asia/Manila');
require_once "includes/db_connection.php";
require_once "includes/helper.php";
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>New Document</title>
    <base href="../lnf-sys/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php
            require_once "includes/lnf-nav.php";
            ?>

            <main class="col-md-9 col-lg-10 p-4 mt-2">
                <h2 class="mt-4 text-dark">Welcome to Findly</h2>
                <p class="text-muted fs-5">Track, report and recover lost items in OLLC easily!</p>

                <div class="direct-buttons d-flex gap-5 align-items-start mb-4">

                    <div class="mt-2">
                        <a class="btn btn-primary btn-sm rounded-2 me-1 ps-3 px-3" href="includes/lnf-itemdisplay.php">
                            See Lost Items
                            <i class="bi bi-arrow-bar-right"></i>
                        </a>

                        <a class="btn btn-outline-secondary btn-sm rounded-2 ps-3 px-3" href="includes/lnf-form.php">
                            Report an Item
                            <i class="bi bi-plus"></i>
                        </a>

                        <div class="text-muted small mt-2">
                            Found something? Help others by reporting it.
                        </div>
                    </div>
                </div>
                <hr>

                <div class="recent-lost-label row col-md-9 col-lg-10">

                    <div class="col-4">
                        <p class="text-dark fs-5 mb-4">Recent Lost Items</p>
                    </div>
                </div>

                <?php
                $query = "SELECT * FROM lnf_itemlist ORDER BY lnf_timestamp DESC LIMIT 4";
                $result = mysqli_query($conn, $query);
                ?>

                <div class="container-fluid mt-2">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <!-- Display image with fallback -->
                                        <img src="<?php echo !empty($item['lnf_image']) ? 'uploads/' . $item['lnf_image'] : 'https://via.placeholder.com/400x200'; ?>"
                                            class="card-img-top" style="height:160px; object-fit:cover;"
                                            alt="<?php echo htmlspecialchars($item['lnf_item']); ?>">

                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title mb-1"><?php echo htmlspecialchars($item['lnf_item']); ?></h6>
                                            <p class="text-muted small mb-3 text-truncate"><?php echo htmlspecialchars($item['lnf_description']); ?></p>

                                            <!-- Optional: display 'time ago' using helper.php -->
                                            <?php if (function_exists('timeAgo')): ?>
                                                <p class="text-muted small mb-2"><i class="bi bi-clock me-2"></i><?php echo timeAgo($item['lnf_timestamp']); ?></p>
                                            <?php endif; ?>

                                            <a href="includes/item-page.php?lnf_id=<?php echo $item['lnf_id']; ?>" class="btn btn-primary btn-sm mt-auto w-100">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">No recent items reported yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>

        </div>
    </div>
</body>

</html>