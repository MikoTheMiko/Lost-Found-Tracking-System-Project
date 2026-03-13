<?php
date_default_timezone_set('Asia/Manila'); // ensure correct time zone
require_once "db_connection.php";
require_once "helper.php";

// Get item ID from URL
$item_id = isset($_GET['lnf_id']) ? intval($_GET['lnf_id']) : 0;
if ($item_id <= 0) {
    echo "<div class='container py-4'><p class='text-danger'>Invalid item ID.</p></div>";
    exit;
}

// Fetch item
$query = "SELECT * FROM lnf_itemlist WHERE lnf_id = $item_id LIMIT 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    echo "<div class='container py-4'><p class='text-muted'>Item not found.</p></div>";
    exit;
}
$item = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<base href="../">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($item['lnf_item']); ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .item-image {
            max-height: 400px;
            object-fit: cover;
        }

        .detail-label {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container py-5">

        <a href="lnf-index.php" class="btn btn-outline-secondary mb-4">
            &larr; Back to Dashboard
        </a>

        <div class="card shadow-sm bg-light p-4">
            <!-- Item Image -->
            <?php if (!empty($item['lnf_image'])): ?>
                <img src="uploads/<?php echo $item['lnf_image']; ?>" alt="<?php echo htmlspecialchars($item['lnf_item']); ?>" class="img-fluid rounded item-image mb-4 w-100">
            <?php else: ?>
                <img src="https://via.placeholder.com/800x400?text=No+Image" alt="No Image" class="img-fluid rounded item-image mb-4 w-100">
            <?php endif; ?>

            <!-- Item Info -->
            <h2 class="fw-bold"><?php echo htmlspecialchars($item['lnf_item']); ?></h2>
            <p class="text-muted small mb-3"><i class="bi bi-clock me-2"></i><?php echo timeAgo($item['lnf_timestamp']); ?></p>
            <hr>
            <div class="row g-3">
                <div class="col-md-6 d-flex">
                    <p class="detail-label me-4 text-primary"><i class="bi bi-tags me-2"></i>Category:</p>
                    <p class="bg-primary px-4 text-white rounded-2"><?php echo htmlspecialchars($item['lnf_category']); ?></p>
                </div>
                <div class="col-md-6 d-flex">
                    <p class="detail-label me-4 text-primary"><i class="bi bi-geo-alt me-2"></i>Location Found:</p>
                    <p class="bg-primary px-4 text-white rounded-2"><?php echo htmlspecialchars($item['lnf_location']); ?></p>
                </div>
                <?php if (!empty($item['lnf_contact'])): ?>
                    <div class="col-md-6 d-flex">
                        <p class="detail-label me-4 text-primary"><i class="bi bi-person-lines-fill me-2"></i>Contact Me:</p>
                        <p class="bg-primary px-4 text-white rounded-2"><?php echo htmlspecialchars($item['lnf_contact']); ?></p>
                    </div>
                <?php endif; ?>
                <div class="col-12">
                    <p class="detail-label text-dark">Description:</p>
                    <p><?php echo nl2br(htmlspecialchars($item['lnf_description'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>