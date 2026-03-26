<?php
require_once "../db_connection.php";
require_once "../shared/helper.php";
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>New Document</title>
    <base href="../">

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
            require_once "../shared/user-nav.php";
            ?>

            <main class="col-md-9 col-lg-10 p-4 mt-4">
                <h2 class="fw-bold">Lost Items</h2>
                <p class="text-dark fs-5">Browse items reported as lost within the OLLC campus.</p>
                <p class="text-muted">If you recognize an item, please help by informing the owner.</p>
                <hr>

                <div class="row align-items-center mb-4">

                    <form method="get" class="row align-items-center mb-4">

                        <div class="col-md-4">
                            <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="form-control form-control-sm" placeholder="Search items...">
                        </div>

                        <!-- Filter by Category -->

                        <div class="col-md-2">
                            <select name="category" class="form-select form-select-sm">
                                <option value="" <?php if (empty($_GET['category'])) echo 'selected'; ?>>All Categories</option>
                                <option value="Electronics" <?php if (isset($_GET['category']) && $_GET['category'] == 'Electronics') echo 'selected'; ?>>Electronics</option>
                                <option value="ID / Documents" <?php if (isset($_GET['category']) && $_GET['category'] == 'ID / Documents') echo 'selected'; ?>>ID / Documents</option>
                                <option value="Bags" <?php if (isset($_GET['category']) && $_GET['category'] == 'Bags') echo 'selected'; ?>>Bags</option>
                                <option value="Accessories" <?php if (isset($_GET['category']) && $_GET['category'] == 'Accessories') echo 'selected'; ?>>Accessories</option>
                                <option value="Others" <?php if (isset($_GET['category']) && $_GET['category'] == 'Others') echo 'selected'; ?>>Others</option>
                            </select>
                        </div>

                        <!-- Sort Items -->

                        <div class="col-md-2">
                            <select name="sort" class="form-select form-select-sm">
                                <option value="desc" <?php if (!isset($_GET['sort']) || $_GET['sort'] == 'desc') echo 'selected'; ?>>Newest First</option>
                                <option value="asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'asc') echo 'selected'; ?>>Oldest First</option>
                            </select>
                        </div>

                        <!-- Filter by Status -->

                        <div class="col-md-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="" <?php if (empty($_GET['status'])) echo 'selected' ?>>Show All</option>
                                <option value="lost" <?php if (isset($_GET['status']) && $_GET['status'] == 'lost') echo 'selected'; ?>>Missing items</option>
                                <option value="found" <?php if (isset($_GET['status']) && $_GET['status'] == 'found') echo 'selected'; ?>>Found items</option>
                                <option value="claimed" <?php if (isset($_GET['status']) && $_GET['status'] == 'claimed') echo 'selected'; ?>>Claimed</option>
                            </select>
                        </div>

                        <!-- Apply Filter -->

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filter</button>
                        </div>

                    </form>

                </div>

                <?php
                // Get filter values from GET
                $search   = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
                $status   = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
                $sort     = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'ASC' : 'DESC';

                $where = [];

                // Search filter
                if (!empty($search)) {
                    $where[] = "(lnf_item LIKE '%$search%' OR lnf_description LIKE '%$search%')";
                }

                // Category filter
                if (!empty($category)) {
                    $where[] = "lnf_category = '$category'";
                }

                // Status filter logic
                if (!empty($status)) {
                    // If user selected a specific status, show only that
                    $where[] = "lnf_status = '$status'";
                } else {
                    // Default / Show All: only Lost and Found, exclude Claimed
                    $where[] = "lnf_status != 'claimed'";
                }

                // Only approved items
                $where[] = "lnf_approval = 'approved'";

                // Build WHERE clause
                $whereSQL = '';
                if (count($where) > 0) {
                    $whereSQL = "WHERE " . implode(" AND ", $where);
                }

                // Final query
                $query = "SELECT * FROM lnf_itemlist $whereSQL ORDER BY lnf_timestamp $sort";
                $result = mysqli_query($conn, $query);
                ?>

                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                                <div class="col">

                                    <!-- Item Cards -->
                                    <div class="card h-100 shadow-sm position-relative">

                                        <!-- Card Image -->
                                        <img src="<?php echo !empty($item['lnf_image']) ? 'uploads/' . $item['lnf_image'] : 'https://via.placeholder.com/400x200'; ?>"
                                            class="card-img-top" style="height:160px; object-fit:cover;" alt="<?php echo htmlspecialchars($item['lnf_item']); ?>">

                                        <?php
                                        $badge = getStatusBadge($item['lnf_status']);
                                        ?>

                                        <span class="badge <?php echo $badge['color']; ?> position-absolute top-0 start-0 m-2 py-1 px-2">
                                            <?php echo $badge['text']; ?>
                                        </span>

                                        <!-- Card Body/Desc -->
                                        <div class="card-body d-flex flex-column">

                                            <!-- Title ng Item -->
                                            <h6 class="card-title mb-1"><?php echo htmlspecialchars($item['lnf_item']); ?></h6>

                                            <!-- Description ng Item -->
                                            <p class="text-muted small mb-3 text-truncate"><?php echo htmlspecialchars($item['lnf_description']); ?></p>

                                            <!-- View Button -->
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
                            <p class="text-muted">No items match your search/filter criteria.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

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