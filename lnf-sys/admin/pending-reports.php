<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_connection.php";

// Handle approve/reject actions
if (isset($_POST['action']) && isset($_POST['lnf_id'])) {
    $reportId = intval($_POST['lnf_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE lnf_itemlist SET lnf_approval = 'approved' WHERE lnf_id = ?");
        $stmt->bind_param("i", $reportId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE lnf_itemlist SET lnf_approval = 'rejected' WHERE lnf_id = ?");
        $stmt->bind_param("i", $reportId);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch pending reports
$query = "SELECT * FROM lnf_itemlist WHERE lnf_approval = 'pending' ORDER BY lnf_timestamp DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pending Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .report-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php require_once 'admin-nav.php'; ?>

    <div class="container pt-3">
        <h4 class="text-primary">Pending Reports</h4>
        <p class="text-secondary">See all pending reports below.</p>
        <hr class="text-muted">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td class="text-truncate"><?= $row['lnf_id'] ?></td>
                            <td class="text-truncate"><?= htmlspecialchars($row['lnf_item']) ?></td>
                            <td class="text-truncate"><?= htmlspecialchars($row['lnf_category']) ?></td>
                            <td class="text-truncate"><?= htmlspecialchars($row['lnf_location']) ?></td>
                            <td class="text-truncate"><?= $row['lnf_timestamp'] ?></td>
                            <td>
                                <!-- View Detail Button -->
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['lnf_id'] ?>">
                                    View Report
                                </button>

                                <!-- Approve Button -->
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="lnf_id" value="<?= $row['lnf_id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <!-- Reject Button -->
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="lnf_id" value="<?= $row['lnf_id'] ?>">
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>

                                <!-- Modal for Full Detail -->
                                <div class="modal fade" id="detailModal<?= $row['lnf_id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row['lnf_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel<?= $row['lnf_id'] ?>">Report Details: <?= htmlspecialchars($row['lnf_item']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Category:</strong> <?= htmlspecialchars($row['lnf_category']) ?></p>
                                                <p><strong>Location:</strong> <?= htmlspecialchars($row['lnf_location']) ?></p>
                                                <p><strong>Description:</strong> <?= htmlspecialchars($row['lnf_description']) ?></p>
                                                <p><strong>Contact:</strong> <?= htmlspecialchars($row['lnf_contact']) ?></p>
                                                <p><strong>Status:</strong> <?= htmlspecialchars($row['lnf_status']) ?></p>
                                                <?php if (!empty($row['lnf_image'])): ?>
                                                    <img src="../uploads/<?= htmlspecialchars($row['lnf_image']) ?>" alt="Item Image" class="img-fluid">
                                                <?php else: ?>
                                                    <p>No image provided.</p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No pending reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>