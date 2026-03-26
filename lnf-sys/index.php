<?php
date_default_timezone_set('Asia/Manila');
require_once "db_connection.php";
require_once "shared/helper.php";
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

<!-- Shared Item Preview Modal -->
<div class="modal fade" id="itemPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" id="itemPreviewContent">
            <!-- Content will be loaded dynamically from PHP -->
        </div>
    </div>
</div>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php
            require_once "shared/user-nav.php";
            ?>

            <main class="col-md-9 col-lg-10 p-4 mt-2">
                <h2 class="mt-4 text-dark fw-bold">Welcome to Findly</h2>
                <p class="pt-1 text-dark fs-5">Track, report and recover lost items in OLLC easily!</p>

                <div class="direct-buttons d-flex gap-5 align-items-start mb-4">

                    <div class="mt-2">
                        <a class="btn btn-primary btn-sm rounded-2 me-1 ps-3 px-3" href="includes/lnf-item-list.php">
                            See Lost Items
                            <i class="bi bi-arrow-bar-right"></i>
                        </a>

                        <a class="btn btn-outline-danger btn-sm rounded-2 ps-3 px-3" href="includes/lnf-item-report.php">
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
                // Fetch only approved items
                $query = "SELECT * FROM lnf_itemlist WHERE lnf_approval = 'approved' AND lnf_status != 'claimed' ORDER BY lnf_timestamp DESC LIMIT 4";
                $result = mysqli_query($conn, $query);
                ?>

                <div class="container-fluid mt-2">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($item = mysqli_fetch_assoc($result)): ?>

                                <?php
                                // Get badge info for this item
                                $badge = getStatusBadge($item['lnf_status']);
                                ?>

                                <!-- Item Card -->

                                <div class="col">
                                    <div class="card h-100 shadow-sm position-relative">
                                        <!-- Item Image -->
                                        <img src="<?php echo !empty($item['lnf_image']) ? 'uploads/' . $item['lnf_image'] : 'https://via.placeholder.com/400x200'; ?>"
                                            class="card-img-top" style="height:160px; object-fit:cover;"
                                            alt="<?php echo htmlspecialchars($item['lnf_item']); ?>">

                                        <!-- Status Badge -->
                                        <span class="badge <?php echo $badge['color']; ?> position-absolute top-0 start-0 m-2 py-1 px-2">
                                            <?php echo $badge['text']; ?>
                                        </span>

                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title mb-1"><?php echo htmlspecialchars($item['lnf_item']); ?></h6>
                                            <p class="text-muted small mb-2 text-truncate"><?php echo htmlspecialchars($item['lnf_description']); ?></p>

                                            <?php if (function_exists('timeAgo')): ?>
                                                <p class="text-muted small mb-2"><i class="bi bi-clock me-2"></i><?php echo timeAgo($item['lnf_timestamp']); ?></p>
                                            <?php endif; ?>

                                            <button
                                                class="btn btn-primary btn-sm mt-auto w-100 view-item-btn"
                                                data-id="<?php echo $item['lnf_id']; ?>">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">No approved items reported yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Item Preview Modal JS -->
    <script>
        document.querySelectorAll('.view-item-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;

                fetch('shared/item_modal.php?lnf_id=' + id)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('itemPreviewContent').innerHTML = html;
                        const modal = new bootstrap.Modal(document.getElementById('itemPreviewModal'));
                        modal.show();
                    })
                    .catch(err => console.error('Failed to load item:', err));
            });
        });
    </script>
</body>

</html>